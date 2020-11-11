import React, { useState, useEffect } from "react";

import { Route, Switch, Redirect } from "react-router-dom";
import { useRouteMatch, useLocation } from "react-router-dom";

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

const RoutesTabsDepartment = props => {
    const infoTabs = props.tabsPage;

    const [idFetch, setIdFetch] = useState([]);

    const { params, url } = useRouteMatch();

    const [dataChild, setDataChild] = useState([]);

    const location = useLocation();

    // Url to Fetch
    const routerFetchSubject = `${process.env.OPEN_VALLE_MAGICO_URL}department`;
    const routeFetchIntelligence = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }intelligences/department`;
    const routeFetchStyles = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }styles/department`;
    const routeFetchVocational = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }vocationals/department`;
    const routerFetchRecomendation = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }recomendations/department`;
    // url to fetch played games
    const routeFetchGamesPlayed = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }gamesPlayed/department`;

    const routeFetchIntelligenceCompetitions = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }competences/intelligences/department`;
    const routeFetchStyleCompetitions = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }competences/styles/department`;

    const fetchHierarchy = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/townsByDepartment`;

    const fetchTitleName = `${process.env.OPEN_VALLE_MAGICO_URL}api/department`;

    const routeFetchDataExcel = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/dataByDepartment`;

    const [name, setName] = useState();

    const fetchDataFrom = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/townDataComeFrom`;

    useEffect(() => {
        (async function() {
            let ids = location.pathname.split("/");
            let ids2 = ids[3].split("-");
            let idDept = parseInt(ids2[0]);
            setIdFetch(idDept);
            const id = await fetchApi(fetchHierarchy + `/${idDept}`);
            if (props.nameItemClicked === "") {
                const json = await fetchApi(fetchTitleName + `/${idDept}`);

                setName(json[0].name);
            }
            setDataChild(id);
        })();
    }, [props.nameItemClicked]);

    return (
        <div className="col-md-12 col-sm-12 col-lg-12  m-0">
            <div className="container-fluid">
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
                            fetchDataFrom={fetchDataFrom}
                            limitsForyLabels={props.limitsForyLabels}
                            nameItemClicked={
                                props.nameItemClicked === ""
                                    ? name
                                    : props.nameItemClicked
                            }
                            titleChild={"Municipios"}
                            dataChild={dataChild}
                            url={"/si/Municipios/"}
                            idFetch={idFetch}
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
                            nameItemClicked={
                                props.nameItemClicked === ""
                                    ? name
                                    : props.nameItemClicked
                            }
                            titleChild={"Municipios"}
                            dataChild={dataChild}
                            url={"/si/Municipios/"}
                        />
                    </Route>
                    <Route path={`${url}/estilosdeaprendizaje`}>
                        <ViewLearningStyles
                            urlToGetInfoStyles={`${routeFetchStyles}/${
                                params.idForFetch
                            }`}
                            nameItemClicked={
                                props.nameItemClicked === ""
                                    ? name
                                    : props.nameItemClicked
                            }
                            titleChild={"Municipios"}
                            dataChild={dataChild}
                            url={"/si/Municipios/"}
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
                            nameItemClicked={
                                props.nameItemClicked === ""
                                    ? name
                                    : props.nameItemClicked
                            }
                            titleChild={"Municipios"}
                            dataChild={dataChild}
                            url={"/si/Municipios/"}
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
                            nameItemClicked={
                                props.nameItemClicked === ""
                                    ? name
                                    : props.nameItemClicked
                            }
                        />
                    </Route>
                    <Redirect
                        from={`${url}`}
                        to={`${url}/resultadosporasignatura`}
                    />
                </Switch>
                <ButtonGenerateInform
                    tittle={props.tittle}
                    routeFetchDataExcel={routeFetchDataExcel}
                    idForFetch={params.idForFetch}
                    routeFetchCompetitions={routerFetchSubject}
                    routeFetchIntelligence={routeFetchIntelligence}
                    routeFetchStyles={routeFetchStyles}
                    routeFetchIntelligenceCompetitions={
                        routeFetchIntelligenceCompetitions
                    }
                    routeFetchStyleCompetitions={routeFetchStyleCompetitions}
                    routeFetchVocational={routeFetchVocational}
                    routerFetchSubject={routerFetchRecomendation}
                    limitsForyLabels={props.limitsForyLabels}
                    nameItemClicked={props.nameItemClicked}
                />
            </div>
        </div>
    );
};

export default RoutesTabsDepartment;
