import React, { useEffect, useState, forwardRef } from 'react';
import Graphline from '../../Organisms/graphline/graphline';
import TittleTab from '../../Atoms/tittleTab';
import TitlePdfInform from '../../Atoms/titlePdfInform';
import LoadingPage from '../loadingPage/loadingPage';
import ParagraphTextPdf from '../../Atoms/paragraphTextPdf';
import TitleTextPdf from '../../Atoms/titleTextPdf';
import SubTitleTextPdf from '../../Atoms/subtitleTextPdf';

import CardCompetitions from '../../Organisms/cardCompetitions/cardCompetitions'


// Create Document Component
const PdfGenerateInform = forwardRef(({ jsonApiCompetitions, jsonApiIntelligence, jsonApiSubject, jsonApiStyles, jsonApiVocation, name, isLoaded, intelligenceForCompentition, styleForCompentition, isDataIntelligences, isDataStyles }, ref) => {

    const [isLoadingInfo, setisLoadingInfo] = useState(true)

    useEffect(() => {
        setisLoadingInfo(isLoaded)
    }, [isLoaded])

    const InformationmultipleIntelligences = [
        {
            title: 'Inteligencia lógico-matemática',
            name: 'lógico-matemática',
            desc: 'Estudiante con habilidad en la resolución de problemas de pensamiento lógico y razonamiento numérico. Esta inteligencia comprende las capacidades de cálculo mental, operativo, razonamiento abstracto, razonamiento cuantitativo, pensamiento lógico.Es el tipo de inteligencia más tradicional, regularmente medida por los test de inteligencia.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta área suelen tener atracción por la resolución de problemas donde se involucren números, lecturas con datos cuantificables, estadísticos, comparativos y recursos pedagógicos como conteos regresivos, preguntas lógicas, juegos mentales.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de puzles mentales, adivinanzas numéricas, juegos de seriación mental u operativa o monitorias sobre temas vistos en clase, profundización en temas específicos o misterios matemáticos y exposición de saberes ante sus compañeros, participación en clubes matemáticos y vinculación a programas externos o internos como intercolegiados o concursos.'
        },
        {
            title: 'Inteligencia lingüística-verbal',
            name: 'lingüística-verbal',
            desc: 'Estudiante con habilidad en competencias lingüísticas y comunicativas estructuradas. Esta inteligencia se caracteriza por la facilidad para entablar conversaciones, globalizar datos, el interés y disfrute de la lectura, escritura o aprendizaje de idiomas, juegos de palabras, y demás habilidades que nos remiten al uso de la palabra.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta inteligencia gustarán de actividades que fomenten el uso comunicativo, los juegos y significado de las palabras, el orden sintáctico, los sonidos o las formas. Las propuestas de escritura, lectura, inferencia, relación intertextual, creatividad escritural, juegos con la voz, entre otros, captarán su atención.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia lingüística (en lengua materna y segundas lenguas) a través de invitaciones a debates, tareas de creatividad verbal, solicitudes especiales en tareas de oratoria (dar la bienvenida, palabras en alguna situación especial, lectura de programas, presentación de eventos), pedirle que escriba textos, poemas o guiones para teatro, vinculación en actividades externas o internas como concursos u olimpiadas lingüísticas, entre otras.'
        },
        {
            title: 'Inteligencia visual-espacial',
            name: 'visual-espacial',
            desc: 'Estudiante con habilidad para crear modelos mentales de formas, colores y texturas sobre lo que observa o percibe en el mundo exterior.  Es una inteligencia muy ligada a la imaginación, a la visualización y el sentido visual de las situaciones: espacio, ubicación y detalle.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta inteligencia transformarán sus pensamientos en imágenes, como sucede en el arte gráfico, gustarán de recursos pedagógicos basados en la realización de diseños, cuadros, diagramas e infografías. Se sentirán a gusto con la construcción de objetos, visualización de panoramas, pintura, modelado, dibujo, etc.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de peticiones especiales sobre realización de murales o gráficos sobre algún tema específico, ayuda en la remodelación u organización del salón, combinación de colores, tareas de creatividad visual, realización de maquetas o arquetipos, proyectos y exposiciones de arte, indagación sobre artistas visuales, eventos de fotografía, etc.'
        },
        {
            title: 'Inteligencia kinestésica-corporal',
            name: 'kinestésica-corporal',
            desc: 'Estudiante con habilidad para controlar los movimientos corporales, realizar actividades físicas y tener destrezas asociadas con el cuerpo. Esta inteligencia se caracteriza por el disfrute de sensaciones táctiles y habilidades corporales, son muy hábiles con el aprendizaje práctico o que involucre el movimiento y los retos corporales.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta inteligencia buscarán la acción, gustarán de recursos pedagógicos donde deban desplazarse, usar su cuerpo, sus manos, aprender a través del movimiento, sentir diversas experiencias a través del cuerpo, realizar mímica o imitar patrones corporales.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de juegos teatrales, tareas de creatividad motora, yincanas, competencias deportivas, programas de teatro, danza o juego, hacer solicitudes especiales para organizar sociodramas, presentaciones artísticas, muestras de capacidades físicas, vinculación a eventos internos y externos como concursos, competencias, etc.'
        },
        {
            title: 'Inteligencia musical',
            name: 'musical',
            desc: 'Estudiante con habilidad para percibir estímulos sonoros de forma lógica y estructurada. Esta inteligencia se caracteriza por la facilidad para comprender y expresarse a través de la música, ello implica reconocer los patrones musicales, ritmo, tonada, discriminar sonidos y frecuencias, ser sensibles a las situaciones auditivas. Así mismo crear sonidos, ritmos y melodías, composiciones musicales e interpretación de instrumentos con facilidad.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta inteligencia buscarán la sonoridad y el ritmo del mundo que lo rodea, gustará de recursos pedagógicos auditivos, uso de rimas, ritmos o patrones musicales, modificación de canciones, interpretación de instrumentos, descubrir sonidos del medio ambiente o el contexto.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de juegos musicales, crear canciones con temáticas de la clase, destacar su talento en presentaciones escolares o concursos externos, así como a nivel personal, solicitarle tareas musicales para abrir las clases o tener un momento de distensión en el salón, vinculación a programas internos o externos de potenciación o competición musical, entre otros.'
        },
        {
            title: 'Inteligencia interpersonal',
            name: 'interpersonal',
            desc: 'Estudiante con habilidad para relacionarse, empatizar y comprender a otras personas. Esta inteligencia se caracteriza por la facilidad para establecer relaciones con otras personas, tener habilidades para reconocer expresiones faciales, controlar la voz, expresar gestos ante determinadas situaciones sociales, ponerse en el lugar del otro o los otros, promover causas sociales, liderar situaciones políticas, de empoderamiento, con sentido humano.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta inteligencia gustarán de actividades de juego de roles, resolución de problemas éticos, humanos, bioéticos, realización de campañas o movimientos con un sentido social, obras sociales, entre otras.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de peticiones especiales sobre estrategias para generar empatía en el salón, vinculación a programas de ayuda emocional entre pares, campañas de liderazgo social, eliminación de violencias escolares, solicitar que busque experiencias o lecturas y las comparta con su grupo o en la emisora escolar, si hay un periódico o mural, pedirle que escriba alguna nota de reflexión sobre la convivencia, vincularlo a programas externos de liderazgo social, etc.'
        },
        {
            title: 'Inteligencia intrapersonal',
            name: 'intrapersonal',
            desc: 'Estudiante con habilidad para reconocer los sentimientos propios y mantener control emocional. Esta inteligencia se caracteriza por la facilidad para comprender los sentimientos propios y entrar en introspección productiva. Se refiere a habilidades para la autodirección, regulación, inhibición de conductas perjudiciales y reflexión sobre pensamientos internos. Son estudiantes que pueden transmitir tranquilidad, armonía y bienestar, tienen buena estima, son humildes, reconocen sus potenciales y comprende sus debilidades, las aceptan.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Un estudiante con predominio en esta inteligencia gustará de actividades de reflexión, meditación, introspección, comprensión de su historia familiar, temas psicológicos, moralejas, conclusiones personales, autobiografías, ejercicios de relajación, mindfulness, entre otras.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través del trabajo sobre reflexión e introspección, llevar al salón temas sobre autoestima, respeto propio, resiliencia; invitarlo a compartir sus reflexiones, pedirle que guíe ejercicios de meditación o respiración, crear estrategias para apoyar a sus demás compañeros, ofrecer lecturas sobre el tema de interés, pedir que lea libros específicos o crear espacios escolares para conversar sobre estos temas, conocer culturas donde se practique la introspección como las indígenas y las orientales.'
        },
        {
            title: 'Inteligencia naturalista',
            name: 'naturalista',
            desc: 'Estudiante con habilidad para comprender y disfrutar del entorno natural y la observación científica de la naturaleza. Esta inteligencia se caracteriza por la comprensión de los patrones naturales, el gusto por el estudio y protección del medio ambiente e interés en áreas como la biología, geología o astronomía. Suelen sentirse atraídos por fenómenos naturales, reacciones químicas, taxonomía o clasificaciones de fauna, flora.',
            subtitlePredominio: 'Predominio',
            descPredominio: 'Los estudiantes con predominio en esta inteligencia gustarán de actividades de exploración del medio, indagación, deducción, investigación e hipótesis, podrán realizar comparaciones de hechos naturales, construcción de modelos teóricos, entre otras.',
            subtitleRecomendation: 'Recomendaciones',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de vinculación a proyectos científicos internos y externos, semanas de la ciencia, proyectos para crear, cuidar o mejorar los laboratorios escolares, solicitarle monitorias a estudiantes menos avanzados o interesados en el tema, pedirle que profundice en algunos temas o misterios científicos y los exponga en el salón, involucrar al estudiante en actividades internas o externas como olimpiadas, programas interinstitucionales, etc.'
        }

    ]


    const InformationLearningStyles = [
        {
            title: 'ESTILO DE APRENDIZAJE CONVERGENTE',
            name: 'convergentes',
            desc: 'Combina la conceptualización abstracta y la experimentación activa.',
            feature: [
                'Es un estudiante reflexivo que le gusta comprender los temas y después aplicar de manera práctica las ideas.',
                'Se desempeña mejor en pruebas de una sola respuesta o de soluciones concretas.',
                'Concreta el conocimiento para lograr resolver problemas usando el razonamiento hipotético – deductivo (primero teoriza y después aplica).',
                'Se orienta más al trabajo con herramientas que con otras personas.',
                'Le gusta la exploración científica, es práctico y transfiere lo que aprende.',
                'Puede explicar la teoría, pero no se siente demasiado atraído por exponer.',
                'Comprende fácilmente los temas nuevos cuando se le conceptualiza.',
                'Procesa bien la información que recibe.',
                'Resuelve de manera ágil los problemas cuando se les permite indagar sobre ellos.',
                'Aplica muy bien la teoría, es metódico.',
                'Le gusta seguir pasos o instrucciones, se siente seguros con ello.'
            ],
            subtitleMetodology: 'Metodología preferente',
            preferenMetodology: ['A un estudiante con pensamiento convergente explíquele muy bien la tarea antes de pasar a la acción, el paso a paso, el por qué, se le deben brindar actividades para que pueda aplicar el conocimiento y después pedirle que explique lo aprendido a usted o a alguno de compañeros (no en público si no lo desea).'],
            subtitledificult: 'Presentará dificultades cuando',
            dificult: [
                'Deba a ser el centro de atención sin preparación previa.',
                'Se le apresure a pasar de una actividad a otra si no se ha culminado.',
                'Deba realizar una actividad sin planificarla previamente.',
                'Haya cambios bruscos de rutina sin anticipación o explicación.',
                'Deba trabajar en grupo sin una sensibilización previa de todos los integrantes, sobre el respeto a los ritmos de trabajo.'
            ]
        },
        {
            title: 'ESTILO DE APRENDIZAJE DIVERGENTE',
            name: 'divergentes',
            desc: 'Combina la experiencia concreta y la observación reflexiva.',
            feature: [
                'Es un estudiante activo que comprende mejor lo concreto y después realiza un análisis sobre la experiencia.',
                'Tiene gran capacidad de imaginación, puede considerar las circunstancias y los planteamientos desde muchas perspectivas.',
                'Le gusta producir ideas y resolver problemas innovando.',
                'Es kinestésico, aprende con el movimiento.',
                'Se adapta bien a las circunstancias y a los cambios.',
                'Le gusta que le expliquen utilizando todo el cuerpo.',
                'Es informal, rompe reglas y paradigmas tradicionales.',
                'Le gustan las diferentes formas de ver y hacer las cosas.'
            ],
            subtitleMetodology: 'Metodología preferente',
            preferenMetodology: ['A un estudiante con pensamiento divergente le gustan los juegos de simulación, proponer nuevos enfoques a un tema, la lluvia de ideas, predecir resultados, utilizar analogías, metáforas, realizar experimentos, construir mapas mentales, rompecabezas, ensamblar piezas, le gustan los acertijos y los juegos de palabras.'],
            subtitledificult: 'Presentará dificultades cuando',

            dificult: [
                'Deba cumplir un rol pasivo o permanecer en silencio o quietud.',
                'Se le pongan actividades para analizar e interpretar datos, antes de haberlos aplicado.',
                'Deba trabajar solo sobre el análisis de una situación o comprensión de un concepto.',
                'Deba presentar argumentos teóricos sobre sus respuestas o acciones.'
            ]
        },
        {
            title: 'ESTILO DE APRENDIZAJE ASIMILADOR',
            name: 'asimiladores',
            desc: 'Combina la conceptualización abstracta y la observación reflexiva.',
            feature: [
                'Es un estudiante que le gusta teorizar, primero estudia el tema en cuestión y después realiza una observación meticulosa sobre la experiencia, sin que deba necesariamente participar en ella.',
                'Logra deducir e inferir, al punto de poder hacer conjeturas y crear modelos teóricos.',
                'Tiene un razonamiento inductivo, relaciona experiencias propias o ajenas en explicaciones globales.',
                'Se interesa más por los contenidos de tipo analítico y abstracto que por los temas humanistas.',
                'Prefiere la teoría y la comprensión conceptual que la práctica y el movimiento.',
                'Le apasiona la investigación y la ciencia.',
                'Puede llevar en orden sus apuntes y tener hábitos propios de estudio.',
                'Se concentra en comprender y aprender.',
                'Para dar por hecho alguna situación o aprendizaje, se le debe comprobar con argumentos claros.'
            ],
            subtitleMetodology: 'Metodología preferente',
            preferenMetodology: ['A un estudiante con pensamiento asimilador le gustan los ejercicios de reflexión, de razonamiento sobre lo aprendido, mapas mentales, organizadores gráficos y todas aquellas actividades que requieran inferencia de pensamiento y análisis conceptual. Regularmente actúa bajo una secuencia establecida, es rígido y lógico en sus acciones.', 'Le gustan los informes escritos, las investigaciones y profundizaciones sobre determinados asuntos. Pedirle que tome apuntes y los lleve de manera ordenada, realizar actividades de escucha y presentar conferencias, proponer lecturas específicas y organizar datos de investigaciones o deducción, análisis de datos y estadística le mantendrá motivado al aprendizaje.'],
            subtitledificult: 'Presentará dificultades cuando',
            dificult: [
                'Las actividades sean de respuesta ambigua o le pongan en incertidumbre.',
                'Cuando deba realizar actividades de orden emocional, expresivo o interpersonal.',
                'Cuando deba hablar a los demás sobre sí mismo puesto que suele ser muy reservado.',
                'Deba actuar por intuición y no por razonamiento.',
                'Deba realizar las actividades de manera desestructurada o saltarse la rutina o los pasos.',
                'Deba dar discursos sin sentido claro o específico.',
                'Deba hacer actividades de movimiento, deporte o arte escénico.'
            ]
        },
        {
            title: 'ESTILO DE APRENDIZAJE ACOMODADOR',
            name: 'acomodadores',
            desc: 'Combina la experiencia concreta y la experimentación activa.',
            feature: [

                'Es un estudiante práctico, le gusta experimentar y aplicar respuestas intuitivas sobre las actividades.',
                'Practica el ensayo y error.',
                'Se involucra en experiencias nuevas.',
                'Es arriesgado y le gusta la aventura, afrontar retos.',
                'Se acomoda de manera muy fácil a las situaciones nuevas o sin demasiada estructura.',
                'No le incomodan los cambios de planes ni el salto de pasos o rutinas.',
                'Suele ser muy práctico en la realización de las actividades.',
                'Si una instrucción no se le da o se le complica la tarea, descarta esa instrucción y la hace a su manera.',
                'Si la teoría no tiene aplicabilidad, no la valida, prefiere crear otros argumentos teóricos desde la práctica.',
                'Se siente cómodo con las personas y trabajo humanístico.',
                'Disfruta las actividades inter e intrapersonales.',
                'Puede ser “acelerado” y “acelerar a los demás”.',
                'Le atraen los movimientos políticos, la docencia, las actividades técnicas o que requieran peripecias.',
                'Es buen negociante, aunque no muy organizado con las cuentas.',
                'Actúa por intuición, anticipa soluciones.',
                'Puede relacionar experiencias previas propias o ajenas para aplicarlas a distintos objetivos.',
                'Es imaginativo, visualiza los planes y situaciones.',
                'Es dramático, vivencial y emocional.',
                'El entorno y la armonía juegan un papel fundamental para él, igual que las condiciones ambientales (iluminación, temperatura, olores).',
                'Este estudiante tendrá que ocuparse en alguna actividad manual en los momentos de explicación en las clases magistrales, por lo que se pondrá a dibujar, rayar, o hará movimientos en el puesto. No lo reprima es su método de concentración, puede darle alguna actividad para hacer como pintar mandalas, tejer, recortar, etc.'
            ],
            subtitleMetodology: 'Metodología preferente',
            preferenMetodology: ['A un estudiante con pensamiento acomodador, le gustan mucho los trabajos grupales, ejercicios donde deba imaginar, crear, hacer, utilizar lenguajes artísticos, discusiones socializadas o sociodramas. Prefiere la lectura por tramos cortos, puede inferir muy bien sobre el contenido si no es muy extenso. Le atraen los gráficos ilustrativos, las composiciones con figuras literarias y las actividades de ensayo - error, la lectura de un texto dependerá de su emocionalidad e interés sobre el tema. Para la enseñanza de matemáticas y áreas de ciencias exactas, deberá utilizarse la lúdica y lo vivencial.', 'Cuando las temáticas sean abstractas, se sugiere que al estudiante se le valoren más las prácticas y menos la conceptualización. Se le puede apoyar el aprendizaje conceptual a través de mnemotecnias, por ejemplo: uso de tarjetas para recordar las fórmulas matemáticas, físicas, químicas, lingüísticas (ortográficas, sintácticas, prosódicas), instrucciones, paso a paso en tareas donde se requiera recordar datos precisos, entre otras.'],
            subtitledificult: 'Presentará dificultades cuando',
            dificult: [
                'El tema enseñado no tenga relación con su vida diaria o sus intereses.',
                'No pueda aplicar lo aprendido.',
                'La teoría no tenga un fin específico o no esté relacionada con la realidad.',
                'Si el estudiante es sancionado por no aprender o rendir en alguna materia, tomará distancia al punto de mostrarse apático y desinteresado.',
                'Deba trabajar solo o responder de memoria sobre conceptos.',
                'Se le evalúa la capacidad memorística para obtener una nota final.'
            ]
        }
    ]

    const profiles = [
        {
            title: 'Áreas Contables y Administrativas.',
            name: "áreas contables y administrativas",
            text: 'Este perfil indica que el estudiante:',
            list: [
                'Tiene preferencia por actividades como organizar, supervisar, ordenar, analizar y sintetizar, lleva cuentas mentales y estadísticas de las situaciones de la vida cotidiana.',
                'Puede preferir el trabajo individual, pero sus análisis son grupales, generales y cuantitativos en relación a todo su grupo.',
                'Lidera en el grupo, reparte tareas y las monitoriza. Es persuasivo, objetivo, práctico, es responsable y visionario, saca el máximo provecho a las situaciones que vive.'
            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como: ADMINISTRACIÓN DE EMPRESAS, ADUANAS, COMERCIO, COMERCIO INTERNACIONAL, CONTABILIDAD Y FINANZAS, CONTADURÍA, CRIMINALÍSTICA E INVESTIGACIÓN JUDICIAL, EMPRENDIMIENTO EMPRESARIAL, FINANZAS, GESTIÓN EMPRESARIAL, LOGÍSTICA, MERCADEO, VENTAS, NEGOCIOS INTERNACIONALES, SECRETARIADO EJECUTIVO, SEGURIDAD OCUPACIONAL, ESTADÍSTICA, TESORERÍA.'
        },
        {
            title: 'Áreas Humanísticas y Sociales.',
            name: "áreas humanísticas y sociales",
            text: 'Este perfil indica que el estudiante:',
            list: [
                'Tiene preferencia por actividades del uso de la palabra o el discurso, goza de precisión verbal, organiza y convoca.',
                'Tiende a generar actividades de organización social, establece relaciones sociológicas o fenómenos sociales.',
                'Puede tener un pensamiento crítico que comparte y expone ante sus compañeros',
                'Manifiesta expresiones de orden y justicia social.',
                'Es responsable, justo, conciliador, persuasivo, sagaz e imaginativo.',
                'Puede crear estrategias sociales y regularmente es escuchado por las demás personas.',
                'Se puede mostrar cómo una persona apasionada por los temas sociales, lingüísticos e inherentes a la humanidad.',
                ' Puede ser hábil para aprender diversos idiomas.',
                'Puede ser hábil en dar instrucciones, enseñar o interesarse por asuntos pedagógicos.'
            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como: IDIOMAS, ESTUDIOS LINGÜÍSTICOS, ETNOGRAFÍA, SOCIOLOGÍA, POLITOLOGÍA, DOCENCIA, LICENCIATURAS, PEDAGOGÍA, PERIODISMO, ANTROPOLOGÍA, FILOSOFÍA, HISTORIA, HUMANIDADES, LITERATURA, TEOLOGÍA, TRABAJO SOCIAL, TURISMO, ENTRE OTRAS.'
        },
        {
            title: 'Áreas Artísticas.',
            name: "áreas artísticas",
            text: 'Este perfil indica que el estudiante:',
            list: [

                'Las actividades estéticas, logra la armonía en sus trabajos tanto a nivel visual, como auditivo y de movimiento.',
                'Gusta de las actividades manuales, sus habilidades perceptuales son altas y logra interrelacionar sensaciones y estímulos de diferente índole.',
                'Manifiesta sensibilidad frente al arte, es imaginativo y creativo, trabaja al detalle, le gusta innovar y se caracteriza por ser intuitivo.',
                'Le gusta crear, reflexionar sobre las situaciones del entorno y expresar sus pensamientos desde el arte.',
                'Puede mostrarse interesado por expresar críticas sociales a través de manifestaciones artísticas.',
                'Tiene ideas creativas e innovadoras que aplica a la realidad.',
                'Puede manifestar alta creatividad a nivel verbal, visual y/o motriz.',
                'Puede mostrarse atraído por intereses poco comunes: comics, anime, música alternativa, modas, etc.',
            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como:   ACTUACIÓN Y TEATRO, ARTES PLÁSTICAS, BALLET Y DANZA, CINE, TELEVISIÓN, COMUNICACIÓN GRÁFICA Y SOCIAL, CONFECCIÓN Y DISEÑO DE MODAS, DEPORTE, DISEÑO, DISEÑO GRÁFICO Y PUBLICITARIO, ESTÉTICA Y COSMETOLOGÍA, FOTOGRAFÍA, GASTRONOMÍA, COCINA Y CULINARIA, HOTELERÍA Y TURISMO, MODAS, DISEÑO, MODELAJE, MULTIMEDIA, MÚSICA, PRODUCCIÓN RADIO Y TV, TECNÓLOGO, PUBLICIDAD, ENTRE OTRAS.'
        },
        {
            title: 'Áreas de Salud y medicina.',
            name: "áreas de salud y medicina",
            text: 'Este perfil indica que el estudiante:',
            list: [
                'Actividades relacionadas con brindar asistencia a los demás.',
                'Es investigativo, le gusta trabajar con precisión, es analítico y le gusta ayudar a personas y/0 animales.',
                'Es altruista, solidario, paciente, y comprensivo, regularmente actúa con alteridad.',
                'Es persuasivo en sus intereses.',
                'Le gusta generar y corroborar hipótesis.',
                'Hace relaciones o crea hipótesis entre medicina y salud.',
                'Infiere el porqué de las dolencias físicas o los malestares.'
            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como: MEDICINA, ENFERMERÍA, FARMACIA, FISIOTERAPIA, LOGOPEDIA, NUTRICIÓN, ODONTOLOGÍA, ÓPTICA, OPTOMETRÍA, MEDICINA TRADICIONAL, PODOLOGÍA, PSICOLOGÍA CLÍNICA, TERAPIA OCUPACIONAL, VETERINARIA, PSIQUIATRÍA, NEUROPSICOLOGÍA, QUÍMICA FARMACÉUTICA, Y DEMÁS CIENCIAS DE LA SALUD.'
        },
        {
            title: 'Áreas de Ingeniería y Computación.',
            name: "áreas artísticas",
            text: 'Este perfil indica que el estudiante:',
            list: [
                'Las actividades donde implique utilizar objetos, máquinas o herramientas para generar mayor productividad.',
                'Se interesa por el funcionamiento de los aparatos, indaga en ellos y propone tanto arreglos como mejoras.',
                'Trabaja buscando la exactitud en la práctica y el funcionamiento más productivo de las herramientas.',
                'Planifica las acciones buscando la precisión y la eficacia.',
                'Es crítico, analítico e innovador.',
                'Puede tender a la rigidez, defiende sus ideas y teorías aplicándolas.',
                'Comprende el uso de códigos de manera intuitiva.',
                'Aplica el pensamiento lógico, aplica soluciones prácticas en problemas cotidianos, si no funcionan, aplica nuevas estrategias hasta lograr encontrar la más acertada.'
            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como: DESARROLLO DE SOFTWARE, REDES Y DESARROLLO, COMPUTACIÓN, ANIMACIÓN, INGENIERÍA DE SISTEMAS, TELECOMUNICACIONES, INGENIERÍA INFORMÁTICA, SISTEMAS, TECNOLOGÍAS DE LA INFORMACIÓN Y LAS COMUNICACIONES, ENTRE OTRAS.'
        },
        {
            title: 'Áreas de Defensa y Seguridad  ',
            name: "áreas de defensa y seguridad",
            text: 'Este perfil indica que el estudiante:',
            list: [
                'Tiene un amplio sentido de la justicia y la equidad.',
                'Busca el trabajo en equipo e intenta que todas las personas del grupo trabajen.',
                'Colabora y lidera, es solidario.',
                'Es arriesgado, valiente, persuasivo.',
                'En ocasiones puede tender a reaccionar de forma fuerte, su carácter puede tender a ser rígido.',
                'Es protector y estratega.',
                'Tiende a utilizar la fuerza física ante alguna necesidad o resolución de un problema.'

            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como: ACCIDENTOLOGÍA Y PREVENCIÓN VIAL, BALÍSTICA, FUERZA NAVAL, FUERZA AÉREA, POLICÍA, CARRERA MILITAR, RESCATISTA, BOMBERO, ABOGACÍA, SEGURIDAD CIUDADANA, DEPORTE DE CONTACTO, TRABAJO EN ALTURAS, PARACAIDISMO, DEPORTES EXTREMOS, ETC.'
        },
        {
            title: 'Áreas de Ciencias Exactas y agrícolas',
            name: "áreas de ciencias exactas y agrícolas",
            text: 'Este perfil indica que el estudiante:',
            list: [
                'Las actividades relacionadas con investigación, orden, clasificación y organización.',
                'Tiene amplias capacidades para indagar, construir hipótesis, analizar y sintetizar.',
                'Su lógica tiende a ser cuantitativa y estadística.',
                'Es metódico, analítico, observador.',
                'Puede mostrarse introvertido, pero es paciente y seguro de sí mismo.',
                'Cuando argumenta algo, lo hace porque lo ha confirmado previamente.',
                'Teoriza, comprueba y le gusta mostrar sus indagaciones a los demás.',
                'Si se interesa por algún tema pregunta a expertos o busca información adicional.'
            ],
            works: 'Por ello podría encauzar su proceso de formación en carreras como: ASTRONOMÍA, ASTROFÍSICA, BIOLOGÍA, BIOQUÍMICA, BIOTECNOLOGÍA, CIENCIA E INGENIERÍA DE DATOS, CIENCIA Y TECNOLOGÍA DE LOS ALIMENTOS, CIENCIAS AMBIENTALES, CIENCIAS BIOMÉDICAS, CIENCIAS DEL MAR, CIENCIAS EXPERIMENTALES, FÍSICA, GENÉTICA, GEOLOGÍA, MATEMÁTICAS, NANOCIENCIA, NANOTECNOLOGÍA, QUÍMICA, ENTRE OTRAS'
        }
    ]


    if (isLoadingInfo) {
        return (<LoadingPage />)
    } else {
        return (
            <div>
                <ul className="nav justify-content-around nav-tabs" role="tablist">
                    <li className="nav-item">
                        <a className="nav-link-conventions active  " href="#intelligences" role="tab" data-toggle="tab">Informe por Inteligencias múltiples, estilos y perfil vocacional</a>
                    </li>
                    <li className="nav-item">
                        <a className="nav-link-conventions " href="#informes1" role="tab" data-toggle="tab" >informe de asignaturas</a>
                    </li>
                </ul>
                <div className="tab-content" ref={ref}>
                    <div role="tabpanel" className="tab-pane fade " id="informes1" >
                        <div className="content-pdf" >
                                    <div className="offset-3 col-6">
                                        <img src={__webpack_public_path__+'img/logo.png'} className="img-fluid"  alt="Responsive image" />
                                    </div>
                            <TitlePdfInform title={`Informe de DBA`} />
                            <SubTitleTextPdf text={`Informe de: ${name}`} />
                            <TitlePdfInform title='Recomendaciones por asignaturas' />
                            {
                                jsonApiSubject.map(
                                    (item, i) => <div key={i} className='content-text-of-inform'>
                                        <TitleTextPdf text={item.name} />
                                        {
                                            item.subjects.map(
                                                (subject, i) => <div key={i}>
                                                    <SubTitleTextPdf text={subject.name} />
                                                    <label>
                                                        <strong>Rendimiento:  </strong>  {subject.performance}
                                                    </label>
                                                    <ParagraphTextPdf text={subject.recomendation} />
                                                    {subject.all_dbas.length > 0
                                                        &&
                                                        <div>
                                                            <ParagraphTextPdf text={"Estos son los DBA que se debe reforzar"} />

                                                            <ul>
                                                                <dl>
                                                                    {
                                                                        subject.all_dbas.map(

                                                                            (text) => <dd>
                                                                                {
                                                                                    text !== null &&
                                                                                    <li type="disc">
                                                                                        <div className="list-pdf py-1" >{text}</div>
                                                                                    </li>
                                                                                }
                                                                            </dd>
                                                                        )
                                                                    }
                                                                </dl>
                                                            </ul>
                                                        </div>
                                                    }
                                                </div>

                                            )
                                        }
                                    </div>
                                )
                            }
                        </div>
                    </div>
                    <div role="tabpanel" className="tab-pane fade in active show" id="intelligences" >
                        <div className="content-pdf" >
                            <div className="offset-3 col-6" >
                                    <img src={__webpack_public_path__+'img/logo.png'} class="img-fluid"  alt="Responsive image" />
                            </div>
                            <div>

                                <TitlePdfInform title={`Informe por Inteligencias múltiples, estilos y perfil vocacional`} />
                                <SubTitleTextPdf text={`Informe de: ${name}`} />
                                <TitlePdfInform title='Inteligencias múltiples' />

                                <div className='d-flex justify-content-center'>
                                    <div className=' col-md-12'>
                                        <Graphline jsonApi={jsonApiIntelligence} />
                                    </div>
                                </div>
                                {isDataIntelligences &&
                                    InformationmultipleIntelligences.map(
                                        (item, i) => {
                                            if (
                                                jsonApiIntelligence.find(
                                                    recomendation => recomendation.name === item.name
                                                ) !== undefined
                                            ) {
                                                return (
                                                    <div key={i} className='content-text-of-inform'>
                                                        <TitleTextPdf text={item.title} />
                                                        <ParagraphTextPdf text={item.desc} />
                                                        <SubTitleTextPdf text={item.subtitlePredominio} />
                                                        <ParagraphTextPdf text={item.descPredominio} />
                                                        <SubTitleTextPdf text={item.subtitleRecomendation} />
                                                        <ParagraphTextPdf text={item.recomendation} />

                                                    </div>
                                                )
                                            }
                                        }

                                    )
                                }
                            </div>
                            <div className="breakPagePdf">
                                <TitlePdfInform title='Estilos de aprendizaje' />
                                <SubTitleTextPdf text={`Informe de: ${name}`} />

                                <div className='d-flex justify-content-center'>
                                    <div className=' col-md-12'>
                                        <Graphline jsonApi={jsonApiStyles} />
                                    </div>
                                </div>
                                {isDataStyles &&
                                    InformationLearningStyles.map(
                                        (item, i) => {
                                            if (
                                                jsonApiStyles.find(
                                                    recomendation => recomendation.name === item.name
                                                ) !== undefined
                                            ) {
                                                return (
                                                    <div key={i} className='content-text-of-inform'>
                                                        <TitleTextPdf text={item.title} />
                                                        <ParagraphTextPdf text={item.desc} />
                                                        <SubTitleTextPdf text={"Características"} />
                                                        <ul>
                                                            <dl>
                                                                {
                                                                    item.feature.map(

                                                                        (text, i) => <dd key={i}>
                                                                            <li type="disc">
                                                                                <div className="list-pdf py-1" >{text}</div>
                                                                            </li>
                                                                        </dd>
                                                                    )
                                                                }
                                                            </dl>
                                                        </ul>
                                                        <SubTitleTextPdf text={item.subtitleMetodology} />
                                                        {
                                                            item.preferenMetodology.map(

                                                                (text, i) =>
                                                                    <ParagraphTextPdf key={i} text={text} />
                                                            )
                                                        }
                                                        <SubTitleTextPdf text={item.subtitledificult} />
                                                        <ul>
                                                            <dl>
                                                                {
                                                                    item.dificult.map(

                                                                        (text, i) => <dd key={i}>
                                                                            <li type="disc">
                                                                                <div className="list-pdf py-1" >{text}</div>
                                                                            </li>
                                                                        </dd>
                                                                    )
                                                                }
                                                            </dl>
                                                        </ul>
                                                    </div>
                                                )
                                            }
                                        }
                                    )
                                }

                            </div>
                            {
                                jsonApiVocation.length > 0 &&
                                <div className="breakPagePdf"  >
                                    <TitlePdfInform title='Perfiles de orientación vocacional' />
                                    <SubTitleTextPdf text={`Informe de: ${name}`} />


                                    {profiles.map(
                                        (item, i) =>
                                            <div key={i}>
                                                {jsonApiVocation.find(
                                                    recomendation => recomendation.name === item.name
                                                ) !== undefined &&
                                                    <div>
                                                        <TitleTextPdf text={item.title} />
                                                        <ParagraphTextPdf text={item.text} />
                                                        <ul>
                                                            <dl>
                                                                {
                                                                    item.list.map(

                                                                        (text, i) => <dd key={i}>
                                                                            <li type="disc">
                                                                                <div className="list-pdf py-1" >{text}</div>
                                                                            </li>
                                                                        </dd>
                                                                    )
                                                                }
                                                            </dl>
                                                        </ul>
                                                        <ParagraphTextPdf text={item.works} />
                                                    </div>

                                                }
                                            </div>
                                    )}
                                </div>

                            }
                            {/* {
                                profiles.map(
                                    (item, i) => <div key={i} className='content-text-of-inform'>
                                        <TitleTextPdf text={item.title} />
                                        <ParagraphTextPdf text={item.text} />
                                        <ul>
                                            <dl>
                                                {
                                                    item.list.map(

                                                        (text) => <dd>
                                                            <li type="disc">
                                                                <div className="list-pdf py-1" >{text}</div>
                                                            </li>
                                                        </dd>
                                                    )
                                                }
                                            </dl>
                                        </ul>
                                        <ParagraphTextPdf text={item.works} />
                                    </div>
                                )
                            } */}

                        </div>
                    </div>
                </div>
            </div>

        )
    }



})

export default PdfGenerateInform;
