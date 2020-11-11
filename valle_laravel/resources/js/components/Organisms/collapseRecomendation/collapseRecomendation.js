import React, { useState, useEffect } from 'react'
import CardRecomendation from '../../Molecules/cardRecomendation'

const CollapseRecomendation = ({ dataIntelligence, dataSubjects }) => {

    const [maxDataIntelligences, setmaxDataIntelligences] = useState([])

    //  Selected three hi
    useEffect(() => {
        let dataSort = dataIntelligence.sort(function (a, b) {
            if (a.average < b.average) {
                return 1;
            }
            if (a.average > b.average) {
                return -1;
            }
            // a must be equal to b
            return 0;
        });
        setmaxDataIntelligences(dataSort.slice(0,3))
    }, [dataIntelligence])

    const InformationmultipleIntelligences = [
        {
            title: 'lógico-matemática',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de puzles mentales, adivinanzas numéricas, juegos de seriación mental u operativa o monitorias sobre temas vistos en clase, profundización en temas específicos o misterios matemáticos y exposición de saberes ante sus compañeros, participación en clubes matemáticos y vinculación a programas externos o internos como intercolegiados o concursos.'
        },
        {
            title: 'lingüística-verbal',
            recomendation: 'El maestro podrá potenciar su inteligencia lingüística (en lengua materna y segundas lenguas) a través de invitaciones a debates, tareas de creatividad verbal, solicitudes especiales en tareas de oratoria (dar la bienvenida, palabras en alguna situación especial, lectura de programas, presentación de eventos), pedirle que escriba textos, poemas o guiones para teatro, vinculación en actividades externas o internas como concursos u olimpiadas lingüísticas, entre otras.'
        },
        {
            title: 'visual-espacial',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de peticiones especiales sobre realización de murales o gráficos sobre algún tema específico, ayuda en la remodelación u organización del salón, combinación de colores, tareas de creatividad visual, realización de maquetas o arquetipos, proyectos y exposiciones de arte, indagación sobre artistas visuales, eventos de fotografía, etc.'
        },
        {
            title: 'kinestésica - corporal',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de juegos teatrales, tareas de creatividad motora, yincanas, competencias deportivas, programas de teatro, danza o juego, hacer solicitudes especiales para organizar sociodramas, presentaciones artísticas, muestras de capacidades físicas, vinculación a eventos internos y externos como concursos, competencias, etc.'
        },
        {
            title: 'musical',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de juegos musicales, crear canciones con temáticas de la clase, destacar su talento en presentaciones escolares o concursos externos, así como a nivel personal, solicitarle tareas musicales para abrir las clases o tener un momento de distensión en el salón, vinculación a programas internos o externos de potenciación o competición musical, entre otros.'
        },
        {
            title: 'interpersonal',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de peticiones especiales sobre estrategias para generar empatía en el salón, vinculación a programas de ayuda emocional entre pares, campañas de liderazgo social, eliminación de violencias escolares, solicitar que busque experiencias o lecturas y las comparta con su grupo o en la emisora escolar, si hay un periódico o mural, pedirle que escriba alguna nota de reflexión sobre la convivencia, vincularlo a programas externos de liderazgo social, etc.'
        },
        {
            title: 'intrapersonal',
            recomendation: 'El maestro podrá potenciar su inteligencia a través del trabajo sobre reflexión e introspección, llevar al salón temas sobre autoestima, respeto propio, resiliencia; invitarlo a compartir sus reflexiones, pedirle que guíe ejercicios de meditación o respiración, crear estrategias para apoyar a sus demás compañeros, ofrecer lecturas sobre el tema de interés, pedir que lea libros específicos o crear espacios escolares para conversar sobre estos temas, conocer culturas donde se practique la introspección como las indígenas y las orientales.'
        },
        {
            title: 'naturalista',
            recomendation: 'El maestro podrá potenciar su inteligencia a través de vinculación a proyectos científicos internos y externos, semanas de la ciencia, proyectos para crear, cuidar o mejorar los laboratorios escolares, solicitarle monitorias a estudiantes menos avanzados o interesados en el tema, pedirle que profundice en algunos temas o misterios científicos y los exponga en el salón, involucrar al estudiante en actividades internas o externas como olimpiadas, programas interinstitucionales, etc.'
        }

    ]

    return (
        <div className='col-12 d-flex justify-content-center'>
            <div id="accordion" className='col-md-8'>
                <CardRecomendation
                    dataInfo={dataSubjects}
                    expander={true}
                    idCard='collapseOne'
                    idHeader='headingOne'
                    show={'show'}
                    isSubject={true}
                    title="Recomendaciones por Asignatura"
                    infoRecomendation={InformationmultipleIntelligences}
                />

                <CardRecomendation
                    dataInfo={maxDataIntelligences}
                    expander={false}
                    isSubject={false}
                    idCard='collapseTwo'
                    idHeader='headingTwo'
                    show={''}
                    title="Recomendaciones para Inteligencias múltiples"
                    infoRecomendation={InformationmultipleIntelligences}
                />
            </div>
        </div>
    )
}

export default CollapseRecomendation