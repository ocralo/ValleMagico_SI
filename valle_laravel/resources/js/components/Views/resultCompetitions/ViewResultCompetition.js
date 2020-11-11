import React, { useState, useEffect } from "react";
import { fetchApi } from "../../../function/GlobalFunctions";
import LoadingPage from "../loadingPage/loadingPage";
import TittleTab from "../../Atoms/tittleTab";
import CardCompetitions from "../../Organisms/cardCompetitions/cardCompetitions";
import CardHierarchy from "../../Organisms/cardHierarchy/cardHierarchy";


function ViewResultCompetition({
    urlToFetchCompetitionIntelligences,
    urlTOFetchCompetitionStyles,
    nameItemClicked,
    titleChild,
    dataChild,
    url
}) {
    const [isLoaded, setisLoaded] = useState(true);
    const [error, setError] = useState(null);

    const [
        intelligenceForCompentition,
        setIntelligenceForCompentition
    ] = useState({
        1: { message: "No se tienen datos" },
        2: { message: "No se tienen datos" },
        3: { message: "No se tienen datos" }
    });
    const [styleForCompentition, setStyleForCompentition] = useState({
        1: { message: "No se tienen datos" },
        2: { message: "No se tienen datos" },
        3: { message: "No se tienen datos" }
    });

    async function fetchData() {
        setisLoaded(true);
        try {
            const intelligence = await fetchApi(
                urlToFetchCompetitionIntelligences
            );
            getIntelligences(intelligence);

            const styles = await fetchApi(urlTOFetchCompetitionStyles);
            getStyles(styles);

            setisLoaded(false);
        } catch (error) {
            console.warn(error);
            setisLoaded(true);
            setError(error);
        }
    }

    function getIntelligences(intelligence) {
        if (intelligence.message === undefined) {
            setIntelligenceForCompentition(intelligence);
        } else {
        }
    }

    function getStyles(styles) {
        if (styles.message === undefined) {
            setStyleForCompentition(styles);
        } else {
        }
    }

    useEffect(() => {
        fetchData();
    }, [urlToFetchCompetitionIntelligences, urlTOFetchCompetitionStyles]);
t
    if (isLoaded) {
        return <LoadingPage />;
    } else {
        return (
            <div className="col-12">
                <TittleTab
                    tittle={"Resultados por competencia"}
                    nameItemClicked={nameItemClicked}
                />
                <CardCompetitions
                    title={"Lectura Crítica"}
                    titleGraph1={"Inteligencias Múltiples"}
                    dataForGraph1={intelligenceForCompentition[1]}
                    titleGraph2={"Estilos de aprendizaje"}
                    dataForGraph2={styleForCompentition[1]}
                />
                <CardCompetitions
                    title={"Razonamiento Cuantitativo"}
                    titleGraph1={"Inteligencias Múltiples"}
                    dataForGraph1={intelligenceForCompentition[2]}
                    titleGraph2={"Estilos de aprendizaje"}
                    dataForGraph2={styleForCompentition[2]}
                />
                <CardCompetitions
                    title={"Comunicación Escrita"}
                    titleGraph1={"Inteligencias Múltiples"}
                    dataForGraph1={intelligenceForCompentition[3]}
                    titleGraph2={"Estilos de aprendizaje"}
                    dataForGraph2={styleForCompentition[2]}
                />
                {
                    titleChild !== null ? <CardHierarchy
                    title={titleChild}
                    data={dataChild}
                    url={url}
                /> : null
                }
            </div>
        );
    }
}

export default ViewResultCompetition;
