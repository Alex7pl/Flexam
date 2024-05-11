  /* Insercion de datos */
-- Insertando universidades
INSERT INTO universidades (nombre, abreviatura, ciudad) VALUES
('Universidad Complutense de Madrid', 'UCM', 'Madrid'),
('Universidad Politécnica de Madrid', 'UPM', 'Madrid'),
('Universidad de Barcelona', 'UB', 'Barcelona'),
('IE University', 'IE', 'Madrid');

-- ID de la UCM
SET @ucm_id := (SELECT ID_universidad FROM universidades WHERE abreviatura = 'UCM');

-- Grados en la UCM
INSERT INTO grados (ID_universidad, nombre) VALUES
(@ucm_id, 'Doble Grado en Ingeniería Informática y Administración de Empresas'),
(@ucm_id, 'Ingeniería de Software'),
(@ucm_id, 'Psicología');

-- Asignaturas comunes y específicas de los grados en UCM
INSERT INTO asignaturas (ID_universidad, nombre, abreviatura) VALUES
(@ucm_id, 'Fundamentos de la Programación 1', 'FP1'),
(@ucm_id, 'Fundamentos de Computadores 1', 'FC1'),
(@ucm_id, 'Aplicaciones Web', 'AW'),
(@ucm_id, 'Auditoría Informática 1', 'AI1'),
(@ucm_id, 'Márketing', 'MKT');

-- Obtener ID de los grados de UCM
SET @dobleg_id := (SELECT ID_grado FROM grados WHERE nombre = 'Doble Grado en Ingeniería Informática y Administración de Empresas' AND ID_universidad = @ucm_id);
SET @softeng_id := (SELECT ID_grado FROM grados WHERE nombre = 'Ingeniería de Software' AND ID_universidad = @ucm_id);
SET @psicologia_id := (SELECT ID_grado FROM grados WHERE nombre = 'Psicología' AND ID_universidad = @ucm_id);

-- Obtener ID de las asignaturas
SET @fp1_id := (SELECT ID_asignatura FROM asignaturas WHERE abreviatura = 'FP1' AND ID_universidad = @ucm_id);
SET @fc1_id := (SELECT ID_asignatura FROM asignaturas WHERE abreviatura = 'FC1' AND ID_universidad = @ucm_id);
SET @aw_id := (SELECT ID_asignatura FROM asignaturas WHERE abreviatura = 'AW' AND ID_universidad = @ucm_id);
SET @ai1_id := (SELECT ID_asignatura FROM asignaturas WHERE abreviatura = 'AI1' AND ID_universidad = @ucm_id);
SET @mkt_id := (SELECT ID_asignatura FROM asignaturas WHERE abreviatura = 'MKT' AND ID_universidad = @ucm_id);

-- Asociar grados y asignaturas en UCM
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) VALUES
(@dobleg_id, @fp1_id),
(@dobleg_id, @fc1_id),
(@dobleg_id, @aw_id),
(@dobleg_id, @ai1_id),
(@dobleg_id, @mkt_id),
(@softeng_id, @fp1_id),
(@softeng_id, @fc1_id),
(@softeng_id, @aw_id);

-- Añadir la asignatura de Psicometría
INSERT INTO asignaturas (ID_universidad, nombre, abreviatura) VALUES
(@ucm_id, 'Psicometría', 'PSI');

-- Obtener ID de la asignatura Psicometría
SET @psi_id := (SELECT ID_asignatura FROM asignaturas WHERE abreviatura = 'PSI' AND ID_universidad = @ucm_id);

-- Asociar la asignatura de Psicometría al grado de Psicología
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) VALUES
(@psicologia_id, @psi_id);

-- Grados para la Universidad Politécnica de Madrid (UPM)
INSERT INTO grados (ID_universidad, nombre) VALUES
(2, 'Grado en Arquitectura'),
(2, 'Grado en Ingeniería Aeroespacial');

-- Grados para la Universidad de Barcelona (UB)
INSERT INTO grados (ID_universidad, nombre) VALUES
(3, 'Grado en Derecho'),
(3, 'Grado en Medicina');

-- Grados para IE University
INSERT INTO grados (ID_universidad, nombre) VALUES
(4, 'Business & Management');

-- Asignaturas para la Universidad Politécnica de Madrid (UPM)
INSERT INTO asignaturas (ID_universidad, nombre, abreviatura) VALUES
(2, 'Diseño Arquitectónico', 'DA'),
(2, 'Cálculo de Estructuras', 'CE'),
(2, 'Mecánica de Fluidos', 'MF'),
(2, 'Diseño de Circuitos', 'DC'),
(2, 'Aerodinámica', 'AD');

-- Asignaturas para la Universidad de Barcelona (UB)
INSERT INTO asignaturas (ID_universidad, nombre, abreviatura) VALUES
(3, 'Derecho Romano', 'DR'),
(3, 'Derecho Civil', 'DCIV'),
(3, 'Anatomía Humana', 'AH'),
(3, 'Bioquímica', 'BQ'),
(3, 'Fisiología', 'FIS');

-- Asignaturas para IE University
INSERT INTO asignaturas (ID_universidad, nombre, abreviatura) VALUES
(4, 'Business Fundamentals', 'BF');

-- Obtener IDs de grados de la UPM
SET @arq_id := (SELECT ID_grado FROM grados WHERE nombre = 'Grado en Arquitectura');
SET @aero_id := (SELECT ID_grado FROM grados WHERE nombre = 'Grado en Ingeniería Aeroespacial');

-- Asignaturas compartidas entre grados en la UPM
-- Suponiendo que todas las asignaturas son compartidas
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) SELECT @arq_id, ID_asignatura FROM asignaturas WHERE ID_universidad = 2 AND abreviatura IN ('DA', 'CE');
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) SELECT @aero_id, ID_asignatura FROM asignaturas WHERE ID_universidad = 2 AND abreviatura IN ('MF', 'DC', 'AD');

-- Obtener IDs de grados de la UB
SET @derecho_id := (SELECT ID_grado FROM grados WHERE nombre = 'Grado en Derecho');
SET @medicina_id := (SELECT ID_grado FROM grados WHERE nombre = 'Grado en Medicina');

-- Asignaturas compartidas entre grados en la UB
-- Suponiendo que las asignaturas 'Derecho Romano' y 'Derecho Civil' son para 'Grado en Derecho'
-- y 'Anatomía Humana', 'Bioquímica' y 'Fisiología' son para 'Grado en Medicina'
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) SELECT @derecho_id, ID_asignatura FROM asignaturas WHERE ID_universidad = 3 AND abreviatura IN ('DR', 'DCIV');
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) SELECT @medicina_id, ID_asignatura FROM asignaturas WHERE ID_universidad = 3 AND abreviatura IN ('AH', 'BQ', 'FIS');

-- Obtener el ID del grado de "Business & Management" en IE University
SET @b_m_id := (SELECT ID_grado FROM grados WHERE nombre = 'Business & Management' AND ID_universidad = 4);

-- Asignaturas compartidas entre grados en la IE
-- Suponiendo que todas las asignaturas son compartidas
INSERT INTO grado_asignatura (ID_grado, ID_asignatura) VALUES
(@b_m_id, (SELECT ID_asignatura FROM asignaturas WHERE nombre = 'Business Fundamentals' AND ID_universidad = 4));

INSERT INTO usuarios (user, psw, nombre, apellidos, email, ID_universidad, ID_grado, rol) VALUES
('flex', '$2y$10$ju5ai6teON3lyG45i0pk4e1ijKD0TiOazMnKN2RIFuQnHD8Z/zhwq', 'Flex', 'Exam', 'flex@exam.com', 1, 1, 'estudiante'),
('admin', '$2y$10$Q0d6iS1d54WEdZ4bweyCXe3iYJGDqc/3ux9TorVsPxpxZ9pNwr7uO', 'admin', 'admin', 'admin@gmail.com', NULL, NULL, 'administrador'),
('dani', '$2y$10$EfueOE.iAJwt4EgBkQE0oOYs2EatR70XMHT2ABGdmfC9PWotvvB8e', 'Daniel', 'Gomez', 'danigomez@gmail.com', 1, 2, 'estudiante'),
('sara', '$2y$10$vrUJJQN2qi5ADXn5yZQ/UetmHzIP4/dvUHjlJzxD5FPeA7/mzDrfW', 'sara', 'garcia', 'sagarcia@gmail.com', 1, 3, 'estudiante'),
('pani', '$2y$10$YFN2ZZs/Mtaa9w8oICyl9OPGvfT97yN2x/8fP0QAPYvZABeDMkG5O', 'Paniagua', 'Perez', 'pperez@gmail.com', 2, 4, 'estudiante'),
('martin', '$2y$10$OcZFFS.STPOZo5zDT8IaXeaffgK19P8Gm6Zrv4jQQS9/UFXk8pS/S', 'Martin', 'Gonzalez', 'gonzalez@gmail.com', 2, 5, 'estudiante'),
('demateo', '$2y$10$1PFre4JFDA3rOkmJW5TojucHQ6eMu.EHuMgZv3Ysy28FdpfWVU.Pu', 'demateo', 'martinez', 'dmmartinez@gmail.com', 3, 6, 'estudiante'),
('javi', '$2y$10$14/2q1hRIS4zMQ.EkAYH2OuXDxYeHonTsSrLMPELU5BSyhMmKzNjy', 'javier', 'sanchez', 'patillas@gmail.com', 3, 7, 'estudiante'),
('pablo', '$2y$10$KhfZFZtrie10u2lEZAjWOuM/0nvrBtSfn1vBZC5qCXPAMW256z1kC', 'pablo', 'corrientes', 'corrientes@gmail.com', 4, 8, 'estudiante');

/* CREACION TESTS */
-- Insertar el test de Marketing
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Marketing', 1, 7, TRUE, FALSE);

-- Obtener el ID del test de marketing para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el marketing mix?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una técnica para determinar el precio de los productos de una empresa.", 0),
(@test_id, @pregunta_id, 2, "b) Es una herramienta utilizada para definir la estrategia de promoción de una empresa.", 0),
(@test_id, @pregunta_id, 3, "c) Es un conjunto de variables controlables que la empresa utiliza para alcanzar los objetivos de marketing en el mercado objetivo.", 1),
(@test_id, @pregunta_id, 4, "d) Es un concepto relacionado con la distribución de los productos en el mercado.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes NO es una de las 4 P's del marketing mix?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Precio", 0),
(@test_id, @pregunta_id, 2, "b) Producto", 0),
(@test_id, @pregunta_id, 3, "c) Publicidad", 1),
(@test_id, @pregunta_id, 4, "d) Plaza", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el mercado meta?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es el mercado en el que la empresa decide ingresar con su producto o servicio.", 0),
(@test_id, @pregunta_id, 2, "b) Es el segmento de mercado al que la empresa dirige sus esfuerzos de marketing.", 1),
(@test_id, @pregunta_id, 3, "c) Es el conjunto de todas las empresas que ofrecen productos similares en el mercado.", 0),
(@test_id, @pregunta_id, 4, "d) Es el grupo de consumidores que tienen una necesidad insatisfecha.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes NO es una estrategia de segmentación de mercado?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Segmentación geográfica", 0),
(@test_id, @pregunta_id, 2, "b) Segmentación demográfica", 0),
(@test_id, @pregunta_id, 3, "c) Segmentación psicológica", 0),
(@test_id, @pregunta_id, 4, "d) Segmentación monolítica", 1);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el posicionamiento en marketing?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es el proceso de crear una imagen única y distintiva en la mente de los consumidores para un producto o marca.", 1),
(@test_id, @pregunta_id, 2, "b) Es la acción de fijar el precio de un producto o servicio de acuerdo con la percepción del consumidor.", 0),
(@test_id, @pregunta_id, 3, "c) Es la estrategia que utiliza la empresa para distribuir sus productos en el mercado.", 0),
(@test_id, @pregunta_id, 4, "d) Es el conjunto de actividades que realiza la empresa para promover su producto o servicio.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes NO es una variable del marketing mix?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Precio", 0),
(@test_id, @pregunta_id, 2, "b) Producto", 0),
(@test_id, @pregunta_id, 3, "c) Promoción", 0),
(@test_id, @pregunta_id, 4, "d) Población", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el análisis FODA?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una herramienta de diagnóstico que permite identificar las Fortalezas, Oportunidades, Debilidades y Amenazas de una empresa.", 1),
(@test_id, @pregunta_id, 2, "b) Es una técnica para analizar la rentabilidad de un producto o servicio en el mercado.", 0),
(@test_id, @pregunta_id, 3, "c) Es un método para determinar el precio óptimo de un producto o servicio.", 0),
(@test_id, @pregunta_id, 4, "d) Es una estrategia de marketing para aumentar la participación en el mercado.", 0);


-- Insertar el test de Auditoría Informática
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Módulo 1', 1, 10, TRUE, FALSE);

-- Obtener el ID del test de Auditoría Informática
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué expresión se ajusta mejor al concepto de auditoría?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion,  opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Proceso sistemático e independiente para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 0),
(@test_id, @pregunta_id, 2, "b) Proceso sistemático para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 0),
(@test_id, @pregunta_id, 3,  "c) Proceso sistemático, independiente y documentado para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 1),
(@test_id, @pregunta_id, 4, "d) Proceso sistemático, independiente y no documentado para obtener evidencias y evaluarlas de una manera objetiva con el fin de determinar la extensión en que se cumplen los criterios del referente utilizado.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué expresión se ajusta mejor al concepto de evidencia?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Registros, declaraciones de hecho o cualquier otra información que son pertinentes según la ISO/IEC 19011.", 0),
(@test_id, @pregunta_id, 2, "b) Registros, declaraciones de hecho o cualquier otra información que son pertinentes según el referente de auditoría y que son verificables.", 1),
(@test_id, @pregunta_id, 3, "c) Registros, declaraciones de hecho o cualquier otra información que no son pertinentes según el referente de auditoría y que son verificables.", 0),
(@test_id, @pregunta_id, 4, "d) Registros, declaraciones de hecho o cualquier otra información que son pertinentes según el referente de auditoría, que son verificables y que no sean repetibles.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "El estándar ISO/IEC 27001 ha sido publicado por:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) ENAC", 0),
(@test_id, @pregunta_id, 2, "b) BSI", 0),
(@test_id, @pregunta_id, 3, "c) AENOR", 0),
(@test_id, @pregunta_id, 4, "d) ISO", 1);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "Las propiedades que debe reunir una evidencia son:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Verificable, auténtica, repetible y analítica.", 0),
(@test_id, @pregunta_id, 2, "b) Verificable, auténtica, cíclica y neutra.", 0),
(@test_id, @pregunta_id, 3, "c) Medible, auténtica, repetible y neutra.", 0),
(@test_id, @pregunta_id, 4, "d) Verificable, auténtica, repetible y neutra.", 1);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "Qué opción reúne el mayor número de procedimientos para obtener evidencias son:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Tratamiento documental, inspección física, entrevista y observación.", 0),
(@test_id, @pregunta_id, 2, "b) Inspección documental, inspección lógica, entrevista y observación.", 0),
(@test_id, @pregunta_id, 3, "c) Inspección documental, inspección física, álgebra, entrevista y observación.", 0),
(@test_id, @pregunta_id, 4, "d) Inspección documental, inspección física, entrevista y observación.", 1);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué opción se ajusta mejor a la definición de auditoría externa de segunda parte?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Los auditores internos de una organización auditan a sus proveedores o a un proveedor potencial para determinar la viabilidad de su incorporación a la empresa en calidad de tal.", 1),
(@test_id, @pregunta_id, 2, "b) Una organización independiente, acreditada, audita a una organización, para determinar si cumple con una determinada norma.", 0),
(@test_id, @pregunta_id, 3, "c) Cuando una organización realiza una evaluación o auditoría interna por personal con experiencia e independiente con las funciones evaluadas.", 0),
(@test_id, @pregunta_id, 4, "d) Los auditores internos de una organización independiente y acreditada auditan a sus proveedores o a un proveedor potencial para determinar la viabilidad de su incorporación a la empresa en calidad de tal.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "El estándar UNE-ISO/IEC 27001 ha sido publicado por:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) ENAC", 0),
(@test_id, @pregunta_id, 2, "b) BSI", 0),
(@test_id, @pregunta_id, 3, "c) AENOR", 1),
(@test_id, @pregunta_id, 4, "d) ISO", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "En España las entidades de certificación son acreditadas por:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) ENAC.", 1),
(@test_id, @pregunta_id, 2, "b) AENOR.", 0),
(@test_id, @pregunta_id, 3, "c) UKAS.", 0),
(@test_id, @pregunta_id, 4, "d) BSI.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "Según el código profesional de ética de ISACA, el auditor debe:");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Informar sobre los resultados del trabajo realizado sólo a su organización de auditoría, revelando todos los hechos significativos sobre los cuales tengan conocimiento.", 0),
(@test_id, @pregunta_id, 2, "b) Informar sobre los resultados del trabajo realizado a las partes apropiadas, revelando todos los hechos significativos y también los pertinentes sobre los cuales tengan conocimiento.", 1),
(@test_id, @pregunta_id, 3, "c) Informar sobre los resultados del trabajo realizado a las partes apropiadas, revelando parte los hechos significativos sobre los cuales tengan conocimiento.", 0),
(@test_id, @pregunta_id, 4, "d) Informar sobre los resultados del trabajo realizado a las partes apropiadas, revelando todos los hechos significativos sobre los cuales tengan conocimiento.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué opción es la mejor respecto a las propiedades éticas que debe reunir el auditor?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Independencia, integridad, imparcialidad, secreto profesional y competencia profesional.", 0),
(@test_id, @pregunta_id, 2, "b) Independencia, integridad, objetividad, imparcialidad, secreto profesional y competencia profesional.", 1),
(@test_id, @pregunta_id, 3, "c) Independencia, integridad, objetividad, parcialidad, secreto profesional y competencia profesional.", 0),
(@test_id, @pregunta_id, 4, "d) Independencia, integridad, objetividad, imparcialidad, secreto profesional y competencia estructural.", 0);


INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('1', '1', '5'), ('2', '1', '4'); 

-- Insertar el test de diseño arquitectonico
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Diseño Arquitectónico', 5, 10, TRUE, FALSE);

-- Obtener el ID del test de diseño arquitectonico para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es uno de los principales objetivos del diseño arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Funcionalidad y estética.", 1),
(@test_id, @pregunta_id, 2, "b) Coste y tiempo de construcción.", 0),
(@test_id, @pregunta_id, 3, "c) Resistencia y durabilidad.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué elemento es fundamental para la comprensión del diseño arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) La forma y el espacio.", 1),
(@test_id, @pregunta_id, 2, "b) El color y la textura.", 0),
(@test_id, @pregunta_id, 3, "c) La iluminación y el mobiliario.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué aspecto NO es considerado en el análisis del contexto en el diseño arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Historia del arte.", 0),
(@test_id, @pregunta_id, 2, "b) Geografía y clima.", 0),
(@test_id, @pregunta_id, 3, "c) Aspectos sociales y culturales.", 1);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué método se utiliza para representar tridimensionalmente un proyecto arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Axonometría.", 0),
(@test_id, @pregunta_id, 2, "b) Perspectiva.", 1),
(@test_id, @pregunta_id, 3, "c) Planta.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de dibujo muestra una vista en sección del edificio?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Alzado.", 0),
(@test_id, @pregunta_id, 2, "b) Planta.", 0),
(@test_id, @pregunta_id, 3, "c) Sección.", 1);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es uno de los principios fundamentales del diseño sostenible en arquitectura?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Uso de materiales no renovables.", 0),
(@test_id, @pregunta_id, 2, "b) Reducción del consumo energético.", 1),
(@test_id, @pregunta_id, 3, "c) Maximizar la huella de carbono.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué técnica se utiliza para simular el comportamiento de la luz natural en un espacio arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Radiación solar.", 0),
(@test_id, @pregunta_id, 2, "b) Estudio de sombras.", 0),
(@test_id, @pregunta_id, 3, "c) Simulación lumínica.", 1);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué función cumple un croquis en el proceso de diseño arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Representar la idea inicial de un proyecto.", 1),
(@test_id, @pregunta_id, 2, "b) Calcular la estructura del edificio.", 0),
(@test_id, @pregunta_id, 3, "c) Detallar el mobiliario interior.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el propósito principal de un estudio de viabilidad en un proyecto arquitectónico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Evaluar la factibilidad económica y técnica.", 1),
(@test_id, @pregunta_id, 2, "b) Determinar la ubicación del edificio.", 0),
(@test_id, @pregunta_id, 3, "c) Establecer los requisitos de diseño.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué elemento arquitectónico se utiliza para permitir el paso de luz natural al interior de un edificio?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Claraboya.", 1),
(@test_id, @pregunta_id, 2, "b) Pilastra.", 0),
(@test_id, @pregunta_id, 3, "c) Zócalo.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('3', '2', '7'); 

-- Insertar el test de calculo de estructuras
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Cálculo de Estructuras', 5, 10, TRUE, FALSE);

-- Obtener el ID del test de calculo de estructuras para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de carga suele considerarse en el cálculo de estructuras para representar el peso propio de los materiales?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Carga puntual.", 0),
(@test_id, @pregunta_id, 2, "b) Carga distribuida.", 1),
(@test_id, @pregunta_id, 3, "c) Carga excéntrica.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de análisis se utiliza para determinar la estabilidad de una estructura frente a las cargas externas?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Análisis estático.", 1),
(@test_id, @pregunta_id, 2, "b) Análisis cinemático.", 0),
(@test_id, @pregunta_id, 3, "c) Análisis dinámico.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de esfuerzo predomina en una viga sometida a flexión?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Esfuerzo de compresión.", 0),
(@test_id, @pregunta_id, 2, "b) Esfuerzo de tracción.", 1),
(@test_id, @pregunta_id, 3, "c) Esfuerzo de corte.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué propiedad de los materiales se utiliza para representar su capacidad de deformación bajo carga?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Elasticidad.", 0),
(@test_id, @pregunta_id, 2, "b) Resistencia.", 0),
(@test_id, @pregunta_id, 3, "c) Ductilidad.", 1);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué método se utiliza para calcular las reacciones de apoyo en una estructura estáticamente determinada?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Método de los nudos.", 0),
(@test_id, @pregunta_id, 2, "b) Método de las secciones.", 0),
(@test_id, @pregunta_id, 3, "c) Equilibrio de fuerzas.", 1);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de carga se utiliza para representar fuerzas que actúan sobre la estructura de manera variable en el tiempo?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Carga puntual.", 0),
(@test_id, @pregunta_id, 2, "b) Carga permanente.", 0),
(@test_id, @pregunta_id, 3, "c) Carga viva.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de análisis se utiliza para estudiar la estabilidad de una estructura frente a movimientos sísmicos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Análisis cinemático.", 0),
(@test_id, @pregunta_id, 2, "b) Análisis estático.", 0),
(@test_id, @pregunta_id, 3, "c) Análisis dinámico.", 1);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de estructura está formada por elementos que transmiten las cargas principalmente por tracción o compresión?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Estructura reticular.", 1),
(@test_id, @pregunta_id, 2, "b) Estructura articulada.", 0),
(@test_id, @pregunta_id, 3, "c) Estructura de arco.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de esfuerzo se produce cuando una estructura está sometida a cargas externas que tienden a deformarla?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Esfuerzo de corte.", 0),
(@test_id, @pregunta_id, 2, "b) Esfuerzo de tracción.", 0),
(@test_id, @pregunta_id, 3, "c) Esfuerzo de flexión.", 1);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el principal objetivo del cálculo de estructuras en arquitectura?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Garantizar la estética del edificio.", 0),
(@test_id, @pregunta_id, 2, "b) Asegurar la seguridad y estabilidad de la construcción.", 1),
(@test_id, @pregunta_id, 3, "c) Minimizar los costos de construcción.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('4', '2', '8'); 

-- Insertar el test de mecanica de fluidos
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Mecánica de Fluidos', 6, 10, TRUE, FALSE);

-- Obtener el ID del test de mecanica de fluidos para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la ecuación fundamental de la mecánica de fluidos que describe la conservación de la masa?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ecuación de Bernoulli.", 0),
(@test_id, @pregunta_id, 2, "b) Ecuación de Navier-Stokes.", 0),
(@test_id, @pregunta_id, 3, "c) Ecuación de continuidad.", 1);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de flujo se caracteriza por tener líneas de corriente paralelas y velocidades constantes?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Flujo laminar.", 1),
(@test_id, @pregunta_id, 2, "b) Flujo turbulento.", 0),
(@test_id, @pregunta_id, 3, "c) Flujo estacionario.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué parámetro se utiliza para medir la viscosidad de un fluido?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Reynolds.", 0),
(@test_id, @pregunta_id, 2, "b) Mach.", 0),
(@test_id, @pregunta_id, 3, "c) Viscosidad dinámica.", 1);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de flujo se produce cuando el número de Reynolds es inferior a un valor crítico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Flujo laminar.", 1),
(@test_id, @pregunta_id, 2, "b) Flujo turbulento.", 0),
(@test_id, @pregunta_id, 3, "c) Flujo estacionario.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la ecuación que describe la relación entre la presión y la velocidad de un fluido en movimiento?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ecuación de Bernoulli.", 1),
(@test_id, @pregunta_id, 2, "b) Ecuación de Navier-Stokes.", 0),
(@test_id, @pregunta_id, 3, "c) Ecuación de continuidad.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la unidad SI de la viscosidad cinemática?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) m²/s.", 1),
(@test_id, @pregunta_id, 2, "b) N/m².", 0),
(@test_id, @pregunta_id, 3, "c) kg/m³.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué propiedad de un fluido describe su resistencia al cambio de forma?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Viscosidad.", 1),
(@test_id, @pregunta_id, 2, "b) Densidad.", 0),
(@test_id, @pregunta_id, 3, "c) Compresibilidad.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué ley fundamental de la hidrostática establece que la presión en un fluido en reposo es constante en todas direcciones?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ley de Pascal.", 1),
(@test_id, @pregunta_id, 2, "b) Ley de Bernoulli.", 0),
(@test_id, @pregunta_id, 3, "c) Ley de Arquímedes.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la ecuación fundamental de la dinámica de fluidos que describe la relación entre la fuerza aplicada a un fluido y su cambio en cantidad de movimiento?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ecuación de Navier-Stokes.", 0),
(@test_id, @pregunta_id, 2, "b) Ecuación de Bernoulli.", 0),
(@test_id, @pregunta_id, 3, "c) Segunda Ley de Newton.", 1);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué parámetro físico representa la resistencia de un fluido a fluir?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Viscosidad.", 1),
(@test_id, @pregunta_id, 2, "b) Densidad.", 0),
(@test_id, @pregunta_id, 3, "c) Presión.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('5', '2', '9'); 

-- Insertar el test de diseño de circuitos
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Diseño de Circuitos', 6, 10, TRUE, FALSE);

-- Obtener el ID del test de diseño de circuitos para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el principal componente utilizado para almacenar y liberar energía en un circuito eléctrico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Resistencia.", 0),
(@test_id, @pregunta_id, 2, "b) Inductor.", 0),
(@test_id, @pregunta_id, 3, "c) Capacitor.", 1);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué ley fundamental se utiliza para calcular la corriente que circula a través de un resistor en un circuito?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ley de Ohm.", 1),
(@test_id, @pregunta_id, 2, "b) Ley de Kirchhoff.", 0),
(@test_id, @pregunta_id, 3, "c) Ley de Faraday.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de circuito es aquel en el que la corriente se divide en diferentes ramas y se reúne en un único nodo?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Circuito en paralelo.", 0),
(@test_id, @pregunta_id, 2, "b) Circuito en serie.", 0),
(@test_id, @pregunta_id, 3, "c) Circuito mixto.", 1);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la unidad de medida de la capacitancia en un circuito?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Faradio.", 1),
(@test_id, @pregunta_id, 2, "b) Ohm.", 0),
(@test_id, @pregunta_id, 3, "c) Voltio.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la función principal de un amplificador en un circuito eléctrico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Reducir la corriente eléctrica.", 0),
(@test_id, @pregunta_id, 2, "b) Aumentar la potencia de la señal.", 1),
(@test_id, @pregunta_id, 3, "c) Filtrar el ruido electromagnético.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de componente electrónico se utiliza para cambiar la magnitud de una señal eléctrica en un circuito?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Resistencia.", 0),
(@test_id, @pregunta_id, 2, "b) Capacitor.", 0),
(@test_id, @pregunta_id, 3, "c) Transistor.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué ley se utiliza para calcular la tensión en un circuito en serie?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ley de Ohm.", 1),
(@test_id, @pregunta_id, 2, "b) Ley de Kirchhoff.", 0),
(@test_id, @pregunta_id, 3, "c) Ley de Faraday.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de circuito es aquel en el que todos los elementos comparten la misma corriente?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Circuito en paralelo.", 0),
(@test_id, @pregunta_id, 2, "b) Circuito en serie.", 1),
(@test_id, @pregunta_id, 3, "c) Circuito mixto.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la función principal de un diodo en un circuito eléctrico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Regular la corriente.", 0),
(@test_id, @pregunta_id, 2, "b) Convertir la corriente alterna en continua.", 1),
(@test_id, @pregunta_id, 3, "c) Aumentar la impedancia del circuito.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el propósito principal de un osciloscopio en el diseño y análisis de circuitos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Medir la resistencia de los componentes.", 0),
(@test_id, @pregunta_id, 2, "b) Visualizar formas de onda de señales eléctricas.", 1),
(@test_id, @pregunta_id, 3, "c) Calcular la potencia consumida por el circuito.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('6', '2', '10'); 

-- Insertar el test de aerodinámica
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Aerodinámica', 6, 10, TRUE, FALSE);

-- Obtener el ID del test de aerodinámica para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué ley fundamental de la aerodinámica establece que la presión de un fluido disminuye cuando su velocidad aumenta?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ley de Newton.", 0),
(@test_id, @pregunta_id, 2, "b) Ley de Pascal.", 0),
(@test_id, @pregunta_id, 3, "c) Principio de Bernoulli.", 1);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué parámetro describe la relación entre la fuerza de sustentación y el área de la superficie alar de una aeronave?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Coeficiente de arrastre.", 0),
(@test_id, @pregunta_id, 2, "b) Coeficiente de sustentación.", 1),
(@test_id, @pregunta_id, 3, "c) Coeficiente de elevación.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de flujo se produce alrededor de un perfil aerodinámico cuando la velocidad del fluido es suficientemente baja y el flujo es ordenado?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Flujo laminar.", 1),
(@test_id, @pregunta_id, 2, "b) Flujo turbulento.", 0),
(@test_id, @pregunta_id, 3, "c) Flujo estacionario.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué ley de la aerodinámica establece que todo cuerpo sumergido en un fluido experimenta una fuerza ascendente igual al peso del fluido desplazado?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ley de Pascal.", 0),
(@test_id, @pregunta_id, 2, "b) Ley de Bernoulli.", 0),
(@test_id, @pregunta_id, 3, "c) Principio de Arquímedes.", 1);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué término se utiliza para describir la resistencia que experimenta un objeto al moverse a través de un fluido?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Arrastre.", 1),
(@test_id, @pregunta_id, 2, "b) Sustentación.", 0),
(@test_id, @pregunta_id, 3, "c) Elevación.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el nombre del principio que establece que el ángulo de ataque de un perfil afecta la generación de sustentación?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Principio de Bernoulli.", 0),
(@test_id, @pregunta_id, 2, "b) Efecto Venturi.", 0),
(@test_id, @pregunta_id, 3, "c) Principio de Coanda.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué término se utiliza para describir la fuerza que actúa perpendicularmente a la dirección del flujo de aire?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Arrastre.", 0),
(@test_id, @pregunta_id, 2, "b) Sustentación.", 1),
(@test_id, @pregunta_id, 3, "c) Resistencia.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de flujo se produce alrededor de un objeto cuando la velocidad del fluido es alta y el flujo es caótico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Flujo laminar.", 0),
(@test_id, @pregunta_id, 2, "b) Flujo estacionario.", 0),
(@test_id, @pregunta_id, 3, "c) Flujo turbulento.", 1);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el efecto aerodinámico que ocurre cuando un flujo de aire se desplaza sobre una superficie curva?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Efecto Venturi.", 0),
(@test_id, @pregunta_id, 2, "b) Efecto Magnus.", 0),
(@test_id, @pregunta_id, 3, "c) Efecto Coanda.", 1);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué parámetro describe la capacidad de un perfil aerodinámico para generar sustentación?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Coeficiente de arrastre.", 0),
(@test_id, @pregunta_id, 2, "b) Coeficiente de sustentación.", 1),
(@test_id, @pregunta_id, 3, "c) Coeficiente de elevación.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('7', '2', '11'); 

-- Insertar el test de derecho romano
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Derecho Romano', 7, 10, TRUE, FALSE);

-- Obtener el ID del test de derecho romano para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál fue el primer cuerpo legal importante en la historia del Derecho Romano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Las XII Tablas.", 1),
(@test_id, @pregunta_id, 2, "b) El Edicto del Pretor.", 0),
(@test_id, @pregunta_id, 3, "c) La Ley de las Particiones.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué período del Derecho Romano se caracteriza por la aplicación del ius civile y la creación de las instituciones republicanas?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Monarquía Romana.", 0),
(@test_id, @pregunta_id, 2, "b) República Romana.", 1),
(@test_id, @pregunta_id, 3, "c) Imperio Romano.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué figura del Derecho Romano era un magistrado que tenía la función de juzgar y arbitrar conflictos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Pretor.", 1),
(@test_id, @pregunta_id, 2, "b) Cuestor.", 0),
(@test_id, @pregunta_id, 3, "c) Tribuno.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál fue el emperador romano conocido por su compilación y sistematización del Derecho Romano en el Corpus Iuris Civilis?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Augusto.", 0),
(@test_id, @pregunta_id, 2, "b) Justiniano.", 1),
(@test_id, @pregunta_id, 3, "c) Marco Aurelio.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la fuente principal del Derecho Romano que consiste en las decisiones de los jueces que se iban acumulando y eran aplicadas en casos similares posteriores?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ius civile.", 0),
(@test_id, @pregunta_id, 2, "b) Ius honorarium.", 0),
(@test_id, @pregunta_id, 3, "c) Jurisprudencia.", 1);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué período del Derecho Romano se caracteriza por la existencia de leyes escritas y la consolidación del ius civile?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Monarquía Romana.", 0),
(@test_id, @pregunta_id, 2, "b) República Romana.", 0),
(@test_id, @pregunta_id, 3, "c) Derecho clásico.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de derecho se desarrolló en el Imperio Romano y se basaba en los edictos de los magistrados?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ius civile.", 0),
(@test_id, @pregunta_id, 2, "b) Ius gentium.", 1),
(@test_id, @pregunta_id, 3, "c) Ius honorarium.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué figura del Derecho Romano era responsable de la administración y reparto de justicia en las provincias?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Praetor peregrinus.", 1),
(@test_id, @pregunta_id, 2, "b) Praetor urbanus.", 0),
(@test_id, @pregunta_id, 3, "c) Praefectus urbi.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál era el sistema legal que se aplicaba a los no ciudadanos y que se basaba en principios de justicia natural?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Ius civile.", 0),
(@test_id, @pregunta_id, 2, "b) Ius gentium.", 1),
(@test_id, @pregunta_id, 3, "c) Ius honorarium.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué término se utiliza para referirse a la autoridad suprema que tenía el pueblo romano en la toma de decisiones importantes?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Senado.", 0),
(@test_id, @pregunta_id, 2, "b) Comitia.", 1),
(@test_id, @pregunta_id, 3, "c) Consulado.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('8', '3', '12'); 

-- Insertar el test de derecho civil
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Derecho Civil', 7, 10, TRUE, FALSE);

-- Obtener el ID del test de derecho civil para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes ramas del Derecho se encarga de regular las relaciones entre individuos y entidades privadas?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Derecho Público.", 0),
(@test_id, @pregunta_id, 2, "b) Derecho Civil.", 1),
(@test_id, @pregunta_id, 3, "c) Derecho Penal.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el principio fundamental del Derecho Civil que establece que todo acto jurídico debe celebrarse de buena fe y cumpliendo con ciertos requisitos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Principio de legalidad.", 0),
(@test_id, @pregunta_id, 2, "b) Principio de igualdad.", 0),
(@test_id, @pregunta_id, 3, "c) Principio de buena fe.", 1);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de contrato implica la transferencia de la propiedad de un bien o derecho de una persona a otra a cambio de un precio?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Contrato de arrendamiento.", 0),
(@test_id, @pregunta_id, 2, "b) Contrato de donación.", 0),
(@test_id, @pregunta_id, 3, "c) Contrato de compraventa.", 1);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué término se utiliza para describir la capacidad que tiene una persona para adquirir derechos y contraer obligaciones por sí misma?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Capacidad jurídica.", 1),
(@test_id, @pregunta_id, 2, "b) Capacidad de obrar.", 0),
(@test_id, @pregunta_id, 3, "c) Capacidad de goce.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la edad mínima legal para contraer matrimonio en la mayoría de los países occidentales?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) 16 años.", 0),
(@test_id, @pregunta_id, 2, "b) 18 años.", 1),
(@test_id, @pregunta_id, 3, "c) 21 años.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué término se utiliza para describir el conjunto de normas que regulan la organización y funcionamiento de la familia?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Derecho sucesorio.", 0),
(@test_id, @pregunta_id, 2, "b) Derecho de obligaciones.", 0),
(@test_id, @pregunta_id, 3, "c) Derecho de familia.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de contrato implica la cesión temporal del uso y disfrute de un bien a cambio de un precio?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Contrato de compraventa.", 0),
(@test_id, @pregunta_id, 2, "b) Contrato de donación.", 0),
(@test_id, @pregunta_id, 3, "c) Contrato de arrendamiento.", 1);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el principio que establece que los bienes adquiridos durante el matrimonio pertenecen en común a ambos cónyuges?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Separación de bienes.", 0),
(@test_id, @pregunta_id, 2, "b) Bienes gananciales.", 1),
(@test_id, @pregunta_id, 3, "c) Régimen de participación.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la rama del Derecho Civil que se encarga de regular la sucesión de bienes y derechos tras el fallecimiento de una persona?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Derecho de obligaciones.", 0),
(@test_id, @pregunta_id, 2, "b) Derecho sucesorio.", 1),
(@test_id, @pregunta_id, 3, "c) Derecho de familia.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué término se utiliza para describir el acto jurídico por el cual una persona otorga a otra el poder de realizar actos en su nombre y representación?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Testamento.", 0),
(@test_id, @pregunta_id, 2, "b) Donación.", 0),
(@test_id, @pregunta_id, 3, "c) Poder notarial.", 1);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('9', '3', '13');

-- Insertar el test de derecho anatomía humana
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Anatomía humana', 8, 10, TRUE, FALSE);

-- Obtener el ID del test de anatomía humana para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes huesos forma parte del cráneo humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Húmero.", 0),
(@test_id, @pregunta_id, 2, "b) Fémur.", 0),
(@test_id, @pregunta_id, 3, "c) Occipital.", 1);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes estructuras es parte del sistema nervioso central?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Médula ósea.", 0),
(@test_id, @pregunta_id, 2, "b) Ganglio linfático.", 0),
(@test_id, @pregunta_id, 3, "c) Cerebro.", 1);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes órganos forma parte del sistema respiratorio humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Páncreas.", 0),
(@test_id, @pregunta_id, 2, "b) Pulmón.", 1),
(@test_id, @pregunta_id, 3, "c) Riñón.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes huesos se encuentra en la extremidad superior del cuerpo humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Fémur.", 0),
(@test_id, @pregunta_id, 2, "b) Húmero.", 1),
(@test_id, @pregunta_id, 3, "c) Tibia.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes órganos forma parte del sistema digestivo humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Corazón.", 0),
(@test_id, @pregunta_id, 2, "b) Hígado.", 1),
(@test_id, @pregunta_id, 3, "c) Bazo.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes huesos forma parte de la columna vertebral humana?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Húmero.", 0),
(@test_id, @pregunta_id, 2, "b) Escápula.", 0),
(@test_id, @pregunta_id, 3, "c) Vértebra.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes órganos forma parte del sistema endocrino humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Páncreas.", 1),
(@test_id, @pregunta_id, 2, "b) Hígado.", 0),
(@test_id, @pregunta_id, 3, "c) Vesícula biliar.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes estructuras es parte del sistema cardiovascular humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Pulmón.", 0),
(@test_id, @pregunta_id, 2, "b) Riñón.", 0),
(@test_id, @pregunta_id, 3, "c) Corazón.", 1);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes órganos forma parte del sistema linfático humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Páncreas.", 0),
(@test_id, @pregunta_id, 2, "b) Bazo.", 1),
(@test_id, @pregunta_id, 3, "c) Hígado.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes músculos forma parte de los músculos del abdomen humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Bíceps braquial.", 0),
(@test_id, @pregunta_id, 2, "b) Deltoides.", 0),
(@test_id, @pregunta_id, 3, "c) Recto abdominal.", 1);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('10', '3', '14');

-- Insertar el test de bioquimica
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Bioquímica', 8, 10, TRUE, FALSE);

-- Obtener el ID del test de bioquimica para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes biomoléculas es la principal fuente de energía para las células?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Proteínas.", 0),
(@test_id, @pregunta_id, 2, "b) Lípidos.", 0),
(@test_id, @pregunta_id, 3, "c) Glucosa.", 1);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de los siguientes elementos es fundamental en la estructura de los aminoácidos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Hierro.", 0),
(@test_id, @pregunta_id, 2, "b) Carbono.", 1),
(@test_id, @pregunta_id, 3, "c) Calcio.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes enzimas descompone las grasas en ácidos grasos y glicerol?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Lipasa.", 1),
(@test_id, @pregunta_id, 2, "b) Amilasa.", 0),
(@test_id, @pregunta_id, 3, "c) Proteasa.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de enlace une a los nucleótidos en una molécula de ADN?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Enlace peptídico.", 0),
(@test_id, @pregunta_id, 2, "b) Enlace glucosídico.", 0),
(@test_id, @pregunta_id, 3, "c) Enlace fosfodiéster.", 1);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes moléculas es la unidad básica de los ácidos nucleicos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Aminoácidos.", 0),
(@test_id, @pregunta_id, 2, "b) Monosacáridos.", 0),
(@test_id, @pregunta_id, 3, "c) Nucleótidos.", 1);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué orgánulo celular es el principal sitio de producción de ATP mediante la fosforilación oxidativa?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Retículo endoplasmático.", 0),
(@test_id, @pregunta_id, 2, "b) Núcleo.", 0),
(@test_id, @pregunta_id, 3, "c) Mitochondria.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes vitaminas es soluble en agua?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Vitamina A.", 0),
(@test_id, @pregunta_id, 2, "b) Vitamina D.", 0),
(@test_id, @pregunta_id, 3, "c) Vitamina C.", 1);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de enzimas catalizan la transferencia de grupos funcionales de una molécula a otra?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Oxidasas.", 0),
(@test_id, @pregunta_id, 2, "b) Transferasas.", 1),
(@test_id, @pregunta_id, 3, "c) Hidrolasas.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la principal función de los lípidos en el cuerpo humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Almacenar energía.", 1),
(@test_id, @pregunta_id, 2, "b) Actuar como enzimas.", 0),
(@test_id, @pregunta_id, 3, "c) Transportar oxígeno.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es el principal azúcar transportador en el cuerpo humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Fructosa.", 0),
(@test_id, @pregunta_id, 2, "b) Glucosa.", 1),
(@test_id, @pregunta_id, 3, "c) Sacarosa.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('11', '3', '15');

-- Insertar el test de fisiologia
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Fisiología', 8, 10, TRUE, FALSE);

-- Obtener el ID del test de fisiologia para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál de las siguientes hormonas regula los niveles de glucosa en sangre?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Insulina.", 1),
(@test_id, @pregunta_id, 2, "b) Adrenalina.", 0),
(@test_id, @pregunta_id, 3, "c) Cortisol.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué órgano es responsable de la filtración de la sangre para producir la orina?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Riñón.", 1),
(@test_id, @pregunta_id, 2, "b) Hígado.", 0),
(@test_id, @pregunta_id, 3, "c) Páncreas.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué parte del sistema nervioso autónomo se activa durante una situación de 'lucha o huida'?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Sistema nervioso simpático.", 1),
(@test_id, @pregunta_id, 2, "b) Sistema nervioso parasimpático.", 0),
(@test_id, @pregunta_id, 3, "c) Sistema nervioso entérico.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué hormona es responsable de regular el metabolismo basal?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Tiroxina.", 1),
(@test_id, @pregunta_id, 2, "b) Insulina.", 0),
(@test_id, @pregunta_id, 3, "c) Cortisol.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la función principal del sistema respiratorio?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Transportar oxígeno y dióxido de carbono.", 1),
(@test_id, @pregunta_id, 2, "b) Regular el pH sanguíneo.", 0),
(@test_id, @pregunta_id, 3, "c) Filtrar la sangre.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué parte del cerebro se encarga principalmente de regular funciones vitales como la respiración y el ritmo cardíaco?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Hipotálamo.", 0),
(@test_id, @pregunta_id, 2, "b) Bulbo raquídeo.", 1),
(@test_id, @pregunta_id, 3, "c) Cerebelo.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué tipo de músculo se contrae de forma involuntaria y se encuentra en las paredes de los órganos internos?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Músculo esquelético.", 0),
(@test_id, @pregunta_id, 2, "b) Músculo liso.", 1),
(@test_id, @pregunta_id, 3, "c) Músculo cardíaco.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué estructura del sistema nervioso está compuesta por fibras nerviosas mielinizadas y se encarga de transmitir impulsos nerviosos desde el sistema nervioso central hacia el resto del cuerpo?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Nervios sensoriales.", 0),
(@test_id, @pregunta_id, 2, "b) Nervios motores.", 1),
(@test_id, @pregunta_id, 3, "c) Nervios autónomos.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Cuál es la principal función del riñón en el cuerpo humano?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Regular el equilibrio ácido-base.", 0),
(@test_id, @pregunta_id, 2, "b) Filtrar la sangre y producir orina.", 1),
(@test_id, @pregunta_id, 3, "c) Regular el metabolismo basal.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué estructura del ojo es responsable de enfocar la luz en la retina?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Córnea.", 1),
(@test_id, @pregunta_id, 2, "b) Iris.", 0),
(@test_id, @pregunta_id, 3, "c) Cristalino.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('12', '3', '16');

-- Insertar el test de Business Fundamentals
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Business Fundamentals', 9, 10, TRUE, FALSE);

-- Obtener el ID del test de Business Fundamentals para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Question 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "Which of the following best defines the term 'SWOT analysis' in business management?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) An assessment of strengths, weaknesses, opportunities, and threats.", 1),
(@test_id, @pregunta_id, 2, "b) A financial analysis of quarterly reports.", 0),
(@test_id, @pregunta_id, 3, "c) A review of customer satisfaction levels.", 0);

-- Question 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What does ROI stand for in business management?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Return on Investment.", 1),
(@test_id, @pregunta_id, 2, "b) Revenue of Interest.", 0),
(@test_id, @pregunta_id, 3, "c) Ratio of Income.", 0);

-- Question 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the primary goal of supply chain management?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) To optimize the flow of goods and services from production to consumption.", 1),
(@test_id, @pregunta_id, 2, "b) To maximize shareholder profits.", 0),
(@test_id, @pregunta_id, 3, "c) To minimize marketing expenses.", 0);

-- Question 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What does the term 'KPI' stand for in business management?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Key Performance Indicator.", 1),
(@test_id, @pregunta_id, 2, "b) Key Profitable Investment.", 0),
(@test_id, @pregunta_id, 3, "c) Key Partnership Initiative.", 0);

-- Question 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the purpose of a business plan?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) To outline the goals and strategies of a company.", 1),
(@test_id, @pregunta_id, 2, "b) To provide customer support.", 0),
(@test_id, @pregunta_id, 3, "c) To organize office space.", 0);

-- Question 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the role of a SWOT analysis in business strategy?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Identifying internal strengths and weaknesses, as well as external opportunities and threats.", 1),
(@test_id, @pregunta_id, 2, "b) Analyzing quarterly financial reports.", 0),
(@test_id, @pregunta_id, 3, "c) Evaluating customer satisfaction levels.", 0);

-- Question 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the purpose of a mission statement in business management?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) To define the fundamental purpose and values of the organization.", 1),
(@test_id, @pregunta_id, 2, "b) To outline quarterly objectives.", 0),
(@test_id, @pregunta_id, 3, "c) To allocate resources efficiently.", 0);

-- Question 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the difference between a leader and a manager in a business context?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Leaders inspire and motivate, while managers focus on planning and execution.", 1),
(@test_id, @pregunta_id, 2, "b) Leaders prioritize tasks, while managers supervise employees.", 0),
(@test_id, @pregunta_id, 3, "c) Leaders manage resources, while managers develop strategies.", 0);

-- Question 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the purpose of a balance sheet in financial management?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) To provide a snapshot of a company's financial position at a specific point in time.", 1),
(@test_id, @pregunta_id, 2, "b) To track daily sales and expenses.", 0),
(@test_id, @pregunta_id, 3, "c) To forecast future revenue.", 0);

-- Question 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "What is the purpose of market segmentation in marketing?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) To divide a market into distinct groups with common needs and characteristics.", 1),
(@test_id, @pregunta_id, 2, "b) To set prices for products and services.", 0),
(@test_id, @pregunta_id, 3, "c) To create advertising campaigns.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('13', '4', '17');

-- Insertar el test de FP1
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de FP1', 1, 10, TRUE, FALSE);

-- Obtener el ID del test de FP1 para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un bucle 'for' en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Una estructura de control que repite un bloque de código un número específico de veces.", 1),
(@test_id, @pregunta_id, 2, "b) Una función para leer datos de entrada del usuario.", 0),
(@test_id, @pregunta_id, 3, "c) Una declaración para declarar variables.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una variable en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Un espacio de memoria con un nombre asociado utilizado para almacenar datos.", 1),
(@test_id, @pregunta_id, 2, "b) Una instrucción que toma una decisión basada en una condición.", 0),
(@test_id, @pregunta_id, 3, "c) Una función que realiza una tarea específica.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una condición 'if' en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Una estructura de control que ejecuta un bloque de código si se cumple una condición.", 1),
(@test_id, @pregunta_id, 2, "b) Una declaración para declarar variables.", 0),
(@test_id, @pregunta_id, 3, "c) Una función para repetir un bloque de código varias veces.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un 'switch' en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Una estructura de control que permite seleccionar entre múltiples opciones basadas en el valor de una variable.", 1),
(@test_id, @pregunta_id, 2, "b) Una función para leer datos de entrada del usuario.", 0),
(@test_id, @pregunta_id, 3, "c) Una instrucción para finalizar la ejecución de un bucle.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una función en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Un bloque de código que realiza una tarea específica y puede ser llamado desde otro lugar del programa.", 1),
(@test_id, @pregunta_id, 2, "b) Una instrucción que toma una decisión basada en una condición.", 0),
(@test_id, @pregunta_id, 3, "c) Una estructura de control que repite un bloque de código mientras se cumple una condición.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un puntero en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Una variable que almacena la dirección de memoria de otra variable.", 1),
(@test_id, @pregunta_id, 2, "b) Una instrucción que toma una decisión basada en una condición.", 0),
(@test_id, @pregunta_id, 3, "c) Una estructura de control que repite un bloque de código un número específico de veces.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la sobrecarga de funciones en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Definir múltiples funciones con el mismo nombre pero con diferentes parámetros.", 1),
(@test_id, @pregunta_id, 2, "b) Almacenar múltiples valores en una sola variable.", 0),
(@test_id, @pregunta_id, 3, "c) Crear una función que no devuelve ningún valor.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un 'array' en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Una colección ordenada de elementos del mismo tipo.", 1),
(@test_id, @pregunta_id, 2, "b) Un tipo de variable que almacena direcciones de memoria.", 0),
(@test_id, @pregunta_id, 3, "c) Una instrucción para repetir un bloque de código 
varias veces.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una referencia en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Un alias de una variable existente.", 1),
(@test_id, @pregunta_id, 2, "b) Un tipo de bucle utilizado para iterar sobre una colección de elementos.", 0),
(@test_id, @pregunta_id, 3, "c) Una estructura de control que permite seleccionar entre múltiples opciones.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la herencia en C++?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Un mecanismo que permite que una clase herede propiedades y comportamientos de otra.", 1),
(@test_id, @pregunta_id, 2, "b) Una instrucción para finalizar la ejecución de un bucle.", 0),
(@test_id, @pregunta_id, 3, "c) Una declaración para declarar variables.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('14', '1', '1');

-- Insertar el test de FC1
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de FC1', 1, 10, TRUE, FALSE);

-- Obtener el ID del test de FC1 para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la unidad central de procesamiento (CPU)?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es el componente principal de un ordenador que ejecuta instrucciones de programas almacenados en la memoria.", 1),
(@test_id, @pregunta_id, 2, "b) Es la memoria principal del ordenador que almacena datos y programas en ejecución.", 0),
(@test_id, @pregunta_id, 3, "c) Es un dispositivo de entrada que permite al usuario interactuar con el ordenador.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la memoria RAM?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es la memoria de acceso aleatorio que almacena temporalmente datos y programas en ejecución.", 1),
(@test_id, @pregunta_id, 2, "b) Es un tipo de memoria de almacenamiento no volátil que conserva los datos incluso cuando se apaga el ordenador.", 0),
(@test_id, @pregunta_id, 3, "c) Es un dispositivo de salida que muestra información visual al usuario.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un bit?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es la unidad más pequeña de información en un ordenador, con dos posibles valores: 0 y 1.", 1),
(@test_id, @pregunta_id, 2, "b) Es una unidad de almacenamiento que puede contener un valor numérico.", 0),
(@test_id, @pregunta_id, 3, "c) Es una instrucción básica que realiza una operación aritmética o lógica en un ordenador.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el disco duro?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un dispositivo de almacenamiento de datos no volátil que utiliza medios magnéticos para guardar información.", 1),
(@test_id, @pregunta_id, 2, "b) Es la unidad central de procesamiento que ejecuta instrucciones de programas.", 0),
(@test_id, @pregunta_id, 3, "c) Es la memoria de acceso aleatorio que almacena temporalmente datos y programas en ejecución.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el sistema operativo?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un software que actúa como intermediario entre el hardware del ordenador y los programas de aplicación.", 1),
(@test_id, @pregunta_id, 2, "b) Es un dispositivo de entrada que permite al usuario interactuar con el ordenador.", 0),
(@test_id, @pregunta_id, 3, "c) Es un componente del hardware que realiza cálculos y procesamiento de datos.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la arquitectura de von Neumann?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un modelo de arquitectura de computadoras que utiliza una memoria compartida para datos e instrucciones.", 0),
(@test_id, @pregunta_id, 2, "b) Es un modelo de arquitectura de computadoras que separa la memoria en dos secciones diferentes para datos e instrucciones.", 0),
(@test_id, @pregunta_id, 3, "c) Es un modelo de arquitectura de computadoras que utiliza la misma memoria para almacenar datos y programas en ejecución.", 1);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la memoria caché?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una memoria de acceso rápido que almacena copias de datos utilizados con frecuencia.", 1),
(@test_id, @pregunta_id, 2, "b) Es una memoria de almacenamiento permanente utilizada para almacenar datos y programas en el ordenador.", 0),
(@test_id, @pregunta_id, 3, "c) Es una memoria volátil utilizada para almacenar temporalmente datos y programas en ejecución.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el ciclo de instrucción en un procesador?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es el proceso mediante el cual se ejecuta una instrucción en un procesador, que incluye obtener, decodificar y ejecutar la instrucción.", 1),
(@test_id, @pregunta_id, 2, "b) Es el proceso de almacenar temporalmente datos y programas en ejecución en la memoria principal.", 0),
(@test_id, @pregunta_id, 3, "c) Es el proceso de acceder a datos almacenados en el disco duro.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un registro en un procesador?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un pequeño espacio de almacenamiento dentro del procesador utilizado para almacenar datos temporales y resultados intermedios.", 1),
(@test_id, @pregunta_id, 2, "b) Es una unidad de almacenamiento permanente utilizada para almacenar programas y datos en el ordenador.", 0),
(@test_id, @pregunta_id, 3, "c) Es un dispositivo de entrada utilizado para enviar datos al ordenador.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es el reloj del sistema en un ordenador?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un componente que regula la velocidad a la que se ejecutan las instrucciones en un procesador.", 1),
(@test_id, @pregunta_id, 2, "b) Es un dispositivo de entrada que permite al usuario interactuar con el ordenador.", 0),
(@test_id, @pregunta_id, 3, "c) Es un componente que almacena datos de manera permanente en el ordenador.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('15', '1', '2');

-- Insertar el test de AW
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de AW', 1, 10, TRUE, FALSE);

-- Obtener el ID del test de AW para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un lenguaje de programación de código abierto utilizado principalmente para el desarrollo de páginas web dinámicas.", 1),
(@test_id, @pregunta_id, 2, "b) Es un sistema de gestión de bases de datos relacionales ampliamente utilizado en el desarrollo web.", 0),
(@test_id, @pregunta_id, 3, "c) Es un framework de desarrollo web que facilita la creación de aplicaciones complejas.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un archivo PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un archivo de texto que contiene código PHP y se interpreta en el servidor para generar contenido web dinámico.", 1),
(@test_id, @pregunta_id, 2, "b) Es un archivo de hoja de estilo que define el diseño y la apariencia de una página web.", 0),
(@test_id, @pregunta_id, 3, "c) Es un archivo de script ejecutable que se ejecuta en el navegador del cliente para agregar funcionalidades a una página web.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una variable superglobal en PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una variable predefinida en PHP que está disponible en todos los ámbitos del script.", 1),
(@test_id, @pregunta_id, 2, "b) Es una variable que solo está disponible en un ámbito específico del script y no se puede acceder desde otras partes del código.", 0),
(@test_id, @pregunta_id, 3, "c) Es una variable que almacena información de sesión del usuario durante su interacción con la página web.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es MySQL?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un sistema de gestión de bases de datos relacionales ampliamente utilizado en el desarrollo web con PHP.", 1),
(@test_id, @pregunta_id, 2, "b) Es un lenguaje de programación utilizado para la creación de páginas web dinámicas.", 0),
(@test_id, @pregunta_id, 3, "c) Es un protocolo de comunicación utilizado para transferir archivos entre un servidor y un cliente.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un formulario HTML?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un elemento HTML que permite a los usuarios enviar datos al servidor para su procesamiento.", 1),
(@test_id, @pregunta_id, 2, "b) Es una estructura de control utilizada en PHP para repetir un bloque de código un número específico de veces.", 0),
(@test_id, @pregunta_id, 3, "c) Es una hoja de estilo utilizada para definir el diseño y la apariencia de una página web.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un bucle 'foreach' en PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un bucle utilizado para iterar sobre arrays y objetos.", 1),
(@test_id, @pregunta_id, 2, "b) Es un bucle utilizado para ejecutar un bloque de código mientras se cumple una condición.", 0),
(@test_id, @pregunta_id, 3, "c) Es un bucle utilizado para repetir un bloque de código un número específico de veces.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una función de usuario en PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una función definida por el usuario que realiza una tarea específica y puede ser llamada desde cualquier parte del script.", 1),
(@test_id, @pregunta_id, 2, "b) Es una función integrada en PHP que realiza una tarea específica, como imprimir texto en la pantalla.", 0),
(@test_id, @pregunta_id, 3, "c) Es una función que realiza operaciones matemáticas en PHP, como sumar o restar números.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la validación de formularios en PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es el proceso de verificar que los datos introducidos por el usuario en un formulario cumplan con ciertos criterios específicos.", 1),
(@test_id, @pregunta_id, 2, "b) Es el proceso de enviar los datos introducidos por el usuario en un formulario al servidor para su procesamiento.", 0),
(@test_id, @pregunta_id, 3, "c) Es el proceso de generar dinámicamente un formulario HTML en PHP.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es una sesión en PHP?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un mecanismo para mantener datos de usuario a lo largo de múltiples solicitudes HTTP.", 1),
(@test_id, @pregunta_id, 2, "b) Es un mecanismo para almacenar datos de usuario en cookies en el navegador del cliente.", 0),
(@test_id, @pregunta_id, 3, "c) Es un mecanismo para almacenar datos de usuario en archivos en el servidor.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la inyección de SQL?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una técnica de ataque utilizada para manipular una base de datos mediante la inserción de código SQL malicioso.", 1),
(@test_id, @pregunta_id, 2, "b) Es una técnica de codificación utilizada para proteger una base de datos de intrusiones externas.", 0),
(@test_id, @pregunta_id, 3, "c) Es una técnica de encriptación utilizada para proteger datos sensibles almacenados en una base de datos.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('16', '1', '3');

-- Insertar el test de Psicometría
INSERT INTO tests (titulo, ID_usuario, num_preguntas, es_publico, es_anonimo) VALUES
('Preparación examen final de Psicometría', 4, 10, TRUE, FALSE);

-- Obtener el ID del test de Psicometría para usarlo en las inserciones subsiguientes
SET @test_id := LAST_INSERT_ID();

-- Pregunta 1
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la psicometría?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una rama de la psicología que se ocupa de medir variables psicológicas, como la inteligencia, la personalidad y las aptitudes.", 1),
(@test_id, @pregunta_id, 2, "b) Es una técnica estadística utilizada para analizar datos psicológicos y sacar conclusiones sobre la población.", 0),
(@test_id, @pregunta_id, 3, "c) Es una teoría psicológica que explica el comportamiento humano en términos de impulsos y motivaciones inconscientes.", 0);

-- Pregunta 2
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es un test psicométrico?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un instrumento diseñado para medir una característica psicológica, como la inteligencia o la personalidad, mediante la evaluación de respuestas a preguntas específicas.", 1),
(@test_id, @pregunta_id, 2, "b) Es una técnica de entrevista utilizada para recopilar datos sobre el comportamiento y las experiencias de un individuo.", 0),
(@test_id, @pregunta_id, 3, "c) Es un método de observación utilizado para registrar el comportamiento en situaciones naturales.", 0);

-- Pregunta 3
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la confiabilidad en psicometría?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es la consistencia y estabilidad de las puntuaciones obtenidas en un test psicométrico.", 1),
(@test_id, @pregunta_id, 2, "b) Es la capacidad de un test para medir lo que pretende medir de manera precisa y sin sesgos.", 0),
(@test_id, @pregunta_id, 3, "c) Es la capacidad de un test para producir resultados similares cuando se administra en diferentes momentos o a diferentes grupos de personas.", 0);

-- Pregunta 4
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la validez en psicometría?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es la capacidad de un test para medir lo que pretende medir de manera precisa y sin sesgos.", 1),
(@test_id, @pregunta_id, 2, "b) Es la consistencia y estabilidad de las puntuaciones obtenidas en un test psicométrico.", 0),
(@test_id, @pregunta_id, 3, "c) Es la capacidad de un test para producir resultados similares cuando se administra en diferentes momentos o a diferentes grupos de personas.", 0);

-- Pregunta 5
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la normatividad en psicometría?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Son los estándares de referencia utilizados para interpretar las puntuaciones de un test en relación con la población de referencia.", 1),
(@test_id, @pregunta_id, 2, "b) Es la capacidad de un test para producir resultados similares cuando se administra en diferentes momentos o a diferentes grupos de personas.", 0),
(@test_id, @pregunta_id, 3, "c) Es la consistencia y estabilidad de las puntuaciones obtenidas en un test psicométrico.", 0);

-- Pregunta 6
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la escala Likert?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una escala de respuesta utilizada en encuestas y tests psicométricos que permite al participante expresar su grado de acuerdo o desacuerdo con una afirmación.", 1),
(@test_id, @pregunta_id, 2, "b) Es una técnica de muestreo utilizada para seleccionar una muestra representativa de una población.", 0),
(@test_id, @pregunta_id, 3, "c) Es una técnica estadística utilizada para analizar datos psicométricos y sacar conclusiones sobre la población.", 0);

-- Pregunta 7
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la teoría clásica de los tests?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un enfoque en psicometría que se centra en la medición de la confiabilidad y validez de los tests.", 1),
(@test_id, @pregunta_id, 2, "b) Es un enfoque en psicometría que se centra en el desarrollo de tests que midan una única dimensión psicológica.", 0),
(@test_id, @pregunta_id, 3, "c) Es un enfoque en psicometría que se centra en el análisis factorial de los tests para identificar las dimensiones subyacentes.", 0);

-- Pregunta 8
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la teoría de respuesta al ítem (TRI)?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es un enfoque en psicometría que modela la probabilidad de que un individuo responda correctamente a un ítem en función de sus habilidades y la dificultad del ítem.", 1),
(@test_id, @pregunta_id, 2, "b) Es un enfoque en psicometría que se centra en la medición de la confiabilidad y validez de los tests.", 0),
(@test_id, @pregunta_id, 3, "c) Es un enfoque en psicometría que se centra en el desarrollo de tests que midan una única dimensión psicológica.", 0);

-- Pregunta 9
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la teoría de los factores de segundo orden?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una teoría en psicometría que postula la existencia de factores de orden superior que explican la covariación entre factores de orden inferior.", 1),
(@test_id, @pregunta_id, 2, "b) Es una teoría en psicometría que se centra en la estructura interna de los tests y la relación entre sus ítems.", 0),
(@test_id, @pregunta_id, 3, "c) Es una teoría en psicometría que se centra en el análisis factorial de los tests para identificar las dimensiones subyacentes.", 0);

-- Pregunta 10
INSERT INTO preguntas (ID_test, pregunta) VALUES
(@test_id, "¿Qué es la teoría de los tests multinivel?");
SET @pregunta_id := LAST_INSERT_ID();
INSERT INTO opciones (ID_test, ID_pregunta, ID_opcion, opcion, correcta) VALUES
(@test_id, @pregunta_id, 1, "a) Es una teoría en psicometría que se centra en el análisis de datos provenientes de tests administrados en diferentes niveles, como individuos, grupos o instituciones.", 1),
(@test_id, @pregunta_id, 2, "b) Es una teoría en psicometría que modela la probabilidad de que un individuo responda correctamente a un ítem en función de sus habilidades y la dificultad del ítem.", 0),
(@test_id, @pregunta_id, 3, "c) Es una teoría en psicometría que postula la existencia de factores de orden superior que explican la covariación entre factores de orden inferior.", 0);

INSERT INTO test_asignatura (ID_test, ID_universidad, ID_asignatura) VALUES 
('17', '1', '6');

