CREATE TABLE `usuarios` (
  `ID_usuario` INT PRIMARY KEY,
  `user` VARCHAR,
  `psw` VARCHAR,
  `nombre` VARCHAR,
  `apellidos` VARCHAR,
  `email` VARCHAR UNIQUE,
  `ID_universidad` INT,
  `ID_grado` INT,
  `rol` VARCHAR
);

CREATE TABLE `universidades` (
  `ID_universidad` INT PRIMARY KEY,
  `nombre` VARCHAR,
  `abreviatura` VARCHAR,
  `ciudad` VARCHAR
);

CREATE TABLE `grados` (
  `ID_grado` INT PRIMARY KEY,
  `ID_universidad` INT,
  `nombre` VARCHAR
);

CREATE TABLE `asignaturas` (
  `ID_asignatura` INT PRIMARY KEY,
  `ID_universidad` INT,
  `nombre` VARCHAR,
  `abreviatura` VARCHAR
);

CREATE TABLE `grado_asignatura` (
  `ID_grado` INT,
  `ID_asignatura` INT,
  PRIMARY KEY (`ID_grado`, `ID_asignatura`)
);

CREATE TABLE `tests` (
  `ID_test` INT PRIMARY KEY,
  `titulo` varchar(255),
  `ID_usuario` INT,
  `num_preguntas` INT,
  `es_publico` BOOLEAN,
  `es_anonimo` BOOLEAN
);

CREATE TABLE `test_asignatura` (
  `ID_test` INT,
  `ID_universidad` INT,
  `ID_asignatura` INT,
  PRIMARY KEY (`ID_test`, `ID_universidad`, `ID_asignatura`)
);

CREATE TABLE `preguntas` (
  `ID_test` INT,
  `ID_pregunta` INT,
  `pregunta` TEXT,
  `ID_respuesta_correcta` INT,
  PRIMARY KEY (`ID_test`, `ID_pregunta`)
);

CREATE TABLE `opciones` (
  `ID_test` INT,
  `ID_pregunta` INT,
  `ID_opcion` INT,
  `opcion` TEXT,
  PRIMARY KEY (`ID_test`, `ID_pregunta`, `ID_opcion`)
);

CREATE TABLE `respuesta_usuario` (
  `ID_test` INT,
  `ID_usuario` INT,
  `ID_intento` INT,
  `nota` DECIMAL,
  `aciertos` INT,
  `fecha` TIMESTAMP,
  `restacion` BOOLEAN,
  PRIMARY KEY (`ID_test`, `ID_usuario`, `ID_intento`)
);

CREATE INDEX `usuarios_index_0` ON `usuarios` (`ID_universidad`, `ID_grado`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`ID_universidad`) REFERENCES `universidades` (`ID_universidad`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`ID_grado`) REFERENCES `grados` (`ID_grado`);

ALTER TABLE `grados` ADD FOREIGN KEY (`ID_universidad`) REFERENCES `universidades` (`ID_universidad`);

ALTER TABLE `asignaturas` ADD FOREIGN KEY (`ID_universidad`) REFERENCES `universidades` (`ID_universidad`);

ALTER TABLE `grado_asignatura` ADD FOREIGN KEY (`ID_grado`) REFERENCES `grados` (`ID_grado`);

ALTER TABLE `grado_asignatura` ADD FOREIGN KEY (`ID_asignatura`) REFERENCES `asignaturas` (`ID_asignatura`);

ALTER TABLE `tests` ADD FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`);

ALTER TABLE `test_asignatura` ADD FOREIGN KEY (`ID_test`) REFERENCES `tests` (`ID_test`);

ALTER TABLE `test_asignatura` ADD FOREIGN KEY (`ID_universidad`) REFERENCES `universidades` (`ID_universidad`);

ALTER TABLE `test_asignatura` ADD FOREIGN KEY (`ID_asignatura`) REFERENCES `asignaturas` (`ID_asignatura`);

ALTER TABLE `preguntas` ADD FOREIGN KEY (`ID_test`) REFERENCES `tests` (`ID_test`);

ALTER TABLE `preguntas` ADD FOREIGN KEY (`ID_respuesta_correcta`) REFERENCES `opciones` (`ID_opcion`);

ALTER TABLE `opciones` ADD FOREIGN KEY (`ID_test`) REFERENCES `preguntas` (`ID_test`);

ALTER TABLE `opciones` ADD FOREIGN KEY (`ID_pregunta`) REFERENCES `preguntas` (`ID_pregunta`);

ALTER TABLE `respuesta_usuario` ADD FOREIGN KEY (`ID_test`) REFERENCES `tests` (`ID_test`);

ALTER TABLE `respuesta_usuario` ADD FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`);
