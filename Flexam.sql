CREATE DATABASE IF NOT EXISTS flexam;
USE flexam;

CREATE TABLE `usuarios` (
  `ID_usuario` INT AUTO_INCREMENT PRIMARY KEY,
  `user` VARCHAR(255),
  `psw` VARCHAR(255),
  `nombre` VARCHAR(255),
  `apellidos` VARCHAR(255),
  `email` VARCHAR(255) UNIQUE,
  `ID_universidad` INT,
  `ID_grado` INT,
  `rol` VARCHAR(255)
);

CREATE TABLE `universidades` (
  `ID_universidad` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255),
  `abreviatura` VARCHAR(5),
  `ciudad` VARCHAR(255)
);

CREATE TABLE `grados` (
  `ID_grado` INT AUTO_INCREMENT PRIMARY KEY,
  `ID_universidad` INT,
  `nombre` VARCHAR(255)
);

CREATE TABLE `asignaturas` (
  `ID_asignatura` INT AUTO_INCREMENT PRIMARY KEY,
  `ID_universidad` INT,
  `nombre` VARCHAR(255),
  `abreviatura` VARCHAR(5)
);

CREATE TABLE `grado_asignatura` (
  `ID_grado` INT,
  `ID_asignatura` INT,
  PRIMARY KEY (`ID_grado`, `ID_asignatura`)
);

CREATE TABLE `tests` (
  `ID_test` INT AUTO_INCREMENT PRIMARY KEY,
  `titulo` VARCHAR(255),
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
  `ID_pregunta` INT AUTO_INCREMENT PRIMARY KEY,
  `ID_test` INT,
  `pregunta` TEXT,
  INDEX `idx_test` (`ID_test`),
  FOREIGN KEY (`ID_test`) REFERENCES `tests` (`ID_test`)
);

CREATE TABLE `opciones` (
  `ID_test` INT,
  `ID_pregunta` INT,
  `ID_opcion` INT,
  `opcion` TEXT,
  `correcta` BOOLEAN,
  PRIMARY KEY (`ID_test`, `ID_pregunta`, `ID_opcion`)
);

CREATE TABLE `respuesta_usuario` (
  `ID_test` INT,
  `ID_usuario` INT,
  `ID_intento` INT,
  `nota` DECIMAL(5,2),
  `aciertos` INT,
  `fecha` TIMESTAMP,
  `restriccion` BOOLEAN,
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

ALTER TABLE `opciones` ADD FOREIGN KEY (`ID_test`) REFERENCES `preguntas` (`ID_test`);

ALTER TABLE `opciones` ADD FOREIGN KEY (`ID_pregunta`) REFERENCES `preguntas` (`ID_pregunta`);

ALTER TABLE `respuesta_usuario` ADD FOREIGN KEY (`ID_test`) REFERENCES `tests` (`ID_test`);

ALTER TABLE `respuesta_usuario` ADD FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`);

---------- Insercion de datos ----------
-- Insertando universidades
INSERT INTO `universidades` (`nombre`, `abreviatura`, `ciudad`) VALUES
('Universidad Complutense de Madrid', 'UCM', 'Madrid'),
('Universidad Politécnica de Madrid', 'UPM', 'Madrid'),
('Universidad de Barcelona', 'UB', 'Barcelona'),
('IE University', 'IE', 'Madrid');

-- ID de la UCM
SET @ucm_id := (SELECT `ID_universidad` FROM `universidades` WHERE `abreviatura` = 'UCM');

-- Grados en la UCM
INSERT INTO `grados` (`ID_universidad`, `nombre`) VALUES
(@ucm_id, 'Doble Grado en Ingeniería Informática y Administración de Empresas'),
(@ucm_id, 'Ingeniería de Software'),
(@ucm_id, 'Psicología');

INSERT INTO usuarios (user, psw, nombre, apellidos, email, ID_universidad, ID_grado, rol) VALUES
('carlesperez', 'passwordHashAquí', 'Carles', 'Perez', 'carlesperez@example.com', 1, 1, 'estudiante'),
('adminUser', 'adminPasswordHashAquí', 'Admin', 'User', 'admin@example.com', NULL, NULL, 'admin');

-- Asignaturas comunes y específicas de los grados en UCM
INSERT INTO `asignaturas` (`ID_universidad`, `nombre`, `abreviatura`) VALUES
(@ucm_id, 'Fundamentos de la Programación 1', 'FP1'),
(@ucm_id, 'Fundamentos de Computadores 1', 'FC1'),
(@ucm_id, 'Aplicaciones Web', 'AW'),
(@ucm_id, 'Auditoría Informática 1', 'AI1'),
(@ucm_id, 'Márketing', 'MKT');

-- Obtener ID de los grados de UCM
SET @dobleg_id := (SELECT `ID_grado` FROM `grados` WHERE `nombre` = 'Doble Grado en Ingeniería Informática y Administración de Empresas' AND `ID_universidad` = @ucm_id);
SET @softeng_id := (SELECT `ID_grado` FROM `grados` WHERE `nombre` = 'Ingeniería de Software' AND `ID_universidad` = @ucm_id);

-- Obtener ID de las asignaturas
SET @fp1_id := (SELECT `ID_asignatura` FROM `asignaturas` WHERE `abreviatura` = 'FP1' AND `ID_universidad` = @ucm_id);
SET @fc1_id := (SELECT `ID_asignatura` FROM `asignaturas` WHERE `abreviatura` = 'FC1' AND `ID_universidad` = @ucm_id);
SET @aw_id := (SELECT `ID_asignatura` FROM `asignaturas` WHERE `abreviatura` = 'AW' AND `ID_universidad` = @ucm_id);
SET @ai1_id := (SELECT `ID_asignatura` FROM `asignaturas` WHERE `abreviatura` = 'AI1' AND `ID_universidad` = @ucm_id);
SET @mkt_id := (SELECT `ID_asignatura` FROM `asignaturas` WHERE `abreviatura` = 'MKT' AND `ID_universidad` = @ucm_id);

-- Asociar grados y asignaturas en UCM
INSERT INTO `grado_asignatura` (`ID_grado`, `ID_asignatura`) VALUES
(@dobleg_id, @fp1_id),
(@dobleg_id, @fc1_id),
(@dobleg_id, @aw_id),
(@dobleg_id, @ai1_id),
(@dobleg_id, @mkt_id),
(@softeng_id, @fp1_id),
(@softeng_id, @fc1_id),
(@softeng_id, @aw_id);

-- Grados para la Universidad Politécnica de Madrid (UPM)
INSERT INTO `grados` (`ID_universidad`, `nombre`) VALUES
(2, 'Grado en Arquitectura'),
(2, 'Grado en Ingeniería Aeroespacial');

-- Grados para la Universidad de Barcelona (UB)
INSERT INTO `grados` (`ID_universidad`, `nombre`) VALUES
(3, 'Grado en Derecho'),
(3, 'Grado en Medicina');

-- Asignaturas para la Universidad Politécnica de Madrid (UPM)
INSERT INTO `asignaturas` (`ID_universidad`, `nombre`, `abreviatura`) VALUES
(2, 'Diseño Arquitectónico', 'DA'),
(2, 'Cálculo de Estructuras', 'CE'),
(2, 'Mecánica de Fluidos', 'MF'),
(2, 'Diseño de Circuitos', 'DC'),
(2, 'Aerodinámica', 'AD');

-- Asignaturas para la Universidad de Barcelona (UB)
INSERT INTO `asignaturas` (`ID_universidad`, `nombre`, `abreviatura`) VALUES
(3, 'Derecho Romano', 'DR'),
(3, 'Derecho Civil', 'DCIV'),
(3, 'Anatomía Humana', 'AH'),
(3, 'Bioquímica', 'BQ'),
(3, 'Fisiología', 'FIS');

-- Obtener IDs de grados de la UPM
SET @arq_id := (SELECT `ID_grado` FROM `grados` WHERE `nombre` = 'Grado en Arquitectura');
SET @aero_id := (SELECT `ID_grado` FROM `grados` WHERE `nombre` = 'Grado en Ingeniería Aeroespacial');

-- Asignaturas compartidas entre grados en la UPM
-- Suponiendo que todas las asignaturas son compartidas
INSERT INTO `grado_asignatura` (`ID_grado`, `ID_asignatura`) SELECT @arq_id, `ID_asignatura` FROM `asignaturas` WHERE `ID_universidad` = 2;
INSERT INTO `grado_asignatura` (`ID_grado`, `ID_asignatura`) SELECT @aero_id, `ID_asignatura` FROM `asignaturas` WHERE `ID_universidad` = 2;

-- Obtener IDs de grados de la UB
SET @derecho_id := (SELECT `ID_grado` FROM `grados` WHERE `nombre` = 'Grado en Derecho');
SET @medicina_id := (SELECT `ID_grado` FROM `grados` WHERE `nombre` = 'Grado en Medicina');

-- Asignaturas compartidas entre grados en la UB
-- Suponiendo que las asignaturas 'Derecho Romano' y 'Derecho Civil' son para 'Grado en Derecho'
-- y 'Anatomía Humana', 'Bioquímica' y 'Fisiología' son para 'Grado en Medicina'
INSERT INTO `grado_asignatura` (`ID_grado`, `ID_asignatura`) SELECT @derecho_id, `ID_asignatura` FROM `asignaturas` WHERE `ID_universidad` = 3 AND `abreviatura` IN ('DR', 'DCIV');
INSERT INTO `grado_asignatura` (`ID_grado`, `ID_asignatura`) SELECT @medicina_id, `ID_asignatura` FROM `asignaturas` WHERE `ID_universidad` = 3 AND `abreviatura` IN ('AH', 'BQ', 'FIS');

----- CREACION TESTS ------
-- Insertar el test de Marketing
INSERT INTO `tests` (`titulo`, `ID_usuario`, `num_preguntas`, `es_publico`, `es_anonimo`) VALUES
('Preparación examen final de Marketing', 1, 7, TRUE, FALSE);

-- Obtener el ID del test de marketing para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué es el marketing mix?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Es una técnica para determinar el precio de los productos de una empresa.", 0),
(@test_id, @pregunta_id, 2, "b) Es una herramienta utilizada para definir la estrategia de promoción de una empresa.", 0),
(@test_id, @pregunta_id, 3, "c) Es un conjunto de variables controlables que la empresa utiliza para alcanzar los objetivos de marketing en el mercado objetivo.", 1),
(@test_id, @pregunta_id, 4, "d) Es un concepto relacionado con la distribución de los productos en el mercado.", 0);

-- Pregunta 2
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Cuál de las siguientes NO es una de las 4 P's del marketing mix?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Precio", 0),
(@test_id, @pregunta_id, 2, "b) Producto", 0),
(@test_id, @pregunta_id, 3, "c) Publicidad", 1),
(@test_id, @pregunta_id, 4, "d) Plaza", 0);

-- Pregunta 3
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué es el mercado meta?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Es el mercado en el que la empresa decide ingresar con su producto o servicio.", 0),
(@test_id, @pregunta_id, 2, "b) Es el segmento de mercado al que la empresa dirige sus esfuerzos de marketing.", 1),
(@test_id, @pregunta_id, 3, "c) Es el conjunto de todas las empresas que ofrecen productos similares en el mercado.", 0),
(@test_id, @pregunta_id, 4, "d) Es el grupo de consumidores que tienen una necesidad insatisfecha.", 0);

-- Pregunta 4
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Cuál de las siguientes NO es una estrategia de segmentación de mercado?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Segmentación geográfica", 0),
(@test_id, @pregunta_id, 2, "b) Segmentación demográfica", 0),
(@test_id, @pregunta_id, 3, "c) Segmentación psicológica", 0),
(@test_id, @pregunta_id, 4, "d) Segmentación monolítica", 1);

-- Pregunta 5
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué es el posicionamiento en marketing?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Es el proceso de crear una imagen única y distintiva en la mente de los consumidores para un producto o marca.", 1),
(@test_id, @pregunta_id, 2, "b) Es la acción de fijar el precio de un producto o servicio de acuerdo con la percepción del consumidor.", 0),
(@test_id, @pregunta_id, 3, "c) Es la estrategia que utiliza la empresa para distribuir sus productos en el mercado.", 0),
(@test_id, @pregunta_id, 4, "d) Es el conjunto de actividades que realiza la empresa para promover su producto o servicio.", 0);

-- Pregunta 6
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Cuál de las siguientes NO es una variable del marketing mix?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Precio", 0),
(@test_id, @pregunta_id, 2, "b) Producto", 0),
(@test_id, @pregunta_id, 3, "c) Promoción", 0),
(@test_id, @pregunta_id, 4, "d) Población", 1);

-- Pregunta 7
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué es el análisis FODA?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Es una herramienta de diagnóstico que permite identificar las Fortalezas, Oportunidades, Debilidades y Amenazas de una empresa.", 1),
(@test_id, @pregunta_id, 2, "b) Es una técnica para analizar la rentabilidad de un producto o servicio en el mercado.", 0),
(@test_id, @pregunta_id, 3, "c) Es un método para determinar el precio óptimo de un producto o servicio.", 0),
(@test_id, @pregunta_id, 4, "d) Es una estrategia de marketing para aumentar la participación en el mercado.", 0);



-- Insertar el test de Auditoría Informática
INSERT INTO `tests` (`titulo`, `ID_usuario`, `num_preguntas`, `es_publico`, `es_anonimo`) VALUES
('Módulo 1', 1, 10, TRUE, FALSE);

-- Obtener el ID del test de Auditoría Informática
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué expresión se ajusta mejor al concepto de auditoría?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`,  `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Proceso sistemático e independiente para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 0),
(@test_id, @pregunta_id, 2, "b) Proceso sistemático para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 0),
(@test_id, @pregunta_id, 3,  "c) Proceso sistemático, independiente y documentado para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 1),
(@test_id, @pregunta_id, 4, "d) Proceso sistemático, independiente y no documentado para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 0);

-- Pregunta 2
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué expresión se ajusta mejor al concepto de evidencia?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Registros, declaraciones de hecho o cualquier otra información que son pertinentes según la ISO/IEC 19011.", 0),
(@test_id, @pregunta_id, 2, "b) Registros, declaraciones de hecho o cualquier otra información que son pertinentes según el referente de auditoría y que son verificables.", 1),
(@test_id, @pregunta_id, 3, "c) Registros, declaraciones de hecho o cualquier otra información que no son pertinentes según el referente de auditoría y que son verificables.", 0),
(@test_id, @pregunta_id, 4, "d) Registros, declaraciones de hecho o cualquier otra información que son pertinentes según el referente de auditoría, que son verificables y que no sean repetibles.", 0);

-- Pregunta 3
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "El estándar ISO/IEC 27001 ha sido publicado por:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) ENAC", 0),
(@test_id, @pregunta_id, 2, "b) BSI", 0),
(@test_id, @pregunta_id, 3, "c) AENOR", 0),
(@test_id, @pregunta_id, 4, "d) ISO", 1);

-- Pregunta 4
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "Las propiedades que debe reunir una evidencia son:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Verificable, auténtica, repetible y analítica.", 0),
(@test_id, @pregunta_id, 2, "b) Verificable, auténtica, cíclica y neutra.", 0),
(@test_id, @pregunta_id, 3, "c) Medible, auténtica, repetible y neutra.", 0),
(@test_id, @pregunta_id, 4, "d) Verificable, auténtica, repetible y neutra.", 1);

-- Pregunta 5
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "Qué opción reúne el mayor número de procedimientos para obtener evidencias son:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Tratamiento documental, inspección física, entrevista y observación.", 0),
(@test_id, @pregunta_id, 2, "b) Inspección documental, inspección lógica, entrevista y observación.", 0),
(@test_id, @pregunta_id, 3, "c) Inspección documental, inspección física, álgebra, entrevista y observación.", 0),
(@test_id, @pregunta_id, 4, "d) Inspección documental, inspección física, entrevista y observación.", 1);

-- Pregunta 6
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué opción se ajusta mejor a la definición de auditoría externa de segunda parte?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Los auditores internos de una organización auditan a sus proveedores o a un proveedor potencial para determinar la viabilidad de su incorporación a la empresa en calidad de tal.", 1),
(@test_id, @pregunta_id, 2, "b) Una organización independiente, acreditada, audita a una organización, para determinar si cumple con una determinada norma.", 0),
(@test_id, @pregunta_id, 3, "c) Cuando una organización realiza una evaluación o auditoría interna por personal con experiencia e independiente con las funciones evaluadas.", 0),
(@test_id, @pregunta_id, 4, "d) Los auditores internos de una organización independiente y acreditada auditan a sus proveedores o a un proveedor potencial para determinar la viabilidad de su incorporación a la empresa en calidad de tal.", 0);

-- Pregunta 7
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "El estándar UNE-ISO/IEC 27001 ha sido publicado por:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) ENAC", 0),
(@test_id, @pregunta_id, 2, "b) BSI", 0),
(@test_id, @pregunta_id, 3, "c) AENOR", 1),
(@test_id, @pregunta_id, 4, "d) ISO", 0);

-- Pregunta 8
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "En España las entidades de certificación son acreditadas por:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) ENAC.", 1),
(@test_id, @pregunta_id, 2, "b) AENOR.", 0),
(@test_id, @pregunta_id, 3, "c) UKAS.", 0),
(@test_id, @pregunta_id, 4, "d) BSI.", 0);

-- Pregunta 9
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "Según el código profesional de ética de ISACA, el auditor debe:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Informar sobre los resultados del trabajo realizado sólo a su organización de auditoría, revelando todos los hechos significativos sobre los cuales tengan conocimiento.", 0),
(@test_id, @pregunta_id, 2, "b) Informar sobre los resultados del trabajo realizado a las partes apropiadas, revelando todos los hechos significativos y también los pertinentes sobre los cuales tengan conocimiento.", 1),
(@test_id, @pregunta_id, 3, "c) Informar sobre los resultados del trabajo realizado a las partes apropiadas, revelando parte los hechos significativos sobre los cuales tengan conocimiento.", 0),
(@test_id, @pregunta_id, 4, "d) Informar sobre los resultados del trabajo realizado a las partes apropiadas, revelando todos los hechos significativos sobre los cuales tengan conocimiento.", 0);

-- Pregunta 10
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué opción es la mejor respecto a las propiedades éticas que debe reunir el auditor?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Independencia, integridad, imparcialidad, secreto profesional y competencia profesional.", 0),
(@test_id, @pregunta_id, 2, "b) Independencia, integridad, objetividad, imparcialidad, secreto profesional y competencia profesional.", 1),
(@test_id, @pregunta_id, 3, "c) Independencia, integridad, objetividad, parcialidad, secreto profesional y competencia profesional.", 0),
(@test_id, @pregunta_id, 4, "d) Independencia, integridad, objetividad, imparcialidad, secreto profesional y competencia estructural.", 0);

-- Pregunta 11
INSERT INTO `preguntas` (`ID_test`, `pregunta`) VALUES
(@test_id, "¿Qué definición se ajusta mejor al contenido de la norma ISO/IEC 17021?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO `opciones` (`ID_test`, `ID_pregunta`, `ID_opcion`, `opcion`, `correcta`) VALUES
(@test_id, @pregunta_id, 1, "a) Las fases o acciones de un proceso de auditoría según la norma ISO 19011.", 0),
(@test_id, @pregunta_id, 2, "b) Las fases o acciones de un proceso de auditoría según la norma ISO 27007.", 0),
(@test_id, @pregunta_id, 3, "c) Requisitos para entidades auditoras y certificadoras de sistemas de gestión.", 1),
(@test_id, @pregunta_id, 4, "d) Requisitos para entidades acreditadoras y certificadoras de sistemas de gestión.", 0);
