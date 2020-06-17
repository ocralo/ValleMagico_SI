<?php

use Illuminate\Database\Seeder;
use App\SubjectMiniGame;

class SubjectMiniGamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects_id_array = [3, 3, 3, 1, 1, 1, 2, 2, 2, null, 3, 3, 3, 1, 1, 1, 2, 2, 2, null, 3, 3, 3,
                            1, 1, 2, 2, 2, null, 3, 3, 3, 1, 1, 1, 2, 2, null, 1, 3, 3, 3, 1, 1, 2, 2,
                            null, 3, 3, 1, 1, 2, 2, null, 1, 3, 2, 4, 3, 3, 1, 1, 2, 2, null, 3, 3, 1, 1,
                            2, 2, null, 3, 3, 1, 1, 2, 2, null, 3, 3, 1, 1, 2, 2, null, 1, 3, 2, 4, 1, 3,
                            1, 3, 1, 3, 1, 3, 1, 3, 1, 3, 1, 3, 1, 3, 1, 3, 1, 3, 2, 2, 2, 2, 2, 2, 2, 2,
                            6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 6, 5,
                            5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5, null,
                            null, null, null, null, null, null, null, null, null, null, null, null, null,
                            null, null, null, null, null, null, null, null, null, null, null, 4, 4, 4, 4,
                            4, 4, 4, 4, 4, 4, 4];

        $dbas_array = ['Identifica las relaciones sonoras en el lenguaje oral.', 
                        'Establece relaciones e interpreta imágenes, letras, objetos, personajes que encuentra en distintos tipos de textos.',
                        'Compara, ordena, clasifica objetos e identifica patrones de acuerdo con diferentes criterios. Establece relaciones e interpreta imágenes, letras, objetos, personales que encuentra en distintos tipos de texto.',
                        'Compara, ordena, clasifica objetos e identifica patrones de acuerdo con diferentes criterios.',
                        'Compara, ordena, clasifica objetos e identifica patrones de acuerdo con diferentes criterios.',
                        'Construye nociones de espacio, tiempo y medida a través de experiencias cotidianas.',
                        'Reconoce instrucciones sencillas relacionadas con su entorno inmediato, y responde a ellas de manera no verbal. Asocia imágenes con sonidos de palabras relacionadas con su casa y salón de clases de manera no verbal.',
                        'Reconoce instrucciones sencillas relacionadas con su entorno inmediato, y responde a ellas de manera no verbal. Asocia imágenes con sonidos de palabras relacionadas con su casa y salón de clases de manera no verbal.',
                        'Asocia imágenes con sonidos de palabras relacionadas con su casa y salón de clases de manera no verbal. Reconoce instrucciones sencillas relacionadas con su entorno inmediato, y responde a ellas de manera no verbal.',
                        null, 'Interpreta textos literarios como parte de su iniciación en la comprensión de textos.', 
                        'Interpreta diversos textos a partir de la lectura de palabras sencillas y de las imágenes que contienen.',
                        'Interpreta diversos textos a partir de la lectura de palabras sencillas y de las imágenes que contienen.',
                        'Identifica los usos de los números (como código, cardinal, medida, ordinal) y las operaciones (suma y resta) en contextos de juego, familiares, económicos, entre otros. Utiliza diferentes estrategias para contar, realizar operaciones (suma y resta) y resolver problemas aditivos.',
                        'Identifica los usos de los números (como código, cardinal, medida, ordinal) y las operaciones (suma y resta) en contextos de juego, familiares, económicos, entre otros.',
                        'Reconoce y compara atributos que pueden ser medidos en objetos y eventos (longitud, duración, rapidez, masa, peso, capacidad, cantidad de elementos de una colección, entre otros).',
                        'Comprende y realiza declaraciones sencillas, usando expresiones ensayadas, sobre su entorno inmediato.',
                        'Comprende y realiza declaraciones sencillas, usando expresiones ensayadas, sobre su entorno inmediato (casa y escuela).',
                        'Comprende y realiza declaraciones sencillas, usando expresiones ensayadas, sobre su entorno inmediato (casa y escuela).', null,
                        'Predice y analiza los contenidos y estructuras de diversos tipos de texto, a partir de sus conocimientos previos.',
                        'Produce diferentes tipos de textos para atender a un propósito comunicativo particular.',
                        'Identifica las palabras relevantes de un mensaje y las agrupa en unidades significativas: sonidos en palabras y palabras en oraciones.',
                        'Utiliza diferentes estrategias para contar, realizar operaciones (suma y resta) y resolver problemas aditivos.',
                        'Utiliza el Sistema de Numeración Decimal para comparar, ordenar y establecer diferentes relaciones entre dos o más secuencias de números con ayuda de diferentes recursos.',
                        'Comprende y realiza declaraciones sencillas, usando expresiones ensayadas, sobre su entorno inmediato (casa y escuela).',
                        'Comprende la secuencia de una historia corta y sencilla sobre temas familiares.',
                        'Comprende ideas sencillas sobre temas estudiados. Comprende aspectos culturales propios de su entorno, usando vocabulario y expresiones conocidas.',
                        null, 'Interpreta el contenido y la estructura del texto.', 'Interpreta el contenido y la estructura del texto.',
                        'Interpreto el contenido y estructura de la situación comunicativa, atendiendo al orden inferencial y crítico.',
                        'Interpreta, formula y resuelve problemas aditivos de composición, transformación y comparación en diferentes contextos; y multiplicativos, directos e inversos, en diferentes contextos.',
                        'Interpreta, formula y resuelve problemas aditivos de composición, transformación y comparación en diferentes contextos; y multiplicativos, directos e inversos, en diferentes contextos.',
                        'Interpreta, formula y resuelve problemas aditivos de composición, transformación y comparación en diferentes contextos; y multiplicativos, directos e inversos, en diferentes contextos.',
                        'Comprende ideas sencillas sobre temas estudiados. Comprende aspectos culturales propios de su entorno, usando vocabulario y expresiones conocidas',
                        'Comprende la secuencia de una historia corta y sencilla sobre temas familiares.', null, null, null, 
                        'Organiza la información que encuentra en los textos que lee, utilizando técnicas para el procesamiento de la información que le facilitan el proceso de compresión e interpretación textual.',
                        'Analiza la información presentada por los diferentes medios de comunicación con los cuales interactúa.',
                        'Interpreta las fracciones como razón, relación parte todo, cociente y operador en diferentes contextos.',
                        'Interpreto las fracciones en diferentes contextos: situaciones de medición, relaciones parte todo, cociente, razones y proporciones.',
                        'Intercambia opiniones sencillas sobre un tema de interés, a través de palabras.',
                        'Intercambia opiniones sencillas sobre un tema de interés en palabras sencillas.', null,
                        'Identifica la intención comunicativa de los textos con los que interactúa a partir del análisis de su contenido y estructura.',
                        'Produce textos verbales y no verbales a partir de los planes textuales que elabora según la tipología a desarrollar.',
                        'Interpreta y utiliza los números naturales y racionales en su representación fraccionaria para formular y resolver problemas aditivos, multiplicativos y que involucren operaciones de potenciación.',
                        'Justifica relaciones entre superficie y volumen, respecto a dimensiones de figuras y sólidos, y elige las unidades apropiadas según el tipo de medición (directa e indirecta), los instrumentos y los procedimientos.',
                        'Intercambia opiniones sencillas sobre un tema de interés, a través de palabras.Compara características básicas de personas,  objetos y lugares de su escuela y comunidad, a través de oraciones simples.',
                        'Intercambia información sobre hábitos, gustos y preferencias acerca de temas conocidos.', null, null, null, null, null,
                        'Produce diversos tipos de texto atendiendo a los destinatarios, al medio en que se escriba y a los propósitos comunicativos.',
                        'Comprende diversos tipos de texto, a partir del análisis de sus contenidos, características formales e intenciones comunicativas.',
                        'Interpreta los números enteros y racionales (en sus representaciones de fracción y de decimal) con sus operaciones, en diferentes contextos, al resolver problemas de variación, repartos, particiones, estimaciones, etc. Reconoce y establece diferentes relaciones (de orden y equivalencia y las utiliza para argumentar procedimientos).',
                        'Reconoce el plano cartesiano como un sistema bidimensional que permite ubicar puntos como sistema de referencia gráfico o geográfico.', 
                        '- Describe las características básicas de personas, cosas y lugares de su escuela, ciudad y comunidad, a través de frases y oraciones sencillas. -Responde a preguntas relacionadas con el “qué, quién y cuándo” después de leer o escuchar un texto corto y sencillo, siempre y cuando el tema esté relacionado con eventos que le son familiares. -Comprende el tema e información general de un texto corto y sencillo.',
                        null, null, 'Clasifico la información que circula en los medios de comunicación con los que interactúa y la retoma como referente para sus producciones discursivas. Interpreto textos informativos, expositivos, narrativos, líricos, argumentativos y descriptivos, y da cuenta de sus características formales y no formales.',
                        null, 'Utiliza escalas apropiadas para representar e interpretar planos, mapas y maquetas con diferentes unidades.', null,
                        'Reconoce información específica relacionada con objetos personas y acciones cuando le son conocidos y le hablan de manera pausada. Para esto, puede llegar a requerir de ayudas visuales tales como imágenes o texto.',
                        null, null, 'Infiere múltiples sentidos de los textos que lee y los relaciona con los conceptos macro del texto y con sus contextos de producción y circulación.',
                        'Reflexiono en forma crítica acerca de los actos comunicativos y explico los componentes del proceso de comunicación, con énfasis en los agentes, los discursos, los contextos y el funcionamiento de la lengua, en tanto sistema de signos, símbolo y reglas de uso.',
                        'Reconoce la existencia de los números irracionales como números no racionales y los describe de acuerdo con sus características y propiedades.',
                        'Describe   atributos medibles   de diferentes sólidos  y explica relaciones entre  ellos por medio del lenguaje algebraico.',
                        'Reconoce información específica en textos cortos orales sobre temas de interés general, para esto, utiliza diferentes estrategias de lectura: Pre- visualización (imágenes) de mi vida diaria.',
                        null, null, 'Incorpora símbolos de orden deportivo, cívico, político, religioso, científico o publicitario en los discursos que propone, teniendo claro su uso dentro del contexto.',
                        null, 'Utiliza los números reales (sus operaciones, relaciones y propiedades) para resolver problemas con expresiones polinómicas.',
                        'Identifica y utiliza relaciones entre el volumen y  la capacidad de algunos cuerpos redondos (cilindro,  cono y esfera) con referencia a las situaciones escolares y extraescolares.',
                        'intercambia información sobre temas del entorno escolar y de interés general en una conversación.', null, null, null, null, null, null,
                        'Determina la cantidad de objetos que conforman una colección, al establecer relaciones de correspondencia y acciones de juntar y separar.', null,
                        '1.Identifica los usos de los números (como código, cardinal, medida, ordinal) y las operaciones (suma y resta) en contextos de juego, familiares, económicos, entre otros. 2.Utiliza diferentes estrategias para contar, realizar operaciones (suma y resta ) y resolver problemas aditivos.',
                        null, '1.Interpreta, propone y resuelve problemas aditivos (de composición, transformación y relación) que involucren la cantidad en una colección, la medida de magnitudes (longitud, peso, capacidad y duración de eventos) y problemas multiplicativos sencillos. 2.Utiliza diferentes estrategias para calcular (agrupar, representar elementos en colecciones, etc.) o estimar el resultado de una suma y resta, multiplicación o reparto equitativo.',
                        null, '1.Interpreta, formula y resuelve problemas aditivos de composición, transformación y comparación en diferentes contextos; y multiplicativos, directos e inversos, en diferentes contextos. 2.Propone, desarrolla y justifica estrategias para hacer estimaciones y cálculos con operaciones. 3.Establece comparaciones entre cantidades y expresiones que involucran operaciones y relaciones aditivas y multiplicativas y sus representaciones numéricas.básicas en la solución de problemas.',
                        null, '1.Interpreta las fracciones como razón, relación parte todo, cociente y operador en diferentes contextos. 2.Describe y justifica diferentes estrategias para representar, operar y hacer estimaciones con números naturales y números racionales (fraccionarios)1, expresados como fracción o como decimal.',
                        null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 
                        'Se apropia de hábitos y prácticas para el cuidado personal y de su entorno.',
                        'Se apropia de hábitos y prácticas para el cuidado personal y de su entorno.', 
                        'Comprende que las sustancias pueden encontrarse en distintos estados (sólido, líquido y gaseoso).', null,
                        'Comprende la naturaleza (fenómeno de la vibración) y las características del sonido (altura, timbre, intensidad) y que este se propaga en distintos medios (sólidos, líquidos, gaseosos).',
                        null, null, 'Comprende que la magnitud y la dirección en que se aplica una fuerza puede producir cambios en la forma como se mueve un objeto (dirección y rapidez).',
                        null, null, 'Comprende que algunos materiales son buenos conductores de la corriente eléctrica y otros no (denominados aislantes) y que el paso de la corriente siempre genera calor.',
                        null, null, 'Comprende cómo los cuerpos pueden ser cargados eléctricamente asociando esta carga a efectos de atracción y repulsión.', null, null,
                        'Explica cómo las sustancias se forman a partir de la interacción de los elementos y que estos se encuentran agrupados en un sistema periódico.', null, 
                        null, 'Comprende el funcionamiento de máquinas térmicas (motores de combustión, refrigeración) por medio de las leyes de la termodinámica (primera y segunda ley).',
                        null, null, 'Comprende la forma en que los principios genéticos mendelianos y post-mendelianos explican la herencia y el mejoramiento de las especies existentes.',
                        null, null, 'Describe las características del paisaje geográfico del barrio, vereda o lugar donde vive, sus componentes y formas.',
                        'Describe las características del paisaje geográfico del barrio, vereda o lugar donde vive, sus componentes y formas.',
                        'Comprende que el paisaje que vemos es resultado de las acciones humanas que se realizan en un espacio geográfico y que por esta razón, dicho paisaje cambia.',
                        null, 'Comprende el legado de los grupos humanos en la gastronomía, la música y el paisaje de la región, municipio, resguardo o lugar donde vive.', null,
                        null, 'Comprende la importancia de la división de poderes en una democracia y la forma como funciona en Colombia.', null, null,
                        'Identifico y describo algunas de las características humanas (sociales, culturales…) de las diferentes regiones naturales del mundo.', null, null,
                        'Comprende que existen diversas explicaciones y teorías sobre el origen del universo en nuestra búsqueda por entender que hacemos parte de un mundo más amplio.',
                        'Analiza cómo en las sociedades antiguas surgieron las primeras ciudades y el papel de la agricultura y el comercio para la expansión de estas.',
                        'Analiza los legados que las sociedades americanas prehispánicas dejaron en diversos campos.', 
                        'Comprende que las representaciones del mundo han cambiado a partir de las visiones de quienes las elaboran y de los avances de la tecnología.',
                        'Analiza la influencia del imperio romano en la cultura de occidente y los aportes en diversos campos como la literatura, las leyes, la ingeniería y la vida cotidiana.',
                        'Analiza el Renacimiento como una época que dio paso en Europa a una nueva configuración cultural en campos como las ciencias, la política, las artes y la literatura.',
                        null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null,
                        null, null, null, null, null, null, 'Comprendo que mis acciones pueden afectar a la gente cercana y que las acciones de la gente cercana pueden afectarme a mí.',
                        'Comprendo que mis acciones pueden afectar a la gente cercana y que las acciones de la gente cercana pueden afectarme a mí.',
                        'Hago cosas que ayuden a aliviar el malestar de personas cercanas; manifiesto satisfacción al preocuparme por sus necesidades.',
                        'Desarrollo compromisos personales y sociales en los contextos en que me desenvuelvo.',
                        'Comprendo que mis acciones pueden afectar a la gente cercana y que las acciones de la gente cercana pueden afectarme a mí.',
                        'Desarrollo compromisos personales y sociales en los contextos en que me desenvuelvo.',
                        'Comprendo que mis acciones pueden afectar a la gente cercana y que las acciones de la gente cercana pueden afectarme a mí.',
                        'Participo, en mi contexto cercano (con mi familia y compañeros), en la construcción de acuerdos básicos sobre normas para el logro de metas comunes y las cumplo.',
                        'Desarrollo compromisos personales y sociales en los contextos en que me desenvuelvo.',
                        'Participo, en mi contexto cercano (con mi familia y compañeros), en la construcción de acuerdos básicos sobre normas para el logro de metas comunes y las cumplo.',
                        'Participo, en mi contexto cercano (con mi familia y compañeros), en la construcción de acuerdos básicos sobre normas para el logro de metas comunes y las cumplo.'];
        
        for ($i=1; $i <= 204 ; $i++) { 
            $index = $i - 1;
            if (isset($subjects_id_array[$index]) && $subjects_id_array[$index] != null) {
                $new_subject_mini_game = new SubjectMiniGame();
                $new_subject_mini_game->mini_game_id = $i;
                $new_subject_mini_game->subject_id = $subjects_id_array[$index];
                $new_subject_mini_game->dba = $dbas_array[$index];
                $new_subject_mini_game->save();
            }
        }
    }
}
