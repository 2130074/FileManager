-- Creamos el Schema/Database que vamos a usar
CREATE SCHEMA `my_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;

-- Para en las siguientes ejecuciones, usamos este schema
USE `my_db`;

-- Se crea la tabla usuarios
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password_encrypted` varchar(128) NOT NULL,
  `password_salt` varchar(64) NOT NULL,
  `nombre` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `genero` varchar(1) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_hora_registro` datetime NOT NULL,
  `es_admin` tinyint NOT NULL DEFAULT 0,
  `activo` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Agregamos el usuario admin por default con el login admin Admin1234
INSERT INTO usuarios (
		 username
        ,password_encrypted
        ,password_salt
        ,nombre
        ,es_admin
        ,fecha_hora_registro
        ,activo) 
	VALUES (
		'admin'
        ,'8A9519A43A6BF1C71B184D23BEC87EE8DC1C61D6D40BA73F6F780213C19986B7438553C94668FB64CEADA4861F05E16047BF3AF30FDCF3B5385472B35F5C0B51'
        ,'614D1628C5254FEFF62A9062710E615A3DCC214F14C53122A5441E24575916C4'
        ,'Administrator'
        ,1
        ,'2024-04-01 07:55:50'
        ,1);

-- Creamos la tabla archivos, para guardar los registros de los archivos
CREATE TABLE `archivos` (
	`id` int NOT NULL AUTO_INCREMENT,
    `descripcion` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    `nombre_archivo` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `extension` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `nombre_archivo_guardado` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `tamaño` bigint NOT NULL,
    `hash_sha256` char(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `fecha_subido` datetime,
    `usuario_subio_id` int NOT NULL,
    `fecha_borrado` datetime NULL,
    `usuario_borro_id` int NULL,
    `cant_descargas` int DEFAULT 0 NOT NULL,
    `es_publico` tinyint NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de la tabla archivos_log_general donde se guardará el registro general de las
-- acciones que se hagan sobre los archivos, esto para tener un registro detallado del 
-- comportamiento de los archivos y para auditorias
CREATE TABLE `archivos_log_general` (
	`id` int NOT NULL AUTO_INCREMENT,
    `archivo_id` int NOT NULL,
    `usuario_id` int NOT NULL,
    `fecha_hora` datetime NOT NULL,
	`accion_realizada` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip_realiza_operacion` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
