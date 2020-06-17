import React, { useState, useEffect } from "react";
import LoadingPage from "../loadingPage/loadingPage";
import TittleTab from "../../Atoms/tittleTab";
import CollapseRecomendation from "../../Organisms/collapseRecomendation/collapseRecomendation";
import { fetchApi } from "../../../function/GlobalFunctions";

function ViewRecomendations({
    urlToFetchInfoRecomendationSubject,
    urlToFetchInfoRecomendationIntelligence,
    nameItemClicked
}) {
    const [dataSubjects, setdataSubjects] = useState([]);
    const [dataIntelligence, setdataIntelligence] = useState([]);

    const [isLoaded, setisLoaded] = useState(true);
    const [error, seterror] = useState(null);

    useEffect(() => {
        fetchData();
    }, [
        urlToFetchInfoRecomendationSubject,
        urlToFetchInfoRecomendationIntelligence
    ]);

    function fetchData() {
        setisLoaded(true);
        try {
            console.log("Hola voy a ejecutar fetch Subject");
            FetchSubject();
            console.log("Hola voy a ejecutar fetch Intelilligences");
            FetchIntelligences();
        } catch (error) {
            setisLoaded(true);
            seterror(error);
        }
    }

    async function FetchSubject() {
        let subject = await fetchApi(urlToFetchInfoRecomendationSubject);

        if (
            (subject.length > 0 && Array.isArray(subject)) ||
            (!Array.isArray(subject) && subject.message == undefined)
        ) {
            Object.keys(subject).map(i => {
                let grade = {
                    name: `Grado ${i}`,
                    subjects: []
                };

                subject[i].map(item => {
                    let auxAll_dbas = [];
                    item.all_dbas.map(dba => {
                        if (dba !== null) {
                            auxAll_dbas.push(dba);
                        }
                    });
                    grade.subjects.push({
                        name: item.subject_name,
                        performance: item.performance,
                        recomendation: item.recomendation,
                        all_dbas: auxAll_dbas
                    });
                });
                setdataSubjects(dataSubjects => [...dataSubjects, grade]);
            });
        } else {
            setdataSubjects([
                {
                    name: "Sin registro de datos",
                    subjects: [
                        {
                            name: "No se tienen datos",
                            performance: "No se tienen datos",
                            recomendation: "No se tienen datos",
                            all_dbas: []
                        }
                    ]
                }
            ]);
        }
    }

    async function FetchIntelligences() {
        let itelliences = await fetchApi(
            urlToFetchInfoRecomendationIntelligence
        );
        if (itelliences.message === undefined || itelliences.length > 0) {
            setdataIntelligence(itelliences);
        } else {
            setdataIntelligence([
                {
                    average: "",
                    all_decsc: "No se tiene evidencia de ninguna dato",
                    name: "Sin registro de datos"
                }
            ]);
        }
        // setdataIntelligence(itelliences)
    }

    useEffect(() => {
        if (dataIntelligence.length > 0 && dataSubjects.length > 0) {
            setisLoaded(false);
        }
    }, [dataIntelligence, dataSubjects]);

    if (isLoaded) {
        return <LoadingPage />;
    } else {
        return (
            <div className="mt-5 col-12">
                <TittleTab
                    tittle={"Recomendaciones"}
                    nameItemClicked={nameItemClicked}
                />
                <CollapseRecomendation
                    dataIntelligence={dataIntelligence}
                    dataSubjects={dataSubjects}
                />
            </div>
        );
    }
}

export default ViewRecomendations;
