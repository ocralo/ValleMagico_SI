import React from "react";
import ReactDOM from "react-dom";
import ListSearch from "../../Organisms/listSearch/listSearch";

class IntroPage extends React.Component {
    render() {
        return (
            <div className="content-Intro d-flex flex-column col-md-12 justify-content-center align-items-center hidden-sm hidden-xs text-justify">
                <div>
                    <div className="d-flex justify-content-center">
                        <div className="col-md-4 d-flex justify-content-center">
                            <img
                                src={`${__webpack_public_path__}img/logo.png`}
                                className="img-fluid"
                                alt="Responsive image"
                            />
                        </div>
                    </div>

                    <div className="title-introPage d-flex col-md-12 justify-content-center ">
                        Introducción
                    </div>
                    <div className="d-flex justify-content-center col-md-12">
                        <div className="descript-introPage col-md-10">
                            <div>
                                En este portal encontrará un sistema de
                                información que brinda datos puntuales
                                relacionados con el desempeño de los estudiantes
                                por competencias y áreas valoradas en los
                                diferentes mini juegos de Valle Mágico.
                            </div>
                            <div>
                                La estructura de los resultados se encuentra
                                organizada por Departamento, Municipio,
                                Institución Educativa, Grados, Aulas y
                                Estudiantes, aportando recomendaciones que le
                                facilitarán a los actores educativos, el diseño
                                e implementación de acciones pertinentes en
                                cuanto a estrategias metodológicas en el aula,
                                ajustes en contenidos, logros y fortalecimiento
                                en herramientas como el PIAR, PMI,
                                Autoevaluación, entre otros.
                            </div>
                            <div>
                                Para consultar la información relacionada con el
                                desempeño de los estudiantes por competencias
                                y/o áreas, seleccione el link Departamento,
                                Municipio, Institución Educativa, Grado, Aula o
                                Estudiante que se encuentra en el menú del
                                sitio, de acuerdo a la información requerida.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default IntroPage;
