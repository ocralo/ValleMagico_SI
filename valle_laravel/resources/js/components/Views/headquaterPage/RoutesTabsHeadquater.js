import React, { useState, useEffect } from "react";

import { Route, Switch, Redirect } from "react-router-dom";
import { useRouteMatch, useLocation } from "react-router-dom";

import TabsContentSelectedList from "../../Organisms/tabsContentSelectedList/tabsContentSelectedList";

// Import Page Tabs
import { fetchApi } from "../../../function/GlobalFunctions";
import ButtonGenerateInform from "../../Atoms/buttonGenerateInform";
import SelectListMovil from "../../Organisms/tabsContentSelectedList/selectListMovil";
import ViewResultSubjetc from "../resultSubject/ViewResultSubjetc";
import ViewResultMultipleIntelligences from "../resultMultipleIntelligences/ViewResultMultipleIntelligences";
import ViewLearningStyles from "../learningStyles/ViewLearningStyles";
import ViewResultCompetition from "../resultCompetitions/ViewResultCompetition";
import ViewRecomendations from "../recomendation/ViewRecomendations";

const RoutesTabsHeadquater = props => {
    const infoTabs = props.tabsPage;
    const { params, url } = useRouteMatch();

    const [dataChild, setDataChild] = useState([]);

    const routeFetchSubject = `${process.env.OPEN_VALLE_MAGICO_URL}headquarter`;
    const routeFetchIntelligence = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }intelligences/headquarter`;
    const routeFetchStyles = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }styles/headquarter`;

    const routeFetchIntelligenceCompetitions = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }competences/intelligences/headquarter`;
    const routeFetchStyleCompetitions = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }competences/styles/headquarter`;

    const routeFetchVocational = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }vocationals/headquarter`;
    const routerFetchRecomendationSubject = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }recomendations/headquarter`;

    const routeFetchGamesPlayed = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }gamesPlayed/headquarter`;

    const fetchHierarchy = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/groupsByHeadquarters`;

    const fetchTitleName = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/headquarter`;

    const routeFetchDataExcel = `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByHeadquarter`;

    const fetchDataFrom = `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/headquarterGroupDataComeFrom`;

    const [name, setName] = useState();

    const [idHeadquarter, setIdHeadquarter] = useState();

    const location = useLocation();

    useEffect(() => {
        (async function() {
            let ids = location.pathname.split("/");
            let ids2 = ids[3].split("-");
            let idHeadQ = parseInt(ids2[0]);

            setIdHeadquarter(idHeadQ);
            const id = await fetchApi(`${fetchHierarchy}/${idHeadQ}`);
            if (props.nameItemClicked === "") {
                const json = await fetchApi(`${fetchTitleName}/${idHeadQ}`);
                // console.log('name', json[0].name)
                setName(json.name);
            }
            let id2 = id.slice(0, 12);
            setDataChild(id2);
        })();
    }, [props.nameItemClicked]);

    return (
        <div className="col-12 m-0">
            <TabsContentSelectedList namesTabs={infoTabs} />
            <SelectListMovil namesTabs={infoTabs} />
            <Switch>
                <Route path={`${url}/resultadosporasignatura`}>
                    <ViewResultSubjetc
                        urltoGetInfoSubjects={`${routeFetchSubject}/${
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
                        titleChild={"Grupos"}
                        dataChild={dataChild}
                        url={`/si/Grupos/${idHeadquarter}-`}
                        idFetch={[params.idForFetch]}
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
                        titleChild={"Grupos"}
                        dataChild={dataChild}
                        url={`/si/Grupos/${idHeadquarter}-`}
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
                        titleChild={"Grupos"}
                        dataChild={dataChild}
                        url={`/si/Grupos/${idHeadquarter}-`}
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
                        titleChild={"Grupos"}
                        dataChild={dataChild}
                        url={`/si/Grupos/${idHeadquarter}-`}
                    />
                </Route>
                <Route path={`${url}/recomendaciones`}>
                    <ViewRecomendations
                        urlToFetchInfoRecomendationSubject={`${routerFetchRecomendationSubject}/${
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
                routeFetchDataExcel={routeFetchDataExcel}
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
                routerFetchSubject={routerFetchRecomendationSubject}
            />
        </div>
    );
};

export default RoutesTabsHeadquater;
