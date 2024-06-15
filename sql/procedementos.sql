USE dixicole;

DELIMITER ;;

CREATE PROCEDURE pro_engadir_curso (IN nome VARCHAR(100), IN descricion TEXT, IN profe INT, IN codigo CHAR(7))
BEGIN
    # Acción a executar.
    INSERT INTO tab_curso SET
    	cur_nome = nome,
        cur_descricion = descricion,
        cur_profe = profe,
        cur_codigo = codigo;
END;;

CREATE PROCEDURE pro_matricula (IN alumno INT, IN curso INT)
BEGIN
	INSERT INTO tab_matricula SET 
    	mak_alumno = alumno, 
    	mak_curso = curso,
        mak_data = NOW();
END;;

CREATE PROCEDURE pro_insertar_topico (IN nome VARCHAR(100), IN curso INT)
BEGIN    
    INSERT INTO tab_topico SET
    	top_nome = nome,
        top_curso = curso;
END;;

CREATE PROCEDURE pro_engadir_recurso (IN url TEXT, IN nome VARCHAR(100), IN ubicacion VARCHAR(100), IN topico INT, IN curso INT)
BEGIN
	INSERT INTO tab_recurso SET
    	rec_url = url,
        rec_nome = nome,
        rec_ubicacion = ubicacion,
        rec_topico = topico,
        rec_curso = curso;
END;;

CREATE PROCEDURE pro_engadir_actividade (IN nome VARCHAR(100), IN descricion TEXT, IN puntmax FLOAT, IN topico INT, IN curso INT)
BEGIN
	INSERT INTO tab_actividade SET
		act_nome = nome,
        act_descricion = descricion,
        act_puntmax = puntmax,
        act_topico = topico,
        act_curso = curso;
END;;

CREATE PROCEDURE pro_entregar_actividade (IN alumno INT, IN actividade INT, IN url TEXT)
BEGIN
    INSERT INTO tab_entrega SET 
		ent_alumno = alumno,
        ent_actividade = actividade,
        ent_url = url;
END;;

CREATE PROCEDURE pro_rexistrar_usuario (IN nome VARCHAR(100), IN apelido1 VARCHAR(100), IN apelido2 VARCHAR(100), IN telefono CHAR(9), IN correo VARCHAR(200), IN nusuario VARCHAR(100), IN contrasinal VARCHAR(100))
BEGIN
	INSERT INTO tab_usuario SET usu_nome = nome,
		usu_apelido1 = apelido1,
        usu_apelido2 = apelido2,
        usu_telefono = telefono,
        usu_correo = correo,
        usu_nomeusuario = nusuario,
        usu_contrasinal = sha2(contrasinal,512);
END;;
DELIMITER ;