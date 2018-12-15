DROP DATABASE IF EXISTS DW4_PROXIMAFECHA;
CREATE DATABASE  DW4_PROXIMAFECHA;
USE DW4_PROXIMAFECHA;

DROP TABLE IF EXISTS FICHA_PARTIDO ;
DROP TABLE IF EXISTS TIPOS_ESTADISTICA ;
DROP TABLE IF EXISTS DUENOS ;
DROP TABLE IF EXISTS EQUIPOS_TORNEO ;
DROP TABLE IF EXISTS ORGANIZADORES ;
DROP TABLE IF EXISTS JUGADORES ;
DROP TABLE IF EXISTS MENSAJES ;
DROP TABLE IF EXISTS PARTIDOS ;
DROP TABLE IF EXISTS CANCHAS ;
DROP TABLE IF EXISTS FASES ;
DROP TABLE IF EXISTS EQUIPOS ;
DROP TABLE IF EXISTS USUARIOS ;
DROP TABLE IF EXISTS TORNEOS ;
DROP TABLE IF EXISTS SEDES ;
DROP TABLE IF EXISTS PROVINCIAS ;
DROP TABLE IF EXISTS PAISES ;
DROP TABLE IF EXISTS TIPOS_TORNEO ;
DROP TABLE IF EXISTS DEPORTES ;
DROP TABLE IF EXISTS ESTADOS_TORNEO;

CREATE TABLE DEPORTES (
  DEPORTE_ID INT NOT NULL AUTO_INCREMENT,
  DESCRIPCION VARCHAR(45) NULL,
  MAX_JUGADORES INT(2) NULL,
  PRIMARY KEY (DEPORTE_ID));

CREATE TABLE TIPOS_TORNEO (
  TIPO_TORNEO_ID VARCHAR(1) NOT NULL,
  DESCRIPCION VARCHAR(45) NOT NULL,
  PRIMARY KEY (TIPO_TORNEO_ID));

CREATE TABLE PAISES (
  PAIS_ID VARCHAR(3) NOT NULL,
  PAIS VARCHAR(45) NOT NULL,
  ISO VARCHAR(2) NOT NULL,
  PRIMARY KEY (PAIS_ID));

CREATE TABLE PROVINCIAS (
  PAIS_ID VARCHAR(3) NOT NULL,
  PROVINCIA_ID VARCHAR(3) NOT NULL,
  PROVINCIA VARCHAR(45) NOT NULL,
  PRIMARY KEY (PAIS_ID, PROVINCIA_ID),
  CONSTRAINT PROVPAISES   FOREIGN KEY (PAIS_ID)    REFERENCES PAISES (PAIS_ID)  ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE SEDES (
  SEDE_ID INT NOT NULL AUTO_INCREMENT,
  NOMBRE VARCHAR(45) NOT NULL,
  PAIS_ID VARCHAR(3) NOT NULL,
  PROVINCIA_ID VARCHAR(3) NOT NULL,
  CODIGO_POSTAL VARCHAR(10) NOT NULL,
  CALLE VARCHAR(45) NOT NULL,
  ALTURA INT(5) NOT NULL,
  TELEFONO VARCHAR(20) NOT NULL,
  DETALLES VARCHAR(200) NULL,
  REGISTRADO_DT DATE NULL ,
  PRIMARY KEY (SEDE_ID),
  CONSTRAINT SEDEPROVINCIAS  FOREIGN KEY (PAIS_ID , PROVINCIA_ID) REFERENCES PROVINCIAS (PAIS_ID , PROVINCIA_ID) ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE ESTADOS_TORNEO (
  ESTADO_TORNEO_ID CHAR(1) NOT NULL,
  DESCRIPCION VARCHAR(45) NOT NULL,
  PRIMARY KEY (ESTADO_TORNEO_ID));

CREATE TABLE TORNEOS (
  TORNEO_ID INT NOT NULL AUTO_INCREMENT,
  NOMBRE VARCHAR(60) NOT NULL,
  DEPORTE_ID INT NOT NULL,
  TIPO_TORNEO_ID VARCHAR(1) NOT NULL,
  CANTIDAD_EQUIPOS INT(2) NOT NULL,
  FECHA_INICIO DATE NULL,
  SEDE_ID INT NULL,
  ESTADO_TORNEO_ID CHAR(1) NOT NULL,
  REGISTRADO_DT DATE NULL ,
  PRIMARY KEY (TORNEO_ID),
  CONSTRAINT TORNEDEOIRTE FOREIGN KEY (DEPORTE_ID) REFERENCES DEPORTES (DEPORTE_ID)  ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT TORNETIPOTRNEO    FOREIGN KEY (TIPO_TORNEO_ID) REFERENCES TIPOS_TORNEO (TIPO_TORNEO_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT TORNESEDES   FOREIGN KEY (SEDE_ID)   REFERENCES SEDES (SEDE_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT TORNEESTATRNEO    FOREIGN KEY (ESTADO_TORNEO_ID) REFERENCES ESTADOS_TORNEO (ESTADO_TORNEO_ID) ON DELETE RESTRICT ON UPDATE CASCADE);


CREATE TABLE USUARIOS (
  USUARIO_ID VARCHAR(45) NOT NULL,
  PASSWORD VARCHAR(256) NOT NULL,
  NOMBRE VARCHAR(45) NOT NULL,
  APELLIDO VARCHAR(45) NOT NULL,
  EMAIL VARCHAR(45) NOT NULL,
  ACTIVO VARCHAR(1) NOT NULL DEFAULT 'Y',
  TELEFONO VARCHAR(20) NULL,
  ULTIMA_VEZ_ONLINE DATE NULL,
  REGISTRADO_DT DATE NULL ,
  ES_PRO  VARCHAR(1) NOT NULL DEFAULT 'N',
  ES_PRO_DT DATE NULL ,
  PRIMARY KEY (USUARIO_ID));

CREATE TABLE EQUIPOS (
  EQUIPO_ID INT NOT NULL AUTO_INCREMENT,
  NOMBRE VARCHAR(60) NOT NULL,
  CAPITAN_ID VARCHAR(45) NOT NULL,
  ACTIVO VARCHAR(1) NOT NULL DEFAULT 'Y',
  REGISTRADO_DT DATE NULL ,
  PRIMARY KEY (EQUIPO_ID),
  CONSTRAINT EQUIUSUARIOS    FOREIGN KEY (CAPITAN_ID)    REFERENCES USUARIOS (USUARIO_ID)    ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE FASES (
  TORNEO_ID INT NOT NULL,
  FASE_ID INT NOT NULL,
  DESCRIPCION VARCHAR(45) NOT NULL,
  FECHA DATE NULL,
  PRIMARY KEY (TORNEO_ID, FASE_ID),
  CONSTRAINT FASETORNEOS   FOREIGN KEY (TORNEO_ID)   REFERENCES TORNEOS (TORNEO_ID) ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE DIAS_TORNEO (
  TORNEO_ID INT NOT NULL,
  DIA_ID VARCHAR(1) NOT NULL,
  PRIMARY KEY (TORNEO_ID, DIA_ID),
  CONSTRAINT DIASTORNEOS   FOREIGN KEY (TORNEO_ID)   REFERENCES TORNEOS (TORNEO_ID) ON DELETE CASCADE ON UPDATE CASCADE);



CREATE TABLE CANCHAS (
  SEDE_ID INT NOT NULL,
  CANCHA_ID INT NOT NULL,
  DESCRIPCION VARCHAR(45) NOT NULL,
  DEPORTE_ID INT NOT NULL,
  PRECIO INT NOT NULL,
  PRIMARY KEY (SEDE_ID, CANCHA_ID),
  CONSTRAINT CANCHASEDES    FOREIGN KEY (SEDE_ID)    REFERENCES SEDES (SEDE_ID)   ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT CANCHADEPORTES FOREIGN KEY (DEPORTE_ID) REFERENCES DEPORTES (DEPORTE_ID)   ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE PARTIDOS (
  TORNEO_ID INT NOT NULL,
  FASE_ID INT NOT NULL,
  PARTIDO_ID INT NOT NULL ,
  LOCAL_ID INT NOT NULL,
  VISITA_ID INT NOT NULL,
  FECHA DATE NULL,
  HORA TIME(5) NULL,
  ARBITRO_ID VARCHAR(45) NULL,
  PUNTOS_LOCAL INT(3) NULL,
  PUNTOS_VISITA INT(3) NULL,
  LOCAL_OK VARCHAR(1) NULL,
  VISITA_OK VARCHAR(1) NULL,
  SEDE_ID INT NOT NULL,
  CANCHA_ID INT NOT NULL,
  JUGADO VARCHAR(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (TORNEO_ID, FASE_ID, PARTIDO_ID),
  CONSTRAINT PARTIFECHAS   FOREIGN KEY (TORNEO_ID , FASE_ID)   REFERENCES FASES (TORNEO_ID , FASE_ID)   ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT PARTIEQUILOC  FOREIGN KEY (LOCAL_ID)   REFERENCES EQUIPOS (EQUIPO_ID)   ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT PARTIEQUIVIS  FOREIGN KEY (VISITA_ID)  REFERENCES EQUIPOS (EQUIPO_ID)   ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT PARTIUSUARBI  FOREIGN KEY (ARBITRO_ID) REFERENCES USUARIOS (USUARIO_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT PARTICANCHAS1 FOREIGN KEY (SEDE_ID , CANCHA_ID)  REFERENCES CANCHAS (SEDE_ID , CANCHA_ID)  ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE MENSAJES (
  MENSAJE_ID INT NOT NULL AUTO_INCREMENT,
  MENSAJE LONGBLOB NOT NULL,
  EMISOR_ID VARCHAR(45) NOT NULL,
  RECEPTOR_ID VARCHAR(45) NULL,
  TORNEO_ID INT NULL,
  FECHA_ID INT NULL,
  PARTIDO_ID INT NULL,
  FECHA DATE NULL,
  HORA TIME(5) NULL,
  LEIDO VARCHAR(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (MENSAJE_ID),
  CONSTRAINT MENSAUSUEMI FOREIGN KEY (EMISOR_ID)  REFERENCES USUARIOS (USUARIO_ID)  ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT MENSAUSUREC FOREIGN KEY (RECEPTOR_ID)  REFERENCES USUARIOS (USUARIO_ID) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT MENSAPARTIDOS  FOREIGN KEY (TORNEO_ID , FECHA_ID , PARTIDO_ID) REFERENCES PARTIDOS (TORNEO_ID , FASE_ID , PARTIDO_ID)  ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE JUGADORES (
  EQUIPO_ID INT NOT NULL,
  JUGADOR_ID VARCHAR(45) NOT NULL,
  PRIMARY KEY (EQUIPO_ID, JUGADOR_ID),
  CONSTRAINT JUGAEQUIPOS  FOREIGN KEY (EQUIPO_ID)  REFERENCES EQUIPOS (EQUIPO_ID) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT JUGAUSUARIOS FOREIGN KEY (JUGADOR_ID) REFERENCES USUARIOS (USUARIO_ID) ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE ORGANIZADORES (
  TORNEO_ID INT NOT NULL,
  ORGANIZADOR_ID VARCHAR(45) NOT NULL,
  ACTIVO VARCHAR(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (TORNEO_ID, ORGANIZADOR_ID),
  CONSTRAINT ORGATORNEOS FOREIGN KEY (TORNEO_ID) REFERENCES TORNEOS (TORNEO_ID)  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT ORGAUSUARIOS FOREIGN KEY (ORGANIZADOR_ID) REFERENCES USUARIOS (USUARIO_ID)  ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE EQUIPOS_TORNEO (
  TORNEO_ID INT NOT NULL,
  EQUIPO_ID INT NOT NULL,
  PRIMARY KEY (TORNEO_ID, EQUIPO_ID),
  CONSTRAINT EQUITORNEOS  FOREIGN KEY (TORNEO_ID)  REFERENCES TORNEOS (TORNEO_ID)  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT EQUIEQUIPOS  FOREIGN KEY (EQUIPO_ID)  REFERENCES EQUIPOS (EQUIPO_ID)  ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE DUENOS (
  SEDE_ID INT NOT NULL,
  USUARIO_ID VARCHAR(45) NOT NULL,
  ACTIVO VARCHAR(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (SEDE_ID, USUARIO_ID),
  CONSTRAINT DUESEDES  FOREIGN KEY (SEDE_ID) REFERENCES SEDES (SEDE_ID)  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT DUEUSUARIOS    FOREIGN KEY (USUARIO_ID)  REFERENCES USUARIOS (USUARIO_ID)   ON DELETE RESTRICT ON UPDATE CASCADE);

CREATE TABLE TIPOS_ESTADISTICA (
  TIPO_ESTADISTICA_ID CHAR(1) NOT NULL,
  DESCRIPCION VARCHAR(45) NOT NULL,
  PRIMARY KEY (TIPO_ESTADISTICA_ID));

CREATE TABLE FICHA_PARTIDO (
  TORNEO_ID INT NOT NULL,
  FASE_ID INT NOT NULL,
  PARTIDO_ID INT NOT NULL,
  FICHA_ID INT NOT NULL ,
  TIPO_ESTADISTICA_ID CHAR(1) NOT NULL,
  EQUIPO_ID INT NOT NULL,
  JUGADOR_ID VARCHAR(45) NOT NULL,
  PRIMARY KEY (TORNEO_ID, FASE_ID, PARTIDO_ID, FICHA_ID),
  CONSTRAINT FICHAPARTIDOS   FOREIGN KEY (TORNEO_ID , FASE_ID , PARTIDO_ID)  REFERENCES PARTIDOS (TORNEO_ID , FASE_ID , PARTIDO_ID)  ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FICHATIPOS     FOREIGN KEY (TIPO_ESTADISTICA_ID)   REFERENCES TIPOS_ESTADISTICA (TIPO_ESTADISTICA_ID)  ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT FICHAJUGADORES   FOREIGN KEY (EQUIPO_ID , JUGADOR_ID)  REFERENCES JUGADORES (EQUIPO_ID , JUGADOR_ID)   ON DELETE RESTRICT ON UPDATE CASCADE)
;

INSERT INTO PAISES VALUES('MCO','Monaco','MC');
INSERT INTO PAISES VALUES('MDG','Madagascar','MG');
INSERT INTO PAISES VALUES('MEX','Mexico','MX');
INSERT INTO PAISES VALUES('NGA','Nigeria','NG');
INSERT INTO PAISES VALUES('NIC','Nicaragua','NI');
INSERT INTO PAISES VALUES('NOR','Norway','NO');
INSERT INTO PAISES VALUES('NZL','New Zealand','NZ');
INSERT INTO PAISES VALUES('PER','Peru','PE');
INSERT INTO PAISES VALUES('POL','Poland','PL');
INSERT INTO PAISES VALUES('PRI','Puerto Rico','PR');
INSERT INTO PAISES VALUES('AFG','Afghanistan','AF');
INSERT INTO PAISES VALUES('ARG','Argentina','AR');

INSERT INTO PROVINCIAS  VALUES ('ARG', 'BUE', 'Buenos Aires');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'CAT', 'Catamarca');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'CHA', 'Chaco');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'CHU', 'Chubut');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'CBA', 'Córdoba');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'COR', 'Corrientes');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'CAP', 'Capital Federal');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'ENR', 'Entre Ríos');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'FOR', 'Formosa');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'JUJ', 'Jujuy');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'LPA', 'La Pampa');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'LRI', 'La Rioja');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'MEN', 'Mendoza');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'MIS', 'Misiones');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'NEU', 'Neuquén');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'RNE', 'Río Negro');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'SAL', 'Salta');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'SJU', 'San Juan');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'SLU', 'San Luis');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'SCR', 'Santa Cruz');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'SFE', 'Santa Fe');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'SDE', 'Santiago del Estero');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'TDF', 'Tierra del Fuego');
INSERT INTO PROVINCIAS  VALUES ('ARG', 'TUC', 'Tucumán');


INSERT INTO DEPORTES  VALUES (1, 'Futbol 5', 10);
INSERT INTO DEPORTES  VALUES (2, 'Futbol 11', 18);
INSERT INTO DEPORTES  VALUES (3, 'Tenis Individual', 1);
INSERT INTO DEPORTES  VALUES (4, 'Tenis Dobles', 2);
INSERT INTO DEPORTES  VALUES (5, 'Basket', 12);
INSERT INTO DEPORTES  VALUES (6, 'Volley', 12);
INSERT INTO DEPORTES  VALUES (7, 'Paddle Individual', 1);
INSERT INTO DEPORTES  VALUES (8, 'Paddle Dobles', 2);
INSERT INTO DEPORTES  VALUES (9, 'Rugby', 35);
INSERT INTO DEPORTES  VALUES (10, 'Golf', 1);

INSERT INTO TIPOS_TORNEO VALUES ('L', 'Liga');
INSERT INTO TIPOS_TORNEO VALUES ('C', 'Copa');
INSERT INTO TIPOS_TORNEO VALUES ('T', 'Torneo Ida y Vuelta');

INSERT INTO SEDES  VALUES (1, 'Sin Definir', 'ARG', 'BUE', 'N/A', 'Sin Definir', 0, 'Sin Definir', NULL ,'2018-01-01');
INSERT INTO SEDES  VALUES (2, 'La Popular', 'ARG', 'BUE', '1752', 'Costa Rica', 80, '4655-2212', NULL ,'2018-12-01');
INSERT INTO SEDES  VALUES (3, 'Complejo Norte', 'ARG', 'BUE', '1222', 'Av Juan B Justo', 1101, '2344-5312', 'Entre Venezuela y Bolivar',CURDATE());

INSERT INTO ESTADOS_TORNEO VALUES ('I', 'No Iniciado');
INSERT INTO ESTADOS_TORNEO VALUES ('C', 'En Curso');
INSERT INTO ESTADOS_TORNEO VALUES ('F', 'Finalizado');

INSERT INTO TORNEOS  VALUES (1, 'Torneo DaVinci', 1, 'L', 10, '2018-12-01', 2, 'I','2018-01-01');
INSERT INTO TORNEOS  VALUES (2, 'Roland Garros', 4, 'C', 32,  '2016-12-01', 2, 'F','2018-01-01');

INSERT INTO USUARIOS  VALUES ('pf_admin',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Admin', 'ProximaFecha', 'contacto@proximafecha.com', '1', '4655-1231',  '2016-10-01', '2018-01-01', 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('facundoS',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Facundo', 'Salerno', 'facundo.salerno@davinci.edu.ar', '1', '4655-1231',  '2016-10-01', '2018-01-01', 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('mauritoI',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Mauro', 'Iglesias', 'mauro.iglesias@davinci.edu.ar', '1', '4532-3123',  '2016-10-01', '2018-01-01', 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('claudioS',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Claudio', 'Serrano', 'claudio.serrano@davinci.edu.ar', '1', '1123-1231',  '2016-10-01', '2018-01-01', 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('hugoP',     '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Hugo', 'Pereyra', 'hugo.pereyra@davinci.edu.ar', '1', '1231-4123',  '2016-10-01', '2018-01-01', 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('francoA',   '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Franco', 'Arias', 'franco.arias@davinci.edu.ar', '1', '1233-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('estebanI',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Esteban', 'Iglesias', 'carlos.iglesias@davinci.edu.ar', '1', '3241-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('brianR',    '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Brian', 'Rodriguez', 'brian.rodriguez@davinci.edu.ar', '1', '3241-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('marceloT',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Marcelo', 'Tulián', 'marcelo.tulian@davinci.edu.ar', '1', '3241-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('leonardoT', '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Leonardo', 'Tulián', 'leonardo.tulian@davinci.edu.ar', '1', '3241-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('javierP',   '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Javier', 'Pereyra', 'javier.pereyta@davinci.edu.ar', '1', '3241-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('lucianoF',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Luciano', 'Fox', 'luciano.fox@davinci.edu.ar', '1', '1232-5411',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('cristianC', '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Cristian', 'Corey', 'cristian.corey@dvinci.edu.ar', '1', '1234-1231',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('gonzaloV',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Gonzalo', 'Vicens', 'gonzalo.vicens@davinci.edu.ar', '1', '1232-2322',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('jeronimoB', '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Jeronimo', 'Brandalise', 'jeronimo.brandalise@davinci.edu.ar', '1', '2133-5454',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('fernandoG', '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Fernando', 'García', 'fernando.garcia@davinci.edu.ar', '1', '6758-1232',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('sebastianL','$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Sebastián', 'Leonelli', 'sebastian.leonelli@davinci.edu.ar', '1', '4531-6546',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('jeffersonC','$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Jefferson', 'Cartagena', 'jefferson.cartagena@davinci.edu.ar', '1', '2345-6354',  '2016-10-01', CURDATE(), 'Y',CURDATE());
INSERT INTO USUARIOS  VALUES ('germanR',   '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'German', 'Rodriguez', 'german.rodriguez@davinci.edu.ar', '1', NULL,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('federicoN', '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Federico', 'Noto', 'federico.noto@davinci.edu.ar', '1', NULL,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('juanB',     '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Juan', 'Belloti', 'juan.belloti@davinci.edu.ar', '1', NULL,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('ignacioA',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Ignacio', 'Alaniz', 'ignacio.alaniz@davinci.edu.ar', '1', NULL,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('ricardoR',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Ricardo', 'Rodriguez', 'ricardo.rodriguez@davinci.edu.ar', '1', NULL,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('cristianF', '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Cristian', 'Fabregat', 'cristian.fabregat@davinci.edu.ar', '1', NULL,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('mabelG',    '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Mabel', 'Garcia', 'mabel.garcia@davinci.edu.ar', '1', '1235-8521',  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('vanesaP',   '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Vanesa', 'Ponce', 'vanesa.ponce@davinci.edu.ar', '1',  null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('usuario1',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Rómulo H.', 'Aquitado', 'usuario1@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('usuario2',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Elías', 'Pereza', 'usuario2@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('usuario3',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Brian', 'De La Mano', 'usuario3@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('usuario4',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Alberto', 'Tronchado', 'usuario4@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('usuario5',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'Silvio', 'Roscazo', 'usuario5@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('usuario6',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', 'José F.', 'Etchassoc', 'usuario6@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador1',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Julio Alberto', 'Buffarini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador2',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fernando Rubén', 'Gago', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador3',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Cristian David', 'Pavón', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador4',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Pablo Javier', 'Pérez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador5',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Edwin Andrés', 'Cardona Bedoya', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador6',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nahitan Michel', 'Nández Acosta', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01', '2018-01-01', 'Y','2018-01-01');
INSERT INTO USUARIOS  VALUES ('jugador7',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Wilmar Enrique', 'Barrios Terán', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador8',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Sebastián', 'Villa Cano', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador9',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leonardo Rafael', 'Jara', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador10',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Emanuel', 'Reynoso', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador11',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Bruno', 'Zuculini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador12',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Fernando', 'Quintero Paniagua', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador13',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gonzalo Nicolás', 'Martínez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador14',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Nicolás', 'De la Cruz Arcosa', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador15',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Santiago', 'Sosa', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador16',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Exequiel', 'Palacios', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador17',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Camilo Sebastián', 'Mayada Mesa', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador18',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Cristian Ezequiel', 'Ferreira', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador19',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leonardo Daniel', 'Ponzio', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador20',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Enzo Nicolás', 'Pérez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador21',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nicolás Mario', 'Domingo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador22',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Manuel', 'Sánchez Miño', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador23',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Maximiliano Eduardo', 'Meza', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador24',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fernando Vicente', 'Gaibor Orellana', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador25',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Braian Ezequiel', 'Romero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador26',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Pedro Pablo', 'Hernández', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador27',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Francisco Andrés', 'Silva Gajardo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador28',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Alan', 'Mercado Carrizo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador29',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leonel Ignacio', 'Álvarez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador30',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Enrique Exequiel', 'Blanco', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador31',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Guillermo Matías', 'Fernández', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador32',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Adrián Ricardo', 'Centurión', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador33',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Mauricio Leonel', 'Martínez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador34',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Martín Exequiel', 'Ojeda', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador35',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Augusto Jorge Mateo', 'Solari', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador36',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Neri Raúl', 'Cardozo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador37',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fabricio', 'Domínguez Huertas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador38',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Marcelo Alfonso', 'Díaz Rojas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador39',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nery Andrés', 'Domínguez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador40',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Julián Alejo', 'López', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador41',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Ariel Mauricio', 'Rojas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador42',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Franco Gabriel', 'Mussis', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador43',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gabriel Alejandro', 'Gudiño', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador44',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Bautista', 'Merlini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador45',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fernando Daniel', 'Belluschi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador46',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gerónimo Gastón', 'Poblete', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador47',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Rubén Alejandro', 'Botta Montero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador48',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Daniel Alejandro', 'Hernández González', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador49',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Cristian Nahuel', 'Barrios', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador50',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Franco David', 'Moyano', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador51',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Israel Alejandro', 'Damonte', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador52',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Mauro Ezequiel', 'Bogado', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador53',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Andrés Felipe', 'Roa Estrada', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador54',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Federico Ezequiel', 'Marín', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador55',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Iván', 'Rossi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador56',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Patricio Daniel', 'Toranzo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador57',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' David Hernán', 'Drocco', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador58',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Ramón Agustín', 'Casco', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador59',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matías Daniel', 'Juárez Romero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador60',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Andrés Eliseo', 'Chávez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador61',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Iván Alejandro', 'Gómez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador62',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fernando Rubén', 'Zuqui', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador63',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matías', 'Pellegrini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador64',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Lucas', 'Rodríguez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador65',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Facundo', 'Sánchez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador66',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Rodrigo', 'Braña', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador67',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Bautista', 'Cejas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador68',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nahuel', 'Estévez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador69',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matías Alejandro', 'Laba', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador70',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Franco Nicolás', 'Sivetti', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador71',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Lorenzo Abel', 'Faravelli', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador72',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Santiago', 'Rosales', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador73',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Kevin Facundo', 'Gutiérrez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador74',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Agustín Gabriel', 'Bolívar', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador75',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan', 'Cataldi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador76',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Hernán', 'Tifner', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador77',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fabián Andrés', 'Rinaudo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador78',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Eduardo Alejandro', 'Melo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador79',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' José Antonio', 'Paradela', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador80',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Patricio Iván', 'Monti', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador81',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leonardo Roque Albano', 'Gil', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-01-01' );
INSERT INTO USUARIOS  VALUES ('jugador82',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Joaquín Nicolás', 'Pereyra', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-01-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador83',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Federico Gastón', 'Carrizo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador84',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Néstor Ezequiel', 'Ortigoza', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador85',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' José Luis', 'Fernández', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador86',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Hugo', 'Arismendi Ciaparetta', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador87',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Washington Fernando', 'Camacho Martínez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador88',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Andrés', 'Lioi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador89',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Eugenio', 'Becker', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador90',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Pedro Emmanuel', 'Ojeda', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador91',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Hernán Darío', 'Bernardello', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador92',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Braian Abel', 'Rivero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador93',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Brian Oscar', 'Sarmiento', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador94',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Emanuel Joel', 'Amoroso', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador95',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Victor Alberto', 'Figueroa', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador96',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Joaquín', 'Torres', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador97',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Julián', 'Marcioni', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador98',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jerónimo', 'Cacciabue', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador99',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Mauro Abel', 'Formica', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador100',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Lisandro Joel', 'Alzugaray', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador101',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Tomás', 'Moschión', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador102',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matías Lionel', 'Fritzler', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador103',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jonatan Sebastián', 'Galván', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador104',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Alan Nahuel', 'Ruiz', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador105',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Tomás Alejandro', 'Chancalay', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador106',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Adrián Jesús', 'Bastía ', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador107',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Mariano Nicolás', 'González', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador108',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Franco', 'Zuculini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador109',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leonardo Matías', 'Heredia', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador110',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Christian Oscar', 'Bernardi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador111',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Damián Alberto', 'Martínez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador112',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nelson Fernando', 'Acevedo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador113',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gabriel Carlos', 'Compagnucci', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador114',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Rodrigo', 'Gómez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador115',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Martín', 'Zabala Morales', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador116',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Walter Germán', 'Bracamonte', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador117',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matías Ignacio', 'García', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador118',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Braian Gabriel', 'Álvarez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador119',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Santiago Nicolás', 'Lebus', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador120',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Manuel Ignacio', 'De Iriondo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador121',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Wilson Iván', 'Altamirano', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador122',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gastón Ignacio', 'Gil Romero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador123',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Federico Eduardo', 'Lértora', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador124',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Francisco', 'Brunetta', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador125',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Rodrigo Gastón Alesis', 'Gómez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador126',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Martín Rodrigo', 'Rivero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador127',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gabriel Gustavo', 'Alanís', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador128',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Denis', 'Rodríguez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador129',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Valentín', 'Barbero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador130',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nehemías Joaquín', 'Rikemberg', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador131',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Javier Marcelo', 'Gandolfi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador132',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Pablo Horacio', 'Guiñazú ', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador133',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Adrián Andrés', 'Cubas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador134',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gonzalo', 'Maroni', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador135',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Aldo Andrés', 'Araujo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador136',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fernando', 'Juárez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y','2018-12-01' );
INSERT INTO USUARIOS  VALUES ('jugador137',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Samuel Alejandro', 'Sosa Cordero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , '2018-12-01', 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador138',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Luis', 'Valoyes Ruiz', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador139',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Edgardo', 'Ramírez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador140',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Joel', 'Soñora', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador141',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Claudio Nicolás', 'Bravo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador142',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Emanuel Rodrigo', 'Cecchini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador143',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Adrián Daniel', 'Calello', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador144',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nicolás Santiago', 'Bertolo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador145',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jesús Alberto', 'Dátolo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador146',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nicolás Hugo', 'Linares', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador147',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Sebastián Martín', 'Benega', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador148',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Giuliano', 'Galoppo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador149',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Enzo Maximiliano', 'Kalinski', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador150',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Luciano Luis Romilio', 'Gómez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador151',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leandro Isaac', 'Maciel', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador152',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fernando Omar', 'Barrientos', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador153',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Tomás', 'Belmonte', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador154',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gastón Andrés', 'Lodico', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador155',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Facundo Tomás', 'Quignon', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador156',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nicolás', 'Pasquini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador157',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Lucas Andrés', 'Mugni', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador158',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gabriel Darío', 'Carrasco', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador159',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Pedro', 'De la Vega', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador160',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Kevin Alexander', 'Cardozo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador161',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Francis Manuel', 'Mac Allister', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador162',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Facundo Matías', 'Barboza', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador163',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Gastón', 'Machín', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador164',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Oscar', 'Benítez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador165',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Alexis', 'Mac Allister', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador166',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Ignacio', 'Méndez Aveiro', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador167',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fausto Mariano', 'Vera', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador168',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matías Alexis', 'Romero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador169',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fausto Emanuel', 'Montero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador170',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Matko Mijael', 'Miljevic', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador171',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Agustín Ignacio', 'Aleo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador172',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Luciano Gastón', 'Pizarro', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador173',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Ángel', 'González', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador174',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jalil Juan José', 'Elías', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador175',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Iván Rodrigo', 'Ramírez Segovia', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador176',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Enzo Agustín', 'Manzur', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador177',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leandro Ezequiel', 'Lencinas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador178',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fabián Gastón', 'Henríquez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador179',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego', 'Sosa', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador180',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fabrizio Germán', 'Angileri', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador181',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Lucas Ariel', 'Menossi', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador182',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Martín', 'Galmarini', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador183',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Walter Damián', 'Montillo', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador184',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Juan Ignacio', 'Cavallaro', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador185',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Franco Ezequiel', 'Bustamante', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador186',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Leonardo Sebastián', 'Prediger', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador187',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jorge Alberto', 'Ortiz', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador188',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Maximiliano David', 'González', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador189',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Diego Alejandro', 'Sosa', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador190',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jorge Iván', 'Bolaño', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador191',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Fabián Andrés', 'Cubero ', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador192',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Guido', 'Mainero', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador193',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Jesús David José', 'Méndez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador194',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Cristian David', 'Núñez Morales', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador195',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Lucas Gastón', 'Robertone', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador196',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Luis Antonio', 'Amarilla Lencina', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador197',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Thiago', 'Almada', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador198',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Martín Matías Ezequiel', 'Vargas', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador199',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Pablo Ignacio', 'Galdames Millán', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );
INSERT INTO USUARIOS  VALUES ('jugador200',  '$2y$10$tKq0LqypmBfGvw4DALD.Auj7tqkiNO7tBFrz4TDzfwt3yCiFAmGGm', ' Nicolás Martín', 'Domínguez', 'mailFalso@davinci.edu.ar', '1', null,  '2016-10-01' , CURDATE(), 'Y',CURDATE() );








INSERT INTO EQUIPOS  VALUES (1, 'PHP Futbol Club', 'facundoS', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (2, 'Sin Framework no programo', 'estebanI', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (3, 'Programadores', 'usuario2', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (4, 'Varchar de 50', 'usuario5', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (5, 'SQL Injection', 'usuario1', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (6, 'Puerto 7', 'germanR', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (7, 'Control C Control V', 'usuario3', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (8, 'Pisame la variable', 'usuario4', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (9, 'Los Array de 1 indice', 'gonzaloV', '1','2018-01-01' );
INSERT INTO EQUIPOS  VALUES (10, 'LAMPaso', 'usuario6', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (11, 'Boca Juniors', 'jugador1', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (12, 'River Plate', 'jugador11', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (13, 'Independiente', 'jugador21', '1','2018-01-01' );
INSERT INTO EQUIPOS  VALUES (14, 'Racing', 'jugador31', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (15, 'San Lorenzo', 'jugador41', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (16, 'Huracan', 'jugador51', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (17, 'Estudiantes La Plata', 'jugador61', '1','2018-01-01');
INSERT INTO EQUIPOS  VALUES (18, 'Gimansia La Plata', 'jugador71', '1','2018-12-01');
INSERT INTO EQUIPOS  VALUES (19, 'Rosario Central', 'jugador81', '1','2018-12-01');
INSERT INTO EQUIPOS  VALUES (20, 'Newells All Boys', 'jugador91', '1','2018-12-01' );
INSERT INTO EQUIPOS  VALUES (21, 'Colon Santa Fe', 'jugador101', '1','2018-12-01' );
INSERT INTO EQUIPOS  VALUES (22, 'Union Santa Fe', 'jugador111', '1','2018-12-01');
INSERT INTO EQUIPOS  VALUES (23, 'Belgrano', 'jugador121', '1','2018-12-01');
INSERT INTO EQUIPOS  VALUES (24, 'Talleres', 'jugador131', '1','2018-12-01');
INSERT INTO EQUIPOS  VALUES (25, 'Banfield', 'jugador141', '1','2018-12-01');
INSERT INTO EQUIPOS  VALUES (26, 'Lanús', 'jugador151', '1',CURDATE() );
INSERT INTO EQUIPOS  VALUES (27, 'Argentinos Juniors', 'jugador161', '1',CURDATE() );
INSERT INTO EQUIPOS  VALUES (28, 'Godoy Cruz', 'jugador171', '1',CURDATE() );
INSERT INTO EQUIPOS  VALUES (29, 'Tigre', 'jugador181', '1',CURDATE() );
INSERT INTO EQUIPOS  VALUES (30, 'Velez', 'jugador191', '1',CURDATE() );

INSERT INTO FASES VALUES (1, 1, 'Fecha 1', '2016-10-15');
INSERT INTO FASES VALUES (1, 2, 'Fecha 2', '2016-10-15');
INSERT INTO FASES VALUES (1, 3, 'Fecha 3', '2016-10-15');

INSERT INTO DIAS_TORNEO  VALUES (1, 'S' );
INSERT INTO DIAS_TORNEO  VALUES (2, 'D' );


INSERT INTO CANCHAS  VALUES (1, 1, 'Sin Definir', 1, 0);
INSERT INTO CANCHAS  VALUES (2, 1, 'La Canchita', 1, 300);
INSERT INTO CANCHAS  VALUES (2, 2, 'La Techada', 1, 300);
INSERT INTO CANCHAS  VALUES (3, 1, 'Abajo Futbol 1', 1, 300);
INSERT INTO CANCHAS  VALUES (3, 2, 'Abajo Futbol 2', 1, 300);
INSERT INTO CANCHAS  VALUES (3, 3, 'Abajo Tenis', 3, 250);
INSERT INTO CANCHAS  VALUES (3, 4, 'Arriba Tenis', 3, 250);

INSERT INTO PARTIDOS  VALUES (1, 1, 1, 1, 2, '2016-10-15', '21:00', NULL, 1, 2, 'Y', 'Y', 2, 1,'N');
INSERT INTO PARTIDOS  VALUES (1, 1, 2, 3, 4, '2016-10-15', '21:00', NULL, 0, 0, 'Y', 'Y', 2, 2,'N');
INSERT INTO PARTIDOS  VALUES (1, 2, 1, 1, 3, '2016-10-22', '19:00', 'mabelG', 2, 0, NULL, NULL, 2, 1,'N');
INSERT INTO PARTIDOS  VALUES (1, 2, 2, 2, 4, '2016-10-22', '21:00', 'vanesaP', 1, 2, NULL, NULL, 2, 2,'N');
INSERT INTO PARTIDOS  VALUES (1, 3, 1, 1, 4, '2016-10-29', '21:00', NULL, NULL, NULL, NULL, NULL, 2, 1,'N');
INSERT INTO PARTIDOS  VALUES (1, 3, 2, 2, 3, '2016-10-29', '21:00', NULL, NULL, NULL, NULL, NULL, 2, 2,'N');

INSERT INTO MENSAJES  VALUES (1, 'Hola, no podrías asignar un arbitro la prpoxima fecha?', 'facundoS', 'mabelG', 1, 1, 1,  '2016-10-16', '01:00','Y');
INSERT INTO MENSAJES  VALUES (2, 'Jojooo como les ganamos', 'estebanI', NULL, 1, 1, 1,  '2016-10-16', '09:00','N');
INSERT INTO MENSAJES  VALUES (3, 'Dale, no hay problema. Saludos', 'mabelG', 'facundoS', 1, 1, 1, '2016-10-16', '21:00','N');


INSERT INTO JUGADORES  VALUES (1, 'facundoS');
INSERT INTO JUGADORES  VALUES (1, 'mauritoI');
INSERT INTO JUGADORES  VALUES (1, 'hugoP');
INSERT INTO JUGADORES  VALUES (1, 'francoA');
INSERT INTO JUGADORES  VALUES (1, 'claudioS');
INSERT INTO JUGADORES  VALUES (1, 'cristianC');
INSERT INTO JUGADORES  VALUES (2, 'estebanI');
INSERT INTO JUGADORES  VALUES (2, 'javierP');
INSERT INTO JUGADORES  VALUES (2, 'brianR');
INSERT INTO JUGADORES  VALUES (2, 'marceloT');
INSERT INTO JUGADORES  VALUES (2, 'leonardoT');
INSERT INTO JUGADORES  VALUES (2, 'lucianoF');
INSERT INTO JUGADORES  VALUES (9, 'gonzaloV');
INSERT INTO JUGADORES  VALUES (9, 'fernandoG');
INSERT INTO JUGADORES  VALUES (9, 'sebastianL');
INSERT INTO JUGADORES  VALUES (9, 'jeronimoB');
INSERT INTO JUGADORES  VALUES (9, 'jeffersonC');
INSERT INTO JUGADORES  VALUES (6, 'germanR');
INSERT INTO JUGADORES  VALUES (6, 'federicoN');
INSERT INTO JUGADORES  VALUES (6, 'juanB');
INSERT INTO JUGADORES  VALUES (6, 'ignacioA');
INSERT INTO JUGADORES  VALUES (6, 'cristianF');
INSERT INTO JUGADORES  VALUES (6, 'ricardoR');
INSERT INTO JUGADORES  VALUES (5, 'usuario1');
INSERT INTO JUGADORES  VALUES (4, 'usuario2');
INSERT INTO JUGADORES  VALUES (7, 'usuario3');
INSERT INTO JUGADORES  VALUES (8, 'usuario4');
INSERT INTO JUGADORES  VALUES (3, 'usuario5');
INSERT INTO JUGADORES  VALUES (10,'usuario6');
INSERT INTO JUGADORES  VALUES (11, 'jugador1');
INSERT INTO JUGADORES  VALUES (11, 'jugador2');
INSERT INTO JUGADORES  VALUES (11, 'jugador3');
INSERT INTO JUGADORES  VALUES (11, 'jugador4');
INSERT INTO JUGADORES  VALUES (11, 'jugador5');
INSERT INTO JUGADORES  VALUES (11, 'jugador6');
INSERT INTO JUGADORES  VALUES (11, 'jugador7');
INSERT INTO JUGADORES  VALUES (11, 'jugador8');
INSERT INTO JUGADORES  VALUES (11, 'jugador9');
INSERT INTO JUGADORES  VALUES (11, 'jugador10');
INSERT INTO JUGADORES  VALUES (12, 'jugador11');
INSERT INTO JUGADORES  VALUES (12, 'jugador12');
INSERT INTO JUGADORES  VALUES (12, 'jugador13');
INSERT INTO JUGADORES  VALUES (12, 'jugador14');
INSERT INTO JUGADORES  VALUES (12, 'jugador15');
INSERT INTO JUGADORES  VALUES (12, 'jugador16');
INSERT INTO JUGADORES  VALUES (12, 'jugador17');
INSERT INTO JUGADORES  VALUES (12, 'jugador18');
INSERT INTO JUGADORES  VALUES (12, 'jugador19');
INSERT INTO JUGADORES  VALUES (12, 'jugador20');
INSERT INTO JUGADORES  VALUES (13, 'jugador21');
INSERT INTO JUGADORES  VALUES (13, 'jugador22');
INSERT INTO JUGADORES  VALUES (13, 'jugador23');
INSERT INTO JUGADORES  VALUES (13, 'jugador24');
INSERT INTO JUGADORES  VALUES (13, 'jugador25');
INSERT INTO JUGADORES  VALUES (13, 'jugador26');
INSERT INTO JUGADORES  VALUES (13, 'jugador27');
INSERT INTO JUGADORES  VALUES (13, 'jugador28');
INSERT INTO JUGADORES  VALUES (13, 'jugador29');
INSERT INTO JUGADORES  VALUES (13, 'jugador30');
INSERT INTO JUGADORES  VALUES (14, 'jugador31');
INSERT INTO JUGADORES  VALUES (14, 'jugador32');
INSERT INTO JUGADORES  VALUES (14, 'jugador33');
INSERT INTO JUGADORES  VALUES (14, 'jugador34');
INSERT INTO JUGADORES  VALUES (14, 'jugador35');
INSERT INTO JUGADORES  VALUES (14, 'jugador36');
INSERT INTO JUGADORES  VALUES (14, 'jugador37');
INSERT INTO JUGADORES  VALUES (14, 'jugador38');
INSERT INTO JUGADORES  VALUES (14, 'jugador39');
INSERT INTO JUGADORES  VALUES (14, 'jugador40');
INSERT INTO JUGADORES  VALUES (15, 'jugador41');
INSERT INTO JUGADORES  VALUES (15, 'jugador42');
INSERT INTO JUGADORES  VALUES (15, 'jugador43');
INSERT INTO JUGADORES  VALUES (15, 'jugador44');
INSERT INTO JUGADORES  VALUES (15, 'jugador45');
INSERT INTO JUGADORES  VALUES (15, 'jugador46');
INSERT INTO JUGADORES  VALUES (15, 'jugador47');
INSERT INTO JUGADORES  VALUES (15, 'jugador48');
INSERT INTO JUGADORES  VALUES (15, 'jugador49');
INSERT INTO JUGADORES  VALUES (15, 'jugador50');
INSERT INTO JUGADORES  VALUES (16, 'jugador51');
INSERT INTO JUGADORES  VALUES (16, 'jugador52');
INSERT INTO JUGADORES  VALUES (16, 'jugador53');
INSERT INTO JUGADORES  VALUES (16, 'jugador54');
INSERT INTO JUGADORES  VALUES (16, 'jugador55');
INSERT INTO JUGADORES  VALUES (16, 'jugador56');
INSERT INTO JUGADORES  VALUES (16, 'jugador57');
INSERT INTO JUGADORES  VALUES (16, 'jugador58');
INSERT INTO JUGADORES  VALUES (16, 'jugador59');
INSERT INTO JUGADORES  VALUES (16, 'jugador60');
INSERT INTO JUGADORES  VALUES (17, 'jugador61');
INSERT INTO JUGADORES  VALUES (17, 'jugador62');
INSERT INTO JUGADORES  VALUES (17, 'jugador63');
INSERT INTO JUGADORES  VALUES (17, 'jugador64');
INSERT INTO JUGADORES  VALUES (17, 'jugador65');
INSERT INTO JUGADORES  VALUES (17, 'jugador66');
INSERT INTO JUGADORES  VALUES (17, 'jugador67');
INSERT INTO JUGADORES  VALUES (17, 'jugador68');
INSERT INTO JUGADORES  VALUES (17, 'jugador69');
INSERT INTO JUGADORES  VALUES (17, 'jugador70');
INSERT INTO JUGADORES  VALUES (18, 'jugador71');
INSERT INTO JUGADORES  VALUES (18, 'jugador72');
INSERT INTO JUGADORES  VALUES (18, 'jugador73');
INSERT INTO JUGADORES  VALUES (18, 'jugador74');
INSERT INTO JUGADORES  VALUES (18, 'jugador75');
INSERT INTO JUGADORES  VALUES (18, 'jugador76');
INSERT INTO JUGADORES  VALUES (18, 'jugador77');
INSERT INTO JUGADORES  VALUES (18, 'jugador78');
INSERT INTO JUGADORES  VALUES (18, 'jugador79');
INSERT INTO JUGADORES  VALUES (18, 'jugador80');
INSERT INTO JUGADORES  VALUES (19, 'jugador81');
INSERT INTO JUGADORES  VALUES (19, 'jugador82');
INSERT INTO JUGADORES  VALUES (19, 'jugador83');
INSERT INTO JUGADORES  VALUES (19, 'jugador84');
INSERT INTO JUGADORES  VALUES (19, 'jugador85');
INSERT INTO JUGADORES  VALUES (19, 'jugador86');
INSERT INTO JUGADORES  VALUES (19, 'jugador87');
INSERT INTO JUGADORES  VALUES (19, 'jugador88');
INSERT INTO JUGADORES  VALUES (19, 'jugador89');
INSERT INTO JUGADORES  VALUES (19, 'jugador90');
INSERT INTO JUGADORES  VALUES (20, 'jugador91');
INSERT INTO JUGADORES  VALUES (20, 'jugador92');
INSERT INTO JUGADORES  VALUES (20, 'jugador93');
INSERT INTO JUGADORES  VALUES (20, 'jugador94');
INSERT INTO JUGADORES  VALUES (20, 'jugador95');
INSERT INTO JUGADORES  VALUES (20, 'jugador96');
INSERT INTO JUGADORES  VALUES (20, 'jugador97');
INSERT INTO JUGADORES  VALUES (20, 'jugador98');
INSERT INTO JUGADORES  VALUES (20, 'jugador99');
INSERT INTO JUGADORES  VALUES (20, 'jugador100');
INSERT INTO JUGADORES  VALUES (21, 'jugador101');
INSERT INTO JUGADORES  VALUES (21, 'jugador102');
INSERT INTO JUGADORES  VALUES (21, 'jugador103');
INSERT INTO JUGADORES  VALUES (21, 'jugador104');
INSERT INTO JUGADORES  VALUES (21, 'jugador105');
INSERT INTO JUGADORES  VALUES (21, 'jugador106');
INSERT INTO JUGADORES  VALUES (21, 'jugador107');
INSERT INTO JUGADORES  VALUES (21, 'jugador108');
INSERT INTO JUGADORES  VALUES (21, 'jugador109');
INSERT INTO JUGADORES  VALUES (21, 'jugador110');
INSERT INTO JUGADORES  VALUES (22, 'jugador111');
INSERT INTO JUGADORES  VALUES (22, 'jugador112');
INSERT INTO JUGADORES  VALUES (22, 'jugador113');
INSERT INTO JUGADORES  VALUES (22, 'jugador114');
INSERT INTO JUGADORES  VALUES (22, 'jugador115');
INSERT INTO JUGADORES  VALUES (22, 'jugador116');
INSERT INTO JUGADORES  VALUES (22, 'jugador117');
INSERT INTO JUGADORES  VALUES (22, 'jugador118');
INSERT INTO JUGADORES  VALUES (22, 'jugador119');
INSERT INTO JUGADORES  VALUES (22, 'jugador120');
INSERT INTO JUGADORES  VALUES (23, 'jugador121');
INSERT INTO JUGADORES  VALUES (23, 'jugador122');
INSERT INTO JUGADORES  VALUES (23, 'jugador123');
INSERT INTO JUGADORES  VALUES (23, 'jugador124');
INSERT INTO JUGADORES  VALUES (23, 'jugador125');
INSERT INTO JUGADORES  VALUES (23, 'jugador126');
INSERT INTO JUGADORES  VALUES (23, 'jugador127');
INSERT INTO JUGADORES  VALUES (23, 'jugador128');
INSERT INTO JUGADORES  VALUES (23, 'jugador129');
INSERT INTO JUGADORES  VALUES (23, 'jugador130');
INSERT INTO JUGADORES  VALUES (24, 'jugador131');
INSERT INTO JUGADORES  VALUES (24, 'jugador132');
INSERT INTO JUGADORES  VALUES (24, 'jugador133');
INSERT INTO JUGADORES  VALUES (24, 'jugador134');
INSERT INTO JUGADORES  VALUES (24, 'jugador135');
INSERT INTO JUGADORES  VALUES (24, 'jugador136');
INSERT INTO JUGADORES  VALUES (24, 'jugador137');
INSERT INTO JUGADORES  VALUES (24, 'jugador138');
INSERT INTO JUGADORES  VALUES (24, 'jugador139');
INSERT INTO JUGADORES  VALUES (24, 'jugador140');
INSERT INTO JUGADORES  VALUES (25, 'jugador141');
INSERT INTO JUGADORES  VALUES (25, 'jugador142');
INSERT INTO JUGADORES  VALUES (25, 'jugador143');
INSERT INTO JUGADORES  VALUES (25, 'jugador144');
INSERT INTO JUGADORES  VALUES (25, 'jugador145');
INSERT INTO JUGADORES  VALUES (25, 'jugador146');
INSERT INTO JUGADORES  VALUES (25, 'jugador147');
INSERT INTO JUGADORES  VALUES (25, 'jugador148');
INSERT INTO JUGADORES  VALUES (25, 'jugador149');
INSERT INTO JUGADORES  VALUES (25, 'jugador150');
INSERT INTO JUGADORES  VALUES (26, 'jugador151');
INSERT INTO JUGADORES  VALUES (26, 'jugador152');
INSERT INTO JUGADORES  VALUES (26, 'jugador153');
INSERT INTO JUGADORES  VALUES (26, 'jugador154');
INSERT INTO JUGADORES  VALUES (26, 'jugador155');
INSERT INTO JUGADORES  VALUES (26, 'jugador156');
INSERT INTO JUGADORES  VALUES (26, 'jugador157');
INSERT INTO JUGADORES  VALUES (26, 'jugador158');
INSERT INTO JUGADORES  VALUES (26, 'jugador159');
INSERT INTO JUGADORES  VALUES (26, 'jugador160');
INSERT INTO JUGADORES  VALUES (27, 'jugador161');
INSERT INTO JUGADORES  VALUES (27, 'jugador162');
INSERT INTO JUGADORES  VALUES (27, 'jugador163');
INSERT INTO JUGADORES  VALUES (27, 'jugador164');
INSERT INTO JUGADORES  VALUES (27, 'jugador165');
INSERT INTO JUGADORES  VALUES (27, 'jugador166');
INSERT INTO JUGADORES  VALUES (27, 'jugador167');
INSERT INTO JUGADORES  VALUES (27, 'jugador168');
INSERT INTO JUGADORES  VALUES (27, 'jugador169');
INSERT INTO JUGADORES  VALUES (27, 'jugador170');
INSERT INTO JUGADORES  VALUES (28, 'jugador171');
INSERT INTO JUGADORES  VALUES (28, 'jugador172');
INSERT INTO JUGADORES  VALUES (28, 'jugador173');
INSERT INTO JUGADORES  VALUES (28, 'jugador174');
INSERT INTO JUGADORES  VALUES (28, 'jugador175');
INSERT INTO JUGADORES  VALUES (28, 'jugador176');
INSERT INTO JUGADORES  VALUES (28, 'jugador177');
INSERT INTO JUGADORES  VALUES (28, 'jugador178');
INSERT INTO JUGADORES  VALUES (28, 'jugador179');
INSERT INTO JUGADORES  VALUES (28, 'jugador180');
INSERT INTO JUGADORES  VALUES (29, 'jugador181');
INSERT INTO JUGADORES  VALUES (29, 'jugador182');
INSERT INTO JUGADORES  VALUES (29, 'jugador183');
INSERT INTO JUGADORES  VALUES (29, 'jugador184');
INSERT INTO JUGADORES  VALUES (29, 'jugador185');
INSERT INTO JUGADORES  VALUES (29, 'jugador186');
INSERT INTO JUGADORES  VALUES (29, 'jugador187');
INSERT INTO JUGADORES  VALUES (29, 'jugador188');
INSERT INTO JUGADORES  VALUES (29, 'jugador189');
INSERT INTO JUGADORES  VALUES (29, 'jugador190');
INSERT INTO JUGADORES  VALUES (30, 'jugador191');
INSERT INTO JUGADORES  VALUES (30, 'jugador192');
INSERT INTO JUGADORES  VALUES (30, 'jugador193');
INSERT INTO JUGADORES  VALUES (30, 'jugador194');
INSERT INTO JUGADORES  VALUES (30, 'jugador195');
INSERT INTO JUGADORES  VALUES (30, 'jugador196');
INSERT INTO JUGADORES  VALUES (30, 'jugador197');
INSERT INTO JUGADORES  VALUES (30, 'jugador198');
INSERT INTO JUGADORES  VALUES (30, 'jugador199');
INSERT INTO JUGADORES  VALUES (30, 'jugador200');




INSERT INTO ORGANIZADORES VALUES (1, 'mabelG', '1');
INSERT INTO ORGANIZADORES VALUES (1, 'vanesaP', '1');

INSERT INTO EQUIPOS_TORNEO  VALUES (1, 1);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 2);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 3);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 4);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 5);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 6);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 7);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 8);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 9);
INSERT INTO EQUIPOS_TORNEO  VALUES (1, 10);

INSERT INTO DUENOS  VALUES (1, 'jeronimoB', '1');
INSERT INTO DUENOS  VALUES (2, 'vanesaP', '1');

INSERT INTO TIPOS_ESTADISTICA VALUES ('G', 'Gol a Favor');
INSERT INTO TIPOS_ESTADISTICA VALUES ('X', 'Gol en Contra');
INSERT INTO TIPOS_ESTADISTICA VALUES ('A', 'Tarjeta Amarilla');
INSERT INTO TIPOS_ESTADISTICA VALUES ('R', 'Tarjeta Roja');
INSERT INTO TIPOS_ESTADISTICA VALUES ('C', 'Capitán');

INSERT INTO FICHA_PARTIDO  VALUES (1, 1, 1, 1, 'G', 1, 'claudioS');
INSERT INTO FICHA_PARTIDO  VALUES (1, 1, 1, 2, 'A', 2, 'estebanI');
INSERT INTO FICHA_PARTIDO  VALUES (1, 1, 1, 3, 'G', 2, 'estebanI');
INSERT INTO FICHA_PARTIDO  VALUES (1, 1, 1, 4, 'G', 2, 'javierP');
INSERT INTO FICHA_PARTIDO  VALUES (1, 1, 2, 1, 'R', 6, 'germanR');
INSERT INTO FICHA_PARTIDO  VALUES (1, 2, 1, 1, 'G', 1, 'facundoS');
INSERT INTO FICHA_PARTIDO  VALUES (1, 2, 1, 2, 'G', 1, 'claudioS');
INSERT INTO FICHA_PARTIDO  VALUES (1, 2, 1, 3, 'A', 1, 'facundoS');
INSERT INTO FICHA_PARTIDO  VALUES (1, 2, 2, 1, 'G', 6, 'federicoN');
INSERT INTO FICHA_PARTIDO  VALUES (1, 2, 2, 2, 'G', 6, 'juanB');
INSERT INTO FICHA_PARTIDO  VALUES (1, 2, 2, 3, 'G', 9, 'gonzaloV');


DROP VIEW IF EXISTS TABLA_POSICIONES ;

CREATE VIEW TABLA_POSICIONES (TORNEO_ID, FASE_ID, PARTIDO_ID, EQUIPO_ID, GOLES_FAVOR, GOLES_CONTRA, JUGADOS, GANADOS, EMPATADOS, PERDIDOS) AS
SELECT TORNEO_ID, FASE_ID, PARTIDO_ID, LOCAL_ID, PUNTOS_LOCAL, PUNTOS_VISITA
, CASE JUGADO WHEN 'Y' THEN 1 ELSE 0 END JUGADOS
, CASE WHEN PUNTOS_LOCAL > PUNTOS_VISITA THEN 1 ELSE  0 END GANADOS
, CASE WHEN PUNTOS_LOCAL = PUNTOS_VISITA AND JUGADO = 'Y' THEN 1 ELSE  0 END EMPATADOS
, CASE WHEN PUNTOS_LOCAL < PUNTOS_VISITA THEN 1 ELSE  0 END PERDIDOS
FROM PARTIDOS

UNION
SELECT TORNEO_ID, FASE_ID, PARTIDO_ID, VISITA_ID, PUNTOS_VISITA, PUNTOS_LOCAL
, CASE JUGADO WHEN 'Y' THEN 1 ELSE 0 END JUGADOS
, CASE WHEN PUNTOS_LOCAL < PUNTOS_VISITA THEN 1 ELSE  0 END GANADOS
, CASE WHEN PUNTOS_LOCAL = PUNTOS_VISITA AND JUGADO = 'Y' THEN 1 ELSE  0 END EMPATADOS
, CASE WHEN PUNTOS_LOCAL > PUNTOS_VISITA THEN 1 ELSE  0 END PERDIDOS
FROM PARTIDOS
