CREATE DATABASE IF NOT EXISTS flexam;
USE flexam;

CREATE TABLE usuarios (
  ID_usuario INT AUTO_INCREMENT PRIMARY KEY,
  user VARCHAR(255) NOT NULL,
  psw VARCHAR(255) NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  apellidos VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  ID_universidad INT,
  ID_grado INT,
  rol VARCHAR(255) NOT NULL
);

CREATE TABLE universidades (
  ID_universidad INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  abreviatura VARCHAR(5) NOT NULL,
  ciudad VARCHAR(255) NOT NULL
);

CREATE TABLE grados (
  ID_grado INT AUTO_INCREMENT PRIMARY KEY,
  ID_universidad INT NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  FOREIGN KEY (ID_universidad) REFERENCES universidades(ID_universidad)
);

CREATE TABLE asignaturas (
  ID_asignatura INT AUTO_INCREMENT PRIMARY KEY,
  ID_universidad INT NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  abreviatura VARCHAR(5) NOT NULL,
  FOREIGN KEY (ID_universidad) REFERENCES universidades(ID_universidad)
);

CREATE TABLE grado_asignatura (
  ID_grado INT NOT NULL,
  ID_asignatura INT NOT NULL,
  PRIMARY KEY (ID_grado, ID_asignatura),
  FOREIGN KEY (ID_grado) REFERENCES grados(ID_grado),
  FOREIGN KEY (ID_asignatura) REFERENCES asignaturas(ID_asignatura)
);

CREATE TABLE tests (
  ID_test INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  ID_usuario INT NOT NULL,
  num_preguntas INT NOT NULL,
  es_publico BOOLEAN NOT NULL,
  es_anonimo BOOLEAN NOT NULL,
  FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario)
);

CREATE TABLE test_asignatura (
  ID_test INT NOT NULL,
  ID_universidad INT NOT NULL,
  ID_asignatura INT NOT NULL,
  PRIMARY KEY (ID_test, ID_universidad, ID_asignatura),
  FOREIGN KEY (ID_test) REFERENCES tests(ID_test),
  FOREIGN KEY (ID_universidad) REFERENCES universidades(ID_universidad),
  FOREIGN KEY (ID_asignatura) REFERENCES asignaturas(ID_asignatura)
);

CREATE TABLE preguntas (
  ID_pregunta INT AUTO_INCREMENT PRIMARY KEY,
  ID_test INT NOT NULL,
  pregunta TEXT NOT NULL,
  FOREIGN KEY (ID_test) REFERENCES tests(ID_test)
);

CREATE TABLE opciones (
  ID_test INT NOT NULL,
  ID_pregunta INT NOT NULL,
  ID_opcion INT NOT NULL,
  opcion TEXT NOT NULL,
  correcta BOOLEAN NOT NULL,
  PRIMARY KEY (ID_test, ID_pregunta, ID_opcion),
  FOREIGN KEY (ID_test, ID_pregunta) REFERENCES preguntas(ID_test, ID_pregunta)
);

CREATE TABLE respuesta_usuario (
  ID_test INT NOT NULL,
  ID_usuario INT NOT NULL,
  ID_intento INT AUTO_INCREMENT PRIMARY KEY,
  nota DECIMAL(5,2) NOT NULL,
  aciertos INT NOT NULL,
  fecha TIMESTAMP NOT NULL,
  restriccion BOOLEAN NOT NULL,
  FOREIGN KEY (ID_test) REFERENCES tests(ID_test),
  FOREIGN KEY (ID_usuario) REFERENCES usuarios(ID_usuario)
);

ALTER TABLE usuarios ADD FOREIGN KEY (ID_universidad) REFERENCES universidades (ID_universidad);
ALTER TABLE usuarios ADD FOREIGN KEY (ID_grado) REFERENCES grados (ID_grado);