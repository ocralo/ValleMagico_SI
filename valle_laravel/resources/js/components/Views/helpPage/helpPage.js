import React from "react";
import ReactDOM from "react-dom";

class HelpPage extends React.Component {
    render() {
        return (
            <React.Fragment>
                <div className="text-faq text-center my-3">
                    Preguntas frecuentes
                </div>
                <div className="row justify-content-center pb-5">
                    <div id="accordion" className="col-md-8">
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn"
                                data-toggle="collapse"
                                data-target="#collapseOne"
                                aria-expanded="true"
                                aria-controls="collapseOne"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingOne"
                                >
                                    <h5 className="mb-0">
                                        ¿A quién dirigirse si presenta problemas
                                        con el ingreso del login?
                                    </h5>
                                </div>
                            </button>

                            <div
                                id="collapseOne"
                                className="collapse show"
                                aria-labelledby="headingOne"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    Si presenta problema para recordar su
                                    contraseña e ingresar al sistema de
                                    información de Valle magico, por favor,
                                    enviar un correo a vallemagico@gmail.com
                                    con el asunto "Olvidé mi contraseña", con la
                                    siguiente información: Nombre completo,
                                    Nombre de usuario y Última contraseña que
                                    recuerde. En caso de no recordar su nombre
                                    de usuario por favor adjuntar la(s)
                                    institución(es) , sede(s), grado(s) a la(s)
                                    cual(es) le fue otorgado acceso
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseTwo"
                                aria-expanded="false"
                                aria-controls="collapseTwo"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingTwo"
                                >
                                    <h5 className="mb-0">
                                        ¿Cómo consultar los datos estadísticos?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseTwo"
                                className="collapse"
                                aria-labelledby="headingTwo"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    Para consultar datos estadísticos, debe
                                    dirigirse a cualquier ruta de la barra de
                                    navegación: Departamento, Municipio,
                                    Institución, sede, grupo o estudiante,
                                    seleccionar el nombre de la localidad que
                                    desea consultar su datos y por último
                                    ingresar a alguna de las siguientes
                                    pestañas: resultados por asignatura,
                                    inteligencias múltiples, estilos de
                                    aprendizaje o resultados por competencias.
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseThree"
                                aria-expanded="false"
                                aria-controls="collapseThree"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingThree"
                                >
                                    <h5 className="mb-0">
                                        ¿Cómo generar un informe?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseThree"
                                className="collapse"
                                aria-labelledby="headingThree"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    Para generar un informe, debe dirigirse a
                                    cualquier ruta de la barra de navegación:
                                    departamento, municipio, institución, sede,
                                    grupo o estudiante, seleccionar el nombre de
                                    la localidad/estudiante que desea consultar,
                                    y a continuación presionar el botón inferior
                                    derecho de la pantalla. Una vez realizado
                                    esto se le presentará una vista previa de la
                                    información generada. Luego, seleccione el
                                    tipo de informe que desee imprimir y
                                    posteriormente seleccione la opción en la
                                    parte superior derecha para imprimir el
                                    informe o guardar como pdf.
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseFour"
                                aria-expanded="false"
                                aria-controls="collapseFour"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingFour"
                                >
                                    <h5 className="mb-0">
                                        ¿Por qué no me aparecen todas las
                                        opciones en el menú?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseFour"
                                className="collapse"
                                aria-labelledby="headingFour"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    El sistema de información posee una
                                    validación de interfaz por roles y permisos,
                                    por tanto las opciones estarán limitadas al
                                    tipo de usuario que le fue asignado, si se
                                    presenta alguna inconsistencia, enviar un
                                    email a vallemagico.soporte@gmail.com con el asunto
                                    "Inconsistencia Permisos": con la siguiente
                                    información: Nombre completo, Nombre de
                                    usuario, institución(es), sede(s), grado(s)
                                    a la(s) cual(es) le fue otorgado acceso y su
                                    rol/cargo dentro de estas.
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseFive"
                                aria-expanded="false"
                                aria-controls="collapseFive"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingFive"
                                >
                                    <h5 className="mb-0">
                                        ¿Debo tener un rol diferente para ver
                                        información de múltiples localidades?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseFive"
                                className="collapse"
                                aria-labelledby="headingFive"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    No, los roles sólo limitan las
                                    funcionalidades de la interfaz, pero un
                                    mismo usuario puede tener acceso a múltiples
                                    localidades (Departamentos, Municipios,
                                    Sedes, Instituciones, Grupos).
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseSix"
                                aria-expanded="false"
                                aria-controls="collapseSix"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingSix"
                                >
                                    <h5 className="mb-0">
                                        ¿Cómo funcionan las Recomendaciones?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseSix"
                                className="collapse"
                                aria-labelledby="headingSix"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    Las recomendaciones del sistema de
                                    información varían según el nivel de
                                    jerarquía de datos seleccionado, las
                                    asignaturas, el grado de los estudiantes y
                                    el desempeño promedio obtenido por los
                                    mismos, brindando así una retroalimentación
                                    personalizada. Además podrá conocer los DBAs
                                    que deberán ser reforzados.
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseSeven"
                                aria-expanded="false"
                                aria-controls="collapseSeven"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingSeven"
                                >
                                    <h5 className="mb-0">
                                        ¿Cómo funcionan los niveles de
                                        segmentación jerárquica de datos?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseSeven"
                                className="collapse"
                                aria-labelledby="headingSeven"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    Los niveles de segmentación jerárquica hacen
                                    referencia a la cantidad de niveles de
                                    especificidad/generalización de
                                    estadísticas, siendo estos: Departamento,
                                    Municipio, Institución, Sede, Grupo y
                                    finalmente Estudiante.
                                </div>
                            </div>
                        </div>
                        <div className="card-faq card shadow">
                            <button
                                className="btn-faq btn collapsed w-100"
                                data-toggle="collapse"
                                data-target="#collapseEight"
                                aria-expanded="false"
                                aria-controls="collapseEight"
                            >
                                <div
                                    className="card-faq-header card-header"
                                    id="headingEight"
                                >
                                    <h5 className="mb-0">
                                        ¿Cómo encontrar una
                                        localidad/estudiante?
                                    </h5>
                                </div>
                            </button>
                            <div
                                id="collapseEight"
                                className="collapse"
                                aria-labelledby="headingEight"
                                data-parent="#accordion"
                            >
                                <div className="card-body text-justify mx-3">
                                    Para encontrar una localidad debe dirigirse
                                    a cualquier ruta de la barra de navegación:
                                    departamento, municipio, institución, sede,
                                    grupo o estudiante en dónde podrá buscar
                                    dentro de la lista de
                                    localidades/estudiantes a los cuales usted
                                    tiene acceso. Para facilitar este proceso
                                    puede utilizar la barra de búsqueda y
                                    digitar cualquier parte del nombre de la
                                    localidad/estudiante que desea consultar.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    }
}

export default HelpPage;
