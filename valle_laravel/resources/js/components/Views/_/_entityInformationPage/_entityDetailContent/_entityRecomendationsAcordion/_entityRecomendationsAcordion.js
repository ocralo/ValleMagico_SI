import React, { useEffect } from "react";
import { object } from "yup";
import _EntityRecomendations from "./_entityRecomendations/_entityRecomendations";

export default function _entityRecomendationsAcordion({ data }) {
    const InformationmultipleIntelligences = [
        {
            title: "lógico-matemática",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través de puzles mentales, adivinanzas numéricas, juegos de seriación mental u operativa o monitorias sobre temas vistos en clase, profundización en temas específicos o misterios matemáticos y exposición de saberes ante sus compañeros, participación en clubes matemáticos y vinculación a programas externos o internos como intercolegiados o concursos."
        },
        {
            title: "lingüística-verbal",
            recomendation:
                "El maestro podrá potenciar su inteligencia lingüística (en lengua materna y segundas lenguas) a través de invitaciones a debates, tareas de creatividad verbal, solicitudes especiales en tareas de oratoria (dar la bienvenida, palabras en alguna situación especial, lectura de programas, presentación de eventos), pedirle que escriba textos, poemas o guiones para teatro, vinculación en actividades externas o internas como concursos u olimpiadas lingüísticas, entre otras."
        },
        {
            title: "visual-espacial",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través de peticiones especiales sobre realización de murales o gráficos sobre algún tema específico, ayuda en la remodelación u organización del salón, combinación de colores, tareas de creatividad visual, realización de maquetas o arquetipos, proyectos y exposiciones de arte, indagación sobre artistas visuales, eventos de fotografía, etc."
        },
        {
            title: "kinestésica - corporal",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través de juegos teatrales, tareas de creatividad motora, yincanas, competencias deportivas, programas de teatro, danza o juego, hacer solicitudes especiales para organizar sociodramas, presentaciones artísticas, muestras de capacidades físicas, vinculación a eventos internos y externos como concursos, competencias, etc."
        },
        {
            title: "musical",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través de juegos musicales, crear canciones con temáticas de la clase, destacar su talento en presentaciones escolares o concursos externos, así como a nivel personal, solicitarle tareas musicales para abrir las clases o tener un momento de distensión en el salón, vinculación a programas internos o externos de potenciación o competición musical, entre otros."
        },
        {
            title: "interpersonal",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través de peticiones especiales sobre estrategias para generar empatía en el salón, vinculación a programas de ayuda emocional entre pares, campañas de liderazgo social, eliminación de violencias escolares, solicitar que busque experiencias o lecturas y las comparta con su grupo o en la emisora escolar, si hay un periódico o mural, pedirle que escriba alguna nota de reflexión sobre la convivencia, vincularlo a programas externos de liderazgo social, etc."
        },
        {
            title: "intrapersonal",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través del trabajo sobre reflexión e introspección, llevar al salón temas sobre autoestima, respeto propio, resiliencia; invitarlo a compartir sus reflexiones, pedirle que guíe ejercicios de meditación o respiración, crear estrategias para apoyar a sus demás compañeros, ofrecer lecturas sobre el tema de interés, pedir que lea libros específicos o crear espacios escolares para conversar sobre estos temas, conocer culturas donde se practique la introspección como las indígenas y las orientales."
        },
        {
            title: "naturalista",
            recomendation:
                "El maestro podrá potenciar su inteligencia a través de vinculación a proyectos científicos internos y externos, semanas de la ciencia, proyectos para crear, cuidar o mejorar los laboratorios escolares, solicitarle monitorias a estudiantes menos avanzados o interesados en el tema, pedirle que profundice en algunos temas o misterios científicos y los exponga en el salón, involucrar al estudiante en actividades internas o externas como olimpiadas, programas interinstitucionales, etc."
        }
    ];
    const grades = value =>
        value.map((value2, index) => {
            return (
                <div className="mb-4" key={`grad-${index}`}>
                    <h1 className="my-2">
                        <b>Grado: </b>
                        {value2[0].grade.toUpperCase()}
                    </h1>
                    {value2.map((value3, j) => {
                        return (
                            <div className="mb-2" key={`recomendation-${j}`}>
                                <_EntityRecomendations
                                    type="Rendimiento"
                                    performance={value3.performance}
                                    name={value3.subject}
                                    recomendation={value3.recomendation}
                                />
                            </div>
                        );
                    })}
                    <hr />
                </div>
            );
        });

    const IntelligenceRecomendation = value =>
        value.map((value2, i) => {
            const dataRecomendation = InformationmultipleIntelligences.find(
                recomendation =>
                    recomendation.title.toUpperCase() ===
                    value2.name.toUpperCase()
            ).recomendation;
            return (
                <_EntityRecomendations
                    key={`recomendation2-${i}`}
                    type="Puntaje"
                    performance={value2.average}
                    name={value2.name}
                    recomendation={dataRecomendation}
                />
            );
        });

    return (
        <>
            <ul className="nav nav-tabs" id="myTab" role="tablist">
                <li className="nav-item">
                    <a
                        className="nav-link active text-body"
                        id="home-tab"
                        data-toggle="tab"
                        href="#home"
                        role="tab"
                        aria-controls="home"
                        aria-selected="true"
                    >
                        Asignaturas
                    </a>
                </li>
                <li className="nav-item">
                    <a
                        className="nav-link text-body"
                        id="profile-tab"
                        data-toggle="tab"
                        href="#profile"
                        role="tab"
                        aria-controls="profile"
                        aria-selected="false"
                    >
                        Inteligencias múltiples, estilos de aprendizaje y
                        orientación vocacional
                    </a>
                </li>
            </ul>
            <div
                className="tab-content border border-top-0 px-4"
                id="myTabContent"
            >
                {Object.entries(data).map(([key, value]) => {
                    if (key === "recomendations") {
                        return (
                            <div
                                className="tab-pane fade show active text-body"
                                id="home"
                                role="tabpanel"
                                aria-labelledby="home-tab"
                                key={`Grade-${key}`}
                            >
                                <div className="p-3">
                                    {typeof value === "object"
                                        ? grades(
                                              Object.values(value).map(
                                                  val => val
                                              )
                                          )
                                        : ""}
                                </div>
                            </div>
                        );
                    } else if (key === "intelligences") {
                        return (
                            <div
                                className="tab-pane fade text-body"
                                id="profile"
                                role="tabpanel"
                                aria-labelledby="profile-tab"
                                key={`Grade-${key}`}
                            >
                                <div className="p-3">
                                    {typeof value === "object"
                                        ? IntelligenceRecomendation(
                                              Object.values(value).map(
                                                  value => value
                                              )
                                          )
                                        : ""}
                                </div>
                            </div>
                        );
                    }
                })}
                {/* data.map((value, i) => {
                    if (i == 0) {
                        return (
                            <div
                                className="tab-pane fade show active text-body"
                                id="home"
                                role="tabpanel"
                                aria-labelledby="home-tab"
                                key={`Grade-${i}`}
                            >
                                <div className="p-3">
                                    {Array.isArray(value) ? grades(value) : ""}
                                </div>
                            </div>
                        );
                    } else if (i == 1) {
                        return (
                            <div
                                className="tab-pane fade text-body"
                                id="profile"
                                role="tabpanel"
                                aria-labelledby="profile-tab"
                                key={`Grade-${i}`}
                            >
                                <div className="p-3">
                                    {Array.isArray(value)
                                        ? IntelligenceRecomendation(value)
                                        : ""}
                                </div>
                            </div>
                        );
                    }
                }) */}
            </div>
            {/*
                <div className="accordion" id="accordionExample">
                    {data.map((value, i) => {
                        if (i == 0) {
                            return (
                                <div className="card p-0" key={`recs-${i}`}>
                                    <div
                                        className="card-header"
                                        id="headingOne"
                                    >
                                        <h2 className="mb-0">
                                            <button
                                                className="btn btn-link w-100"
                                                type="button"
                                                data-toggle="collapse"
                                                data-target="#collapseOne"
                                                aria-expanded="true"
                                                aria-controls="collapseOne"
                                            >
                                                Recomendaciones por Asignatura
                                            </button>
                                        </h2>
                                    </div>
                                    <div
                                        id="collapseOne"
                                        className="collapse show"
                                        aria-labelledby="headingOne"
                                        data-parent="#accordionExample"
                                    >
                                        <div className="card-body">
                                            <div className="container">
                                                <div className="row">
                                                    <div className="col-md-12">
                                                        {Array.isArray(value)
                                                            ? grades(value)
                                                            : ""}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            );
                        } else if (i == 1) {
                            return (
                                <div className="card p-0" key={`recs-${i}`}>
                                    <div
                                        className="card-header"
                                        id="headingTwo"
                                    >
                                        <h2 className="mb-0">
                                            <button
                                                className="btn btn-link w-100"
                                                type="button"
                                                data-toggle="collapse"
                                                data-target="#collapseTwo"
                                                aria-expanded="true"
                                                aria-controls="collapseTwo"
                                            >
                                                Recomendaciones para
                                                Inteligencias múltiples
                                            </button>
                                        </h2>
                                    </div>

                                    <div
                                        id="collapseTwo"
                                        className="collapse"
                                        aria-labelledby="headingTwo"
                                        data-parent="#accordionExample"
                                    >
                                        <div className="card-body p-4">
                                            {Array.isArray(value)
                                                ? IntelligenceRecomendation(
                                                      value
                                                  )
                                                : ""}
                                        </div>
                                    </div>
                                </div>
                            );
                        }
                    })}
                </div>
             */}
        </>
    );
}
