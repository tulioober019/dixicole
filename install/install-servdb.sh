#!/bin/bash

# Instalación dos paquetes
declare -a PAQUETES=(
	"mariadb-server"
	"cockpit"
	"iptables"
	"iptables-persistent"
)

declare ARGS=""

for PAQUETE in ${PAQUETES[@]}; do
	ARGS="$ARGS$PAQUETE "
done

apt-get update
apt-get install $ARGS -y

systemctl restart vsftpd.service

# Definición das regras.
iptables -P INPUT DROP
iptables -P OUTPUT DROP

declare -A REGRAS

# Conexións do servidor a outros sitios (repositorios, etc...)
REGRAS[0,cadea]="INPUT" &&  REGRAS[0,interface]="eth0" && REGRAS[0,protocolo]="tcp" && REGRAS[0,porto_orixe]="443" && REGRAS[0,porto_destino]="any" && REGRAS[0,accion]="ACCEPT"
REGRAS[1,cadea]="OUTPUT" && REGRAS[1,interface]="eth0" && REGRAS[1,protocolo]="tcp" && REGRAS[1,porto_orixe]="any" && REGRAS[1,porto_destino]="443" && REGRAS[1,accion]="ACCEPT"

REGRAS[2,cadea]="INPUT" &&  REGRAS[2,interface]="eth0" && REGRAS[2,protocolo]="tcp" && REGRAS[2,porto_orixe]="80"  && REGRAS[2,porto_destino]="any" && REGRAS[2,accion]="ACCEPT"
REGRAS[3,cadea]="OUTPUT" && REGRAS[3,interface]="eth0" && REGRAS[3,protocolo]="tcp" && REGRAS[3,porto_orixe]="any" && REGRAS[3,porto_destino]="80"  && REGRAS[3,accion]="ACCEPT"

# Conexións ao cockpit
REGRAS[4,cadea]="INPUT" &&  REGRAS[4,interface]="eth0" && REGRAS[4,protocolo]="tcp" && REGRAS[4,porto_orixe]="any"  && REGRAS[4,porto_destino]="9090" && REGRAS[4,accion]="ACCEPT"
REGRAS[5,cadea]="OUTPUT" && REGRAS[5,interface]="eth0" && REGRAS[5,protocolo]="tcp" && REGRAS[5,porto_orixe]="9090" && REGRAS[5,porto_destino]="any"  && REGRAS[5,accion]="ACCEPT"

# Conexións ssh
REGRAS[6,cadea]="INPUT" &&  REGRAS[6,interface]="eth0" && REGRAS[6,protocolo]="tcp" && REGRAS[6,porto_orixe]="any" && REGRAS[6,porto_destino]="22"  && REGRAS[6,accion]="ACCEPT"
REGRAS[7,cadea]="OUTPUT" && REGRAS[7,interface]="eth0" && REGRAS[7,protocolo]="tcp" && REGRAS[7,porto_orixe]="22"  && REGRAS[7,porto_destino]="any" && REGRAS[7,accion]="ACCEPT"

# Conexións dende o servidor ftpd.
REGRAS[8,cadea]="INPUT" &&  REGRAS[8,interface]="eth0" && REGRAS[8,protocolo]="tcp" && REGRAS[8,porto_orixe]="any"  && REGRAS[8,porto_destino]="3306" && REGRAS[8,accion]="ACCEPT"
REGRAS[9,cadea]="OUTPUT" && REGRAS[9,interface]="eth0" && REGRAS[8,protocolo]="tcp" && REGRAS[9,porto_orixe]="3306" && REGRAS[9,porto_destino]="any"  && REGRAS[9,accion]="ACCEPT"

REGRAS[10,cadea]="INPUT" &&  REGRAS[10,interface]="eth0" && REGRAS[10,protocolo]="tcp" && REGRAS[10,porto_orixe]="22"  && REGRAS[10,porto_destino]="any" && REGRAS[10,accion]="ACCEPT"
REGRAS[11,cadea]="OUTPUT" && REGRAS[11,interface]="eth0" && REGRAS[11,protocolo]="tcp" && REGRAS[11,porto_orixe]="any" && REGRAS[11,porto_destino]="22"  && REGRAS[11,accion]="ACCEPT"

# Conexións dns
REGRAS[12,cadea]="INPUT" &&  REGRAS[12,interface]="eth0" && REGRAS[12,protocolo]="udp" && REGRAS[12,porto_orixe]="53"  && REGRAS[12,porto_destino]="any" && REGRAS[12,accion]="ACCEPT"
REGRAS[13,cadea]="OUTPUT" && REGRAS[13,interface]="eth0" && REGRAS[13,protocolo]="udp" && REGRAS[13,porto_orixe]="any" && REGRAS[13,porto_destino]="53"  && REGRAS[13,accion]="ACCEPT"

# Conexións dhcp
REGRAS[14,cadea]="INPUT" &&  REGRAS[14,interface]="eth0" && REGRAS[14,protocolo]="udp" && REGRAS[14,porto_orixe]="67"  && REGRAS[14,porto_destino]="any" && REGRAS[14,accion]="ACCEPT"
REGRAS[15,cadea]="OUTPUT" && REGRAS[15,interface]="eth0" && REGRAS[15,protocolo]="udp" && REGRAS[15,porto_orixe]="any" && REGRAS[15,porto_destino]="67"  && REGRAS[15,accion]="ACCEPT"

REGRAS[16,cadea]="INPUT" &&  REGRAS[16,interface]="eth0" && REGRAS[16,protocolo]="udp" && REGRAS[16,porto_orixe]="any" && REGRAS[16,porto_destino]="68"  && REGRAS[16,accion]="ACCEPT"
REGRAS[17,cadea]="OUTPUT" && REGRAS[17,interface]="eth0" && REGRAS[17,protocolo]="udp" && REGRAS[17,porto_orixe]="67"  && REGRAS[17,porto_destino]="any" && REGRAS[17,accion]="ACCEPT"

declare -i LONXITUDE=$((${#REGRAS[@]}/6))

for ((NREGRA=0;$NREGRA<$LONXITUDE;NREGRA++)){
	declare cadea=${REGRAS[${NREGRA},cadea]}
	declare interface=${REGRAS[${NREGRA},interface]}
	declare protocolo=${REGRAS[${NREGRA},protocolo]}
	declare porto_orixe=${REGRAS[${NREGRA},porto_orixe]}
	declare porto_destino=${REGRAS[${NREGRA},porto_destino]}
	declare accion=${REGRAS[${NREGRA},accion]}

	if [ $cadea = "INPUT" ]
	then
		if [ $porto_orixe = "any" ]
		then
			iptables -A $cadea -i $interface -p $protocolo --dport $porto_destino -j $accion
		elif [ $porto_destino = "any" ]
		then
			iptables -A $cadea -i $interface -p $protocolo --sport $porto_orixe -j $accion
		fi
	elif [ $cadea = "OUTPUT" ]
	then
		if [ $porto_orixe = "any" ]
		then
                        iptables -A $cadea -o $interface -p $protocolo --dport $porto_destino -j $accion

		elif [ $porto_destino = "any" ]
                then
                        iptables -A $cadea -o $interface -p $protocolo --sport $porto_orixe -j $accion
                fi

	fi
}

iptables -A INPUT -i lo -j ACCEPT
iptables -A OUTPUT -o lo -j ACCEPT

iptables-save > /etc/iptables/rules.v4

rm /etc/ssh/sshd_config.d/*.conf

systemctl restart ssh.service
