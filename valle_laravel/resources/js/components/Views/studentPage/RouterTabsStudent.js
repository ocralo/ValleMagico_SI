import React, { useState, useEffect } from "react";

import { Route, Switch, Redirect } from "react-router-dom";
import { useRouteMatch } from "react-router-dom";

import TabsContentSelectedList from "../../Organisms/tabsContentSelectedList/tabsContentSelectedList";

// Import Page Tabs
import ButtonGenerateInform from "../../Atoms/buttonGenerateInform";
import SelectListMovil from "../../Organisms/tabsContentSelectedList/selectListMovil";
import ViewResultSubjetc from "../resultSubject/ViewResultSubjetc";
import ViewResultMultipleIntelligences from "../resultMultipleIntelligences/ViewResultMultipleIntelligences";
import ViewLearningStyles from "../learningStyles/ViewLearningStyles";
import ViewResultCompetition from "../resultCompetitions/ViewResultCompetition";
import ViewRecomendations from "../recomendation/ViewRecomendations";

import { fetchApi } from "../../../function/GlobalFunctions";

const RouterTabsStudent = props => {
    const infoTabs = props.tabsPage;
    const { params, url } = useRouteMatch();
    const [isLoaded, setisLoaded] = useState(true);
    const [error, setError] = useState(null);
    const [jsonApi, setJsonApi] = useState([]);
    const tabs = [
        { id: "General" },
        { id: "Matematicas" },
        { id: "Lenguaje" },
        { id: "Competencias" },
        { id: "Ingles" },
        { id: "Sociales" },
        { id: "Naturales" }
    ];

    const routerFetchSubject = `${process.env.OPEN_VALLE_MAGICO_URL}student`;
    const routeFetchIntelligence = `${process.env.OPEN_VALLE_MAGICO_URL}intelligences`;
    const routeFetchStyles = `${process.env.OPEN_VALLE_MAGICO_URL}styles`;

    const routeFetchSubjectByGrade = `${process.env.OPEN_VALLE_MAGICO_URL}byGrade/student`;
    const routerFetchEvaluateData =
        `${process.env.OPEN_VALLE_MAGICO_URL}byGrade/school/student`;

    const routeFetchIntelligenceCompetitions =
        `${process.env.OPEN_VALLE_MAGICO_URL}competences/intelligences`;
    const routeFetchStyleCompetitions =
        `${process.env.OPEN_VALLE_MAGICO_URL}competences/styles`;

    const routeFetchVocational = `${process.env.OPEN_VALLE_MAGICO_URL}vocationals/student`;
    const routerFetchRecomendation =
        `${process.env.OPEN_VALLE_MAGICO_URL}recomendations/student`;

    const routeFetchGamesPlayed = `${process.env.OPEN_VALLE_MAGICO_URL}gamesPlayed/student`;

    const fetchTitleName = `${process.env.OPEN_VALLE_MAGICO_URL}api/student`;

    const routeFetchDataExcel = `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByStudent`;

    const [name, setName] = useState();

    useEffect(() => {
        (async function () {
            // const open_location = process.env.OPEN_LOCATION_URL;
            let ids = window.location.pathname.split('/');
            let ids2 = ids[3].split('-')
            //let idSt = parseInt(ids2[0])
            let idSt = parseInt(ids[4])

            if(props.nameItemClicked === ""){
                const json = await fetchApi(fetchTitleName + `/${idSt}`);
                setName(json[0].first_name + " " + json[0].second_name + " " + json[0].first_surname + " " + json[0].second_surname)
            }
        })();
    }, [props.nameItemClicked])

    return (
        <div className="col-12 m-0">
            <TabsContentSelectedList namesTabs={infoTabs} />
            <SelectListMovil namesTabs={infoTabs} />
            <Switch>
                <Route path={`${url}/resultadosporasignatura`}>
                    <ViewResultSubjetc
                        urltoGetInfoSubjects={`${routerFetchSubject}/${
                            params.idForFetch
                            }`}
                        urlToGetInfoGamesPlayed={`${routeFetchGamesPlayed}/${
                            params.idForFetch
                            }`}
                        urlToGetSubjectByGrade={`${routeFetchSubjectByGrade}/${
                            params.idForFetch
                            }`}
                        urlToGetEvaluateData={`${routerFetchEvaluateData}/${
                            params.idForFetch
                            }`}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={null}
                        dataChild={null}
                    />
                </Route>
                <Route path={`${url}/inteligenciasmultiples`}>
                    <ViewResultMultipleIntelligences
                        urlToGetInfoIntelligences={`${routeFetchIntelligence}/${
                            params.idForFetch
                            }`}
                        urlToGetInfoGamesPlayed={`${routeFetchGamesPlayed}/${
                            params.idForFetch
                            }/inteligencias`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                    />
                </Route>
                <Route path={`${url}/estilosdeaprendizaje`}>
                    <ViewLearningStyles
                        urlToGetInfoStyles={`${routeFetchStyles}/${
                            params.idForFetch
                            }`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                    />
                </Route>
                <Route path={`${url}/resultadosporcompetencia`}>
                    <ViewResultCompetition
                        urlToFetchCompetitionIntelligences={`${routeFetchIntelligenceCompetitions}/${
                            params.idForFetch
                            }`}
                        urlTOFetchCompetitionStyles={`${routeFetchStyleCompetitions}/${
                            params.idForFetch
                            }`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                    />
                </Route>
                <Route path={`${url}/recomendaciones`}>
                    <ViewRecomendations
                        urlToFetchInfoRecomendationSubject={`${routerFetchRecomendation}/${
                            params.idForFetch
                            }`}
                        urlToFetchInfoRecomendationIntelligence={`${routeFetchIntelligence}/${
                            params.idForFetch
                            }`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                    />
                </Route>
                <Redirect
                    from={`${url}`}
                    to={`${url}/resultadosporasignatura`}
                />
            </Switch>
            <ButtonGenerateInform
                routeFetchDataExcel={routeFetchDataExcel}
                idForFetch={params.idForFetch}
                routeFetchCompetitions={routerFetchSubject}
                routeFetchIntelligence={routeFetchIntelligence}
                routeFetchStyles={routeFetchStyles}
                routeFetchIntelligenceCompetitions={
                    routeFetchIntelligenceCompetitions
                }
                routeFetchStyleCompetitions={routeFetchStyleCompetitions}
                nameItemClicked={props.nameItemClicked}
                routeFetchVocational={routeFetchVocational}
                routerFetchSubject={routerFetchRecomendation}
                isReportStudent={true}
            />
        </div>
    );
};

export default RouterTabsStudent;
