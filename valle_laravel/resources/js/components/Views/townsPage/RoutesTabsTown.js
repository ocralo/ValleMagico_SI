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

const RoutesTabsTown = props => {
    const infoTabs = props.tabsPage;
    const { params, url } = useRouteMatch();
    const [dataChild, setDataChild] = useState([]);


    const routeFetchSubject = `${process.env.OPEN_VALLE_MAGICO_URL}town`;
    const routeFetchIntelligence = `${process.env.OPEN_VALLE_MAGICO_URL}intelligences/town`;
    const routeFetchStyles = `${process.env.OPEN_VALLE_MAGICO_URL}styles/town`;

    const routeFetchIntelligenceCompetitions =
        `${process.env.OPEN_VALLE_MAGICO_URL}competences/intelligences/town`;
    const routeFetchStyleCompetitions =
        `${process.env.OPEN_VALLE_MAGICO_URL}competences/styles/town`;

    const routeFetchVocational = `${process.env.OPEN_VALLE_MAGICO_URL}vocationals/town`;
    const routeRecomendation = `${process.env.OPEN_VALLE_MAGICO_URL}recomendations/town`;

    const routeFetchGamesPlayed = `${process.env.OPEN_VALLE_MAGICO_URL}gamesPlayed/town`;

    const fetchHierarchy = `${process.env.OPEN_VALLE_MAGICO_URL}api/institutionsByTown`;

    const fetchTitleName = `${process.env.OPEN_VALLE_MAGICO_URL}api/town`;
    
    const [name, setName] = useState();


    useEffect(() => {
        (async function () {
            const open_location = process.env.OPEN_LOCATION_URL;
            let ids = window.location.pathname.split('/');
            let ids2 = ids[3].split('-')
            let idTown = parseInt(ids2[0])
            const id = await fetchApi(fetchHierarchy + `/${idTown}`);
            if(props.nameItemClicked === ""){
                const json = await fetchApi(fetchTitleName + `/${idTown}`);
                // console.log('name', name[0].name)
                setName(json[0].name)
            }
            setDataChild(id);
        })();
    }, [props.nameItemClicked])

    return (
        <div className="col-12 m-0">
            <TabsContentSelectedList namesTabs={infoTabs} />

            <SelectListMovil namesTabs={infoTabs} />

            <Switch>
                <Route path={`${url}/resultadosporasignatura`}>
                    <ViewResultSubjetc
                        urltoGetInfoSubjects={`${routeFetchSubject}/${params.idForFetch}`}
                        urlToGetInfoGamesPlayed={`${routeFetchGamesPlayed}/${params.idForFetch}`}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Instituciones"}
                        dataChild={dataChild}
                        url={"/si/Instituciones/"}
                    />
                </Route>
                <Route path={`${url}/inteligenciasmultiples`}>
                    <ViewResultMultipleIntelligences
                        urlToGetInfoIntelligences={`${routeFetchIntelligence}/${params.idForFetch}`}
                        urlToGetInfoGamesPlayed={`${routeFetchGamesPlayed}/${params.idForFetch}/inteligencias`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Instituciones"}
                        dataChild={dataChild}
                        url={"/si/Instituciones/"}
                    />
                </Route>
                <Route path={`${url}/estilosdeaprendizaje`}>
                    <ViewLearningStyles
                        urlToGetInfoStyles={`${routeFetchStyles}/${params.idForFetch}`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Instituciones"}
                        dataChild={dataChild}
                        url={"/si/Instituciones/"}
                    />
                </Route>
                <Route path={`${url}/resultadosporcompetencia`}>
                    <ViewResultCompetition
                        urlToFetchCompetitionIntelligences={`${routeFetchIntelligenceCompetitions}/${params.idForFetch}`}
                        urlTOFetchCompetitionStyles={`${routeFetchStyleCompetitions}/${params.idForFetch}`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Instituciones"}
                        dataChild={dataChild}
                        url={"/si/Instituciones/"}
                    />
                </Route>
                <Route path={`${url}/recomendaciones`}>
                    <ViewRecomendations
                        urlToFetchInfoRecomendationSubject={`${routeRecomendation}/${params.idForFetch}`}
                        urlToFetchInfoRecomendationIntelligence={`${routeFetchIntelligence}/${params.idForFetch}`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                    />
                </Route>
                <Redirect
                    from={`${url}`}
                    to={`${url}/resultadosporasignatura`}
                />
            </Switch>

            <ButtonGenerateInform
                idForFetch={params.idForFetch}
                routeFetchCompetitions={routeFetchSubject}
                routeFetchIntelligence={routeFetchIntelligence}
                routeFetchStyles={routeFetchStyles}
                routeFetchIntelligenceCompetitions={
                    routeFetchIntelligenceCompetitions
                }
                routeFetchStyleCompetitions={routeFetchStyleCompetitions}
                nameItemClicked={props.nameItemClicked}
                routeFetchVocational={routeFetchVocational}
                routerFetchSubject={routeRecomendation}
            />
        </div>
    );
};

export default RoutesTabsTown;
