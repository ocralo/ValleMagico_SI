import React from "react";
const _EntityDetailMenu = ({ setCurrentView, currentView }) => {
    /* return(
        <div className="nav justify-content-around mt-2 mb-4">
            <div className="nav-item" onClick={()=>setCurrentView(0)}>{'Resultados Por Asignatura'}</div>
            <div className="nav-item" onClick={()=>setCurrentView(1)}>{'Inteligencias Multiples'}</div>
            <div className="nav-item" onClick={()=>setCurrentView(2)}>{'Estilos de Aprendizaje'}</div>
            <div className="nav-item" onClick={()=>setCurrentView(3)}>{'Resultados por Competencias'}</div>
            <div className="nav-item" onClick={()=>setCurrentView(4)}>{'Recomendaciones'}</div>
        </div>
    ) */
    return (
        <div className="list-tabs d-lg-flex justify-content-around row pt-3">
            <div
                className={
                    currentView === 0
                        ? "tabs-selected tab-selec-active"
                        : "tabs-selected desactivate-nav"
                }
                onClick={() => setCurrentView(0)}
            >
                {"Resultados Por Asignatura"}
            </div>
            <div
                className={
                    currentView === 1
                        ? "tabs-selected tab-selec-active"
                        : "tabs-selected desactivate-nav"
                }
                onClick={() => setCurrentView(1)}
            >
                {"Inteligencias Multiples"}
            </div>
            <div
                className={
                    currentView === 2
                        ? "tabs-selected tab-selec-active"
                        : "tabs-selected desactivate-nav"
                }
                onClick={() => setCurrentView(2)}
            >
                {"Estilos de Aprendizaje"}
            </div>
            <div
                className={
                    currentView === 3
                        ? "tabs-selected tab-selec-active"
                        : "tabs-selected desactivate-nav"
                }
                onClick={() => setCurrentView(3)}
            >
                {"Resultados por Competencias"}
            </div>
            <div
                className={
                    currentView === 4
                        ? "tabs-selected tab-selec-active"
                        : "tabs-selected desactivate-nav"
                }
                onClick={() => setCurrentView(4)}
            >
                {"Recomendaciones"}
            </div>
        </div>
    );
};

export default _EntityDetailMenu;
