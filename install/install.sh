#!/bin/bash

IP_ESCOITA=$1

function crear_redes() {
	declare IP_ESCOITA=$1

	declare -A REDES
	REDES[0,nome]="lan-web" && REDES[0,ip]="172.16.10.1/24"
	REDES[1,nome]="lan-ftpd" && REDES[1,ip]="172.16.20.1/24"
	REDES[2,nome]="lan-db" && REDES[2,ip]="172.16.40.1/24"
	REDES[3,nome]="lan-mail" && REDES[3,ip]="172.16.50.1/24"

	declare -i LONXITUDE=$((${#REDES[@]}/2))
	for ((I=0;I<$LONXITUDE;I++)) {

		declare NOME=${REDES[${I},nome]}
		declare	IP=${REDES[${I},ip]}

		if [ -z $(lxc network list --format "csv" | cut -d"," -f1 | grep ^$NOME$) ]
		then
			lxc network create $NOME ipv4.nat=true ipv4.address=$IP ipv4.dhcp=true
			IS_CREATED=1
		fi
	}

	declare -A PORT_FORWARD
	PORT_FORWARD[0,protocolo]="tcp" && PORT_FORWARD[0,porto]=443 && PORT_FORWARD[0,direccion_ip_target]="172.16.10.10" && PORT_FORWARD[0,porto_target]=443
	PORT_FORWARD[1,protocolo]="tcp" && PORT_FORWARD[1,porto]=445 && PORT_FORWARD[1,direccion_ip_target]="172.16.10.10" && PORT_FORWARD[1,porto_target]=445

	lxc network forward create lan-web $IP_ESCOITA

	LONXITUDE=$((${#REDES[@]}/4))
	for ((I=0;I<$LONXITUDE;I++)) {

		if [ $IS_CREATED -eq 1 ]
		then
			lxc network forward port add lan-web $IP_ESCOITA \
				${PORT_FORWARD[${I},protocolo]} \
				${PORT_FORWARD[${I},porto]} \
				${PORT_FORWARD[${I},direccion_ip_target]} \
				${PORT_FORWARD[${I},porto_target]}
		fi

	}

}

function crear_perfis() {

	declare -A PERFIS
	PERFIS[0,nome]="serv-web" && PERFIS[0,rede]="lan-web"
	PERFIS[1,nome]="serv-ftpd" && PERFIS[1,rede]="lan-ftpd"
	PERFIS[2,nome]="serv-db" && PERFIS[2,rede]="lan-db"
	PERFIS[3,nome]="serv-mail" && PERFIS[3,rede]="lan-mail"

	declare -i LONXITUDE=$((${#PERFIS[@]}/2))

	for ((I=0;I<$LONXITUDE;I++)) {

		declare NOME=${PERFIS[${I},nome]}
		declare REDE=${PERFIS[${I},rede]}

		if [ -z $(lxc profile list --format "csv" | cut -d"," -f1 | grep ^$NOME$) ]
		then

			lxc profile copy default $NOME && \
			lxc profile device remove $NOME eth0 && \
			lxc profile device add $NOME eth0 nic name=eth0 network=$REDE
		fi
	}
}

function crear_contenedores() {

	declare -A CONTENEDORES
	CONTENEDORES[0,nome]="serv-web-001" && CONTENEDORES[0,perfil]="serv-web" && CONTENEDORES[0,ip]="172.16.10.10"
	CONTENEDORES[1,nome]="serv-ftpd-001" && CONTENEDORES[1,perfil]="serv-ftpd" && CONTENEDORES[1,ip]="172.16.20.10"
	CONTENEDORES[2,nome]="serv-db-001" && CONTENEDORES[2,perfil]="serv-db" && CONTENEDORES[2,ip]="172.16.40.10"
	CONTENEDORES[3,nome]="serv-mail-001" && CONTENEDORES[3,perfil]="serv-mail" && CONTENEDORES[3,ip]="172.16.50.10"

	declare -i LONXITUDE=$((${#CONTENEDORES[@]}/3))

	for ((I=0;I<$LONXITUDE;I++)) {

		declare NOME=${CONTENEDORES[${I},nome]}
		declare PERFIL=${CONTENEDORES[${I},perfil]}
		declare IP=${CONTENEDORES[${I},ip]}

		if [ -z $(lxc list --format "csv" | cut -d"," -f1 | grep ^$NOME$) ]
		then

			lxc launch ubuntu:22.04 $NOME --profile=$PERFIL
			lxc config device override $NOME eth0 ipv4.address=$IP
			lxc restart $NOME
		fi
	}
}

function provisionar_contenedor() {

	declare CONTENEDOR=$1
	declare SCRIPT=$2
	
}


crear_redes $IP_ESCOITA

crear_perfis

crear_contenedores

