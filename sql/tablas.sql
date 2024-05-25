USE dixicole;

/*La tabla usuario contiene información sobre los usuarios registrados en las sistemas informáticos de Dixicole*/

CREATE TABLE IF NOT EXISTS tab_usuario (
	usu_id			INT	AUTO_INCREMENT			COMMENT "Os identificadores vanse almacenar en binario posto que o tamaño dos caracteres e axustado adecuadamente",
    usu_nome		VARCHAR(100)	NOT NULL	COMMENT "Nome real do usuario",
    usu_apelido1	VARCHAR(100)	NOT NULL	COMMENT "Primeiro apelido do usuario",
    usu_apelido2	VARCHAR(100)	NULL		COMMENT "Segundo apelido do usaurio se existe",
    usu_telefono	CHAR(9)			NULL		COMMENT "Teléfono do alumnado ou profesor",
    usu_correo		VARCHAR(200)	NOT NULL	COMMENT "Correo do usuario",
    usu_nomeusuario	VARCHAR(100)	NOT NULL	COMMENT "Nombre de login do usuario",
    usu_contrasinal	CHAR(128)	NOT NULL	COMMENT "Contrasinal do usuario almacenado en hash sha-512",
    CONSTRAINT 		pk_usuario		PRIMARY KEY(usu_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tab_curso (
	cur_id			INT	AUTO_INCREMENT			COMMENT "O identificador do curso será a concatenación de cur, as tres primeiras letras do nome de dito curso máis a data de alta e tempo de alta separadas por guións",
    cur_nome		VARCHAR(100)	NOT NULL	COMMENT "Nome descritivo do curso",
    cur_descricion	TEXT			NOT NULL	COMMENT "Descrición do curso",
    cur_profe		INT 			NOT NULL	COMMENT "Profe que imparte dito curso. Normalmente, os profesores son os creadores do curso.",
    cur_codigo		CHAR(7)			NOT NULL	COMMENT "Trátase dun código alfanumérico de sete caractéres na cal emprégase para a matrícula do alumnado. É definido polo profesor",
    CONSTRAINT 		pk_curso		PRIMARY KEY (cur_id),
    CONSTRAINT 		fk_profe_curso	FOREIGN KEY (cur_profe)	REFERENCES tab_usuario (usu_id)		ON UPDATE CASCADE 		ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tab_topico (
	top_id			INT	AUTO_INCREMENT			COMMENT "",
    top_nome		VARCHAR(100)	NOT NULL	COMMENT "Nome descritivo do tópico",
    top_curso		INT				NOT NULL	COMMENT "Curso que pertenécese o tópico",
    CONSTRAINT		pk_topico		PRIMARY KEY (top_id),
    CONSTRAINT 		fk_topico_curso	FOREIGN KEY (top_curso) REFERENCES tab_curso (cur_id)		ON UPDATE CASCADE 		ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tab_matricula (
    mak_alumno		INT			 			COMMENT "Fai referencia ao alumno matriculado",
    mak_curso		INT						COMMENT "Fai referencia ao curso na cal está matriculado o alumno",
    mak_data		TIMESTAMP	NOT NULL	COMMENT "Almacena a data no que o alumno deuse de alta no curso",
    CONSTRAINT 		pk_matricula			PRIMARY KEY (mak_alumno, mak_curso),
    CONSTRAINT 		fk_matricula_alumno		FOREIGN KEY (mak_alumno) REFERENCES tab_usuario(usu_id)		ON UPDATE CASCADE		ON DELETE RESTRICT,
    CONSTRAINT 		fk_matricula_curso		FOREIGN KEY (mak_curso)	 REFERENCES tab_curso(cur_id)		ON UPDATE CASCADE		ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tab_recurso (
    rec_id			INT	AUTO_INCREMENT		COMMENT "Identificador do recurso",
    rec_nome		VARCHAR(100)			COMMENT "Nome do recurso",
    rec_url			TEXT		NOT NULL	COMMENT "Ruta ao recurso",
    rec_ubicacion	ENUM("URL","Local")		COMMENT "Ubicación do recurso. Pode ser mediante un fonte externo (URL) ou interno (Local)",
    rec_topico		INT						COMMENT "Topico que pode ou non o recurso",
    rec_curso		INT			NOT NULL	COMMENT "Curso en que ubica o recurso",
    CONSTRAINT		pk_recurso				PRIMARY KEY (rec_id),
    CONSTRAINT		fk_topico_recurso		FOREIGN KEY (rec_topico)	REFERENCES tab_topico (top_id)	ON UPDATE CASCADE	ON DELETE RESTRICT,
    CONSTRAINT		fk_curso_recurso		FOREIGN KEY (rec_curso)		REFERENCES tab_curso (cur_id)	ON UPDATE CASCADE	ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tab_actividade (
	act_id			INT	AUTO_INCREMENT			COMMENT "Identificador da actividade",
    act_nome		VARCHAR(100)	NOT NULL	COMMENT "Nome da actividade",
    act_descricion	TEXT			NOT NULL	COMMENT "Descrición, enunciado da actividade",
    act_puntmax		FLOAT 			NOT NULL	COMMENT "Puntuación máxima que pode obter o alumno se e indicado",
    act_puntmin		FLOAT 						COMMENT "Puntuacion para aprobar" DEFAULT 0.00,
    act_datalim		TIMESTAMP					COMMENT "Data limite para aceptar entregas, se o houbese",
    act_topico		INT							COMMENT "Tópico que pode ou non pertenecer a actividade",
    act_curso		INT				NOT NULL	COMMENT "Curso en que ubica a actividade",
    CONSTRAINT		pk_actividade				PRIMARY KEY (act_id),
    CONSTRAINT		fk_topico_actividade		FOREIGN KEY (act_topico)	REFERENCES tab_topico (top_id)	ON UPDATE CASCADE	ON DELETE RESTRICT,
    CONSTRAINT		fk_curso_actividade			FOREIGN KEY (act_curso)		REFERENCES tab_curso (cur_id)	ON UPDATE CASCADE	ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tab_entrega (
	ent_alumno		INT						COMMENT "Alumno que vai realizar a entrega",
    ent_actividade	INT						COMMENT "Actividade que se vai entregar",
    ent_data		TIMESTAMP	NOT NULL	COMMENT "Instante da entrega",
    ent_calif		FLOAT					COMMENT "Puntuación que recibe o alumno",
    ent_datacalif	TIMESTAMP	NOT NULL	COMMENT "Data en que o alumno recibiu a calificacion",
    ent_comment		TEXT					COMMENT "Comentario do profe sobre a calificación",
    CONSTRAINT		pk_entrega				PRIMARY KEY (ent_alumno, ent_actividade),
    CONSTRAINT		fk_alumno_entrega		FOREIGN KEY (ent_alumno)		REFERENCES tab_usuario (usu_id)		ON UPDATE CASCADE	ON DELETE RESTRICT,
    CONSTRAINT		fk_alumno_actividade	FOREIGN KEY (ent_actividade)	REFERENCES tab_actividade (act_ID)	ON UPDATE CASCADE	ON DELETE RESTRICT
) ENGINE=InnoDB;