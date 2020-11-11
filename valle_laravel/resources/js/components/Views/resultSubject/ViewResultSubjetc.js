import React, { useState, useEffect } from "react";
import TittleTab from "../../Atoms/tittleTab";
import GroupCardsAverage from "../../Organisms/groupCardsAverage/groupCardsAverage";
import CardGraph from "../../Organisms/cardGraph/cardGraph";
import CardHierarchy from "../../Organisms/cardHierarchy/cardHierarchy";
import LoadingPage from "../loadingPage/loadingPage";

import { fetchApi } from "../../../function/GlobalFunctions";

function ViewResultSubjetc({
    idFetch,
    fetchDataFrom,
    urltoGetInfoSubjects,
    urlToGetInfoGamesPlayed,
    urlToGetSubjectByGrade = undefined,
    urlToGetEvaluateData = undefined,
    limitsForyLabels,
    nameItemClicked,
    titleChild,
    dataChild,
    url
}) {
    const titlePage = "Resultados por asignatura";
    const [isLoaded, setisLoaded] = useState(true);
    const [error, setError] = useState(null);

    const [dataGamesPlayed, setdataGamesPlayed] = useState();
    const [jsonApi, setJsonApi] = useState([]);
    const [subjectResultByGrade, setsubjectResultByGrade] = useState([]);

    const tabs = [
        { id: "General" },
        { id: "Matematicas" },
        { id: "Lenguaje" },
        { id: "Competencias" },
        { id: "Ingles" },
        { id: "Sociales" },
        { id: "Naturales" }
    ];
    const showAllData = "General";

    async function fetchData() {
        setisLoaded(true);
        try {
            // const result = await fetchApi(`http://127.0.0.1:8000/department/${props.idForFetch}`)
            const result = await fetchApi(urltoGetInfoSubjects);
            setJsonApi(result);
            // const gamesPlayedInfo = await fetchApi(`http://127.0.0.1:8000/gamesPlayed/department/${props.idForFetch}`)
            const gamesPlayedInfo = await fetchApi(urlToGetInfoGamesPlayed);
            setdataGamesPlayed(gamesPlayedInfo);

            if (
                urlToGetSubjectByGrade !== undefined &&
                urlToGetEvaluateData !== undefined
            ) {
                const getSubjectResultByGrade = await fetchApi(
                    urlToGetSubjectByGrade
                );
                const getEvaluateData = await fetchApi(urlToGetEvaluateData);
                isDataSubject(getSubjectResultByGrade, getEvaluateData);
            }

            setisLoaded(false);
        } catch (error) {
            setisLoaded(true);
            setError(error);
        }
    }

    function isDataSubject(result, evaluateData) {
        //console.log("TCL: isDataSubject -> result", result.message);
        if (result.message == undefined) {
            //console.log("TCL: isDataSubject -> result", result);
            Object.keys(result).map(i => {
                let grade = {
                    name: `Grado ${i}`,
                    subjects: [],
                    evaluate: []
                };
                result[i].map(item =>
                    grade.subjects.push({
                        average: item.average,
                        name: `${item.subject
                            .charAt(0)
                            .toUpperCase()}${item.subject.slice(1)}`
                    })
                );

                if (evaluateData[i] !== undefined) {
                    evaluateData[i].map(item =>
                        grade.evaluate.push({
                            average: item.average,
                            name: `${item.subject
                                .charAt(0)
                                .toUpperCase()}${item.subject.slice(1)}`
                        })
                    );
                }

                setsubjectResultByGrade(subjectResultByGrade => [
                    ...subjectResultByGrade,
                    grade
                ]);
            });
        } else {
            setsubjectResultByGrade([]);
        }
    }

    useEffect(() => {
        //console.log("fetchDataFrom", fetchDataFrom);
    }, []);

    useEffect(() => {
        //console.log("urltoGetInfoSubjects", urltoGetInfoSubjects);
        // if (urltoGetInfoSubjects !== undefined) {
        fetchData();
        // }
    }, [urltoGetInfoSubjects, urlToGetInfoGamesPlayed]);

    if (isLoaded) {
        return <LoadingPage />;
    } else {
        return (
            <div>
                <TittleTab
                    tittle={titlePage}
                    nameItemClicked={nameItemClicked}
                />
                <GroupCardsAverage
                    titleCardTotalGames="Total de juegos"
                    averageTotalGames={dataGamesPlayed.total_games}
                    titleAverage="Promedio de juegos jugados"
                    averageGamesPlayed={dataGamesPlayed.average}
                    titleChildren="adasdasd"
                    averageCildren={{ data: 0, total: 45 }}
                    // 25 d 50
                />
                <CardGraph
                    tabs={tabs}
                    jsonApi={jsonApi}
                    showAllData={showAllData}
                    limitsForyLabels={limitsForyLabels}
                />
                {titleChild !== null ? (
                    <CardHierarchy
                        idFetch={idFetch}
                        title={titleChild}
                        data={dataChild}
                        url={url}
                        fetchDataFrom={fetchDataFrom}
                    />
                ) : null}
                {subjectResultByGrade.length > 0 &&
                    subjectResultByGrade.map((item, i) => (
                        <div key={i}>
                            <CardGraph
                                titleCard={item.name}
                                jsonApi={item.subjects}
                                showAllData={showAllData}
                                // typeGraph={'line'}
                                limitsForyLabels={limitsForyLabels}
                            />
                            {item.evaluate.length > 0 && (
                                <CardGraph
                                    titleCard={`${item.name} evaluación`}
                                    jsonApi={item.evaluate}
                                    showAllData={showAllData}
                                    // typeGraph={'line'}
                                    limitsForyLabels={limitsForyLabels}
                                />
                            )}
                        </div>
                    ))}
            </div>
        );
    }
}

export default ViewResultSubjetc;
