import React, { useEffect, useState, createRef, useContext } from "react";
import {
    EntityContext,
    EntityTypeContext,
    EntityGraphContext
} from "../Views/_/_context/_context";

import { fetchApi } from "../../function/GlobalFunctions";

import { fetchPOST, download } from "../../function/GlobalFunctions";

import { ApiLevel, StringLevel } from "../Views/_/_constants/_constants";

const _buttonGenerateInform = ({ currentView }) => {
    const { currentEntity } = useContext(EntityContext);
    const { entityType, setEntityType } = useContext(EntityTypeContext);
    const { graphs } = useContext(EntityGraphContext);

    const [gettingPDF, setGettingPDF] = useState(false);
    const [gettingPDFVocationals, setGettingPDFVocationals] = useState(false);

    const [textButton, setTextButton] = useState("");

    useEffect(() => {
        if (currentView == "0") {
            setTextButton("Asignaturas");
        } else if (currentView == "1") {
            setTextButton("Inteligencias Multiples");
        } else if (currentView == "2") {
            setTextButton("Estilos Aprendizaje");
        }
    }, [currentView]);

    const getExcel = () => {
        window.open(`${ApiLevel[entityType].excel}/${currentEntity.id}`);
    };

    async function getPDF(vocational = false) {
        let fields = {
            locationType: entityType,
            id: currentEntity.id,
            name: currentEntity.name,
            graph: graphs[0]
        };

        try {
            let uri = "";
            if (vocational) {
                uri = ApiLevel.pdfVocations;
                setGettingPDFVocationals(true);
            } else if (currentView == "0") {
                uri = ApiLevel.pdfKnowledgeAreas;
                setGettingPDF(true);
            } else if (currentView == "1") {
                uri = ApiLevel.pdfintelligences;
                setGettingPDF(true);
            } else if (currentView == "2") {
                uri = ApiLevel.pdfStyles;
                setGettingPDF(true);
            }

            const result = await download(
                uri,
                fields,
                "POST",
                "Reporte valle magico.pdf"
            );
            if (result === undefined) {
                setGettingPDF(false);
                setGettingPDFVocationals(false);
            }
        } catch (error) {
            console.warn(error);
        }
    }

    return (
        <React.Fragment>
            {graphs[0] && currentView != "3" && currentView != "4" && (
                <button
                    type="button"
                    className="float d-flex justify-content-center align-items-center"
                    data-toggle="modal"
                    data-target="#myModal"
                >
                    <img
                        src={__webpack_public_path__ + "img/icon-print.svg"}
                        className="icon-imprimir"
                        alt="imprimir"
                    />
                </button>
            )}
            {/*Modal*/}
            <div className="modal fade" id="myModal" role="dialog">
                <div className="modal-dialog">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">
                                Informe {textButton}
                            </h4>
                            <button
                                type="button"
                                className="close"
                                data-dismiss="modal"
                            >
                                &times;
                            </button>
                        </div>
                        <div className="modal-body border-0">
                            {currentView == "0" && (
                                <button
                                    type="button"
                                    className="btn btn-secondary btn-lg btn-block"
                                    onClick={getExcel}
                                >
                                    <span className="mr-4">Descargar CSV</span>
                                    <img
                                        src={
                                            __webpack_public_path__ +
                                            "img/icon-print.svg"
                                        }
                                        className="icon-imprimir"
                                        alt="imprimir"
                                    />
                                </button>
                            )}
                            <button
                                type="button"
                                className="btn btn-secondary btn-lg btn-block"
                                onClick={() => {
                                    getPDF();
                                }}
                            >
                                <span className="mr-4">
                                    Descargar PDF {textButton}
                                </span>
                                <img
                                    src={
                                        __webpack_public_path__ +
                                        "img/icon-print.svg"
                                    }
                                    className="icon-imprimir"
                                    alt="imprimir"
                                />
                                {gettingPDF && (
                                    <div
                                        className="spinner-border ml-4"
                                        role="status"
                                    >
                                        <span className="sr-only">
                                            Loading...
                                        </span>
                                    </div>
                                )}
                            </button>
                            <button
                                type="button"
                                className="btn btn-secondary btn-lg btn-block"
                                onClick={() => {
                                    getPDF(true);
                                }}
                            >
                                <span className="mr-4">
                                    Descargar PDF Orientación Vocacional
                                </span>
                                <img
                                    src={
                                        __webpack_public_path__ +
                                        "img/icon-print.svg"
                                    }
                                    className="icon-imprimir"
                                    alt="imprimir"
                                />
                                {gettingPDFVocationals && (
                                    <div
                                        className="spinner-border ml-4"
                                        role="status"
                                    >
                                        <span className="sr-only">
                                            Loading...
                                        </span>
                                    </div>
                                )}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
};

export default _buttonGenerateInform;
