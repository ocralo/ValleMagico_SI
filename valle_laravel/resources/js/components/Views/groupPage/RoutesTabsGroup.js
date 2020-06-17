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

const RoutesTabsGroup = props => {
    const infoTabs = props.tabsPage;
    const { params, url } = useRouteMatch();
    const [idFetch, setIdFetch] = useState([]);

    const [dataChild, setDataChild] = useState([]);

    useEffect(() => {
        setIdFetch(params.idForFetch.split("-", [2]));
    }, [params.idForFetch]);

    const routeFetchSubject = `${process.env.OPEN_VALLE_MAGICO_URL}grade`;
    const routeFetchIntelligence = `${process.env.OPEN_VALLE_MAGICO_URL}intelligences/grade`;
    const routeFetchStyles = `${process.env.OPEN_VALLE_MAGICO_URL}styles/grade`;

    const routeFetchIntelligenceCompetitions =
        `${process.env.OPEN_VALLE_MAGICO_URL}competences/intelligences/grade`;
    const routeFetchStyleCompetitions =
        `${process.env.OPEN_VALLE_MAGICO_URL}competences/styles/grade`;

    const routeFetchVocational = `${process.env.OPEN_VALLE_MAGICO_URL}vocationals/grade`;
    const routerFetchRecomentation =
        `${process.env.OPEN_VALLE_MAGICO_URL}recomendations/grade`;

    const routeFetchGamesPlayed = `${process.env.OPEN_VALLE_MAGICO_URL}gamesPlayed/grade`;

    const fetchHierarchy = `${process.env.OPEN_VALLE_MAGICO_URL}api/studentsByGroups`;

    const fetchTitleName = `${process.env.OPEN_VALLE_MAGICO_URL}api/group`;

    const fetchTitleNameHeadq = `${process.env.OPEN_VALLE_MAGICO_URL}api/headquarter`;

    const [name, setName] = useState();


    useEffect(() => {
        (async function () {
            // const open_location = process.env.OPEN_LOCATION_URL;
            let ids = window.location.pathname.split('/');
            let ids2 = ids[3].split('-')
            let idHeadq = parseInt(ids2[0])
            let idGroup = parseInt(ids2[1])
            const id = await fetchApi(fetchHierarchy + `/${idHeadq},${idGroup}`);
            let names = [];
            id.map(data => {
                names.push({
                    name: `${data.first_name} ${data.second_name} ${data.first_surname} ${data.second_surname}`,
                    id: data.id
                })
            })
            if(props.nameItemClicked === ""){
                const json = await fetchApi(fetchTitleName + `/${idGroup}`);
                const json2 = await fetchApi(fetchTitleNameHeadq + `/${idHeadq}`);
                console.log('name', json[0].name, json2[0].name)
                setName(json2[0].name + '-' +  json[0].name)
            }
            setDataChild(names);
        })();
    }, [props.nameItemClicked])

    return (
        <div className="col-12 m-0">
            <TabsContentSelectedList namesTabs={infoTabs} />
            <SelectListMovil namesTabs={infoTabs} />
            <Switch>
                <Route path={`${url}/resultadosporasignatura`}>
                    <ViewResultSubjetc
                        urltoGetInfoSubjects={`${routeFetchSubject}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        urlToGetInfoGamesPlayed={`${routeFetchGamesPlayed}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Estudiantes"}
                        dataChild={dataChild}
                        url={"/si/Estudiantes/"}
                    />
                </Route>
                <Route path={`${url}/inteligenciasmultiples`}>
                    <ViewResultMultipleIntelligences
                        urlToGetInfoIntelligences={`${routeFetchIntelligence}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        urlToGetInfoGamesPlayed={`${routeFetchGamesPlayed}/${
                            idFetch[0]
                            }/${idFetch[1]}/inteligencias`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Estudiantes"}
                        dataChild={dataChild}
                        url={"/si/Estudiantes/"}
                    />
                </Route>
                <Route path={`${url}/estilosdeaprendizaje`}>
                    <ViewLearningStyles
                        urlToGetInfoStyles={`${routeFetchStyles}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Estudiantes"}
                        dataChild={dataChild}
                        url={"/si/Estudiantes/"}
                    />
                </Route>
                <Route path={`${url}/resultadosporcompetencia`}>
                    <ViewResultCompetition
                        urlToFetchCompetitionIntelligences={`${routeFetchIntelligenceCompetitions}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        urlTOFetchCompetitionStyles={`${routeFetchStyleCompetitions}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                        titleChild={"Estudiantes"}
                        dataChild={dataChild}
                        url={"/si/Estudiantes/"}
                    />
                </Route>
                <Route path={`${url}/recomendaciones`}>
                    <ViewRecomendations
                        urlToFetchInfoRecomendationSubject={`${routerFetchRecomentation}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        urlToFetchInfoRecomendationIntelligence={`${routeFetchIntelligence}/${
                            idFetch[0]
                            }/${idFetch[1]}`}
                        nameItemClicked={props.nameItemClicked === "" ? name : props.nameItemClicked}
                    />
                </Route>
                <Redirect
                    from={`${url}`}
                    to={`${url}/resultadosporasignatura`}
                />
            </Switch>
            <ButtonGenerateInform
                idForFetch={`${idFetch[0]}/${idFetch[1]}`}
                routeFetchCompetitions={routeFetchSubject}
                routeFetchIntelligence={routeFetchIntelligence}
                routeFetchStyles={routeFetchStyles}
                routeFetchIntelligenceCompetitions={
                    routeFetchIntelligenceCompetitions
                }
                routeFetchStyleCompetitions={routeFetchStyleCompetitions}
                nameItemClicked={props.nameItemClicked}
                routeFetchVocational={routeFetchVocational}
                routerFetchSubject={routerFetchRecomentation}
            />
        </div>
    );
};

export default RoutesTabsGroup;
