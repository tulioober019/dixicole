USE dixicole;

CREATE VIEW vis_usuario AS 
SELECT usu_id as usu_id, 
	usu_nome,
    usu_apelido1,
    usu_apelido2,
    usu_telefono,
    usu_correo,
    usu_nomeusuario,
    usu_contrasinal
FROM tab_usuario;

CREATE VIEW vis_matriculas AS SELECT a.usu_id as usu_idalumno,
    c.cur_id as cur_id,
	c.cur_nome as cur_nome,
    c.cur_descricion as cur_descricion,
    c.cur_profe as cur_idprofe,
    CONCAT(p.usu_apelido1, " ",p.usu_apelido2, ", ", p.usu_nome) as usu_nomeprofe,
    "Alumno" as rol
    FROM tab_usuario a INNER JOIN tab_matricula mk ON (a.usu_id = mk.mak_alumno) 
    INNER JOIN tab_curso c ON (mk.mak_curso = c.cur_id)
    INNER JOIN tab_usuario p ON (c.cur_profe = p.usu_id);

CREATE VIEW vis_cursos_creados AS SELECT p.usu_id as usu_idalumno,
    c.cur_id as cur_id,
	c.cur_nome as cur_nome,
    c.cur_descricion as cur_descricion,
    c.cur_profe as cur_idprofe,
    CONCAT(p.usu_apelido1, " ",p.usu_apelido2, ", ", p.usu_nome) as usu_nomeprofe,
    "Profesor" as rol
    FROM tab_curso c INNER JOIN tab_usuario p ON (c.cur_profe = p.usu_id);
    
CREATE VIEW vis_cursos_usuario AS SELECT * FROM vis_cursos_creados UNION SELECT * FROM vis_matriculas;

CREATE VIEW vis_topicos_curso AS SELECT * FROM tab_topico;

CREATE VIEW vis_recursos AS 
	SELECT act_id as id, 
		act_nome as nome, 
        CONCAT("?id=", act_id) as url, 
        "Actividade" as ubicacion, 
        act_topico as topico, 
        act_curso as curso FROM tab_actividade
	UNION
	SELECT rec_id as id, 
		rec_nome as nome, 
		rec_url as url, 
		rec_ubicacion as ubicacion, 
		rec_topico as topico,
		rec_curso as curso FROM tab_recurso;

CREATE VIEW vis_infoactividade AS 
	SELECT * FROM tab_actividade;
    
/*CREATE VIEW vis_matriculasalumnos AS 
	SELECT * FROM tab_usuario u INNER JOIN tab_matricula m ON (m.mak_alumno = u.usu_id);*/

CREATE VIEW vis_entregados AS 
SELECT e.ent_alumno as id,
	CONCAT(u.usu_apelido1, " ", u.usu_apelido2, ", ", u.usu_nome) as alumno,
    e.ent_actividade as actividade,
    e.ent_url as url,
    e.ent_calif as calif,
    e.ent_comment as commentario
	FROM tab_actividade a INNER JOIN tab_entrega e ON (a.act_id = e.ent_alumno)
    INNER JOIN tab_usuario u ON (u.usu_id = e.ent_alumno);