import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import ListSearch from "../../Organisms/listSearch/listSearch";

import { Switch, Route, useRouteMatch } from "react-router-dom";

import { fetchPost } from "../../../function/GlobalFunctions";
import SelectedView from "../selectedView/selectedView";
import RouterTabsStudent from "./RouterTabsStudent";

const StudentPage = props => {
    const state = {
        idForSearch: null,
        infoForSelectList: [],

        // Json to defined Name and router tabs
        tabsPage: [
            {
                name: "Resultado por asignatura",
                route: "resultadosporasignatura",
                activate: true
            },
            {
                name: "Inteligencias múltiples",
                route: "inteligenciasmultiples",
                activate: true
            },
            {
                name: "Estilos de aprendizaje",
                route: "estilosdeaprendizaje",
                activate: true
            },
            {
                name: "Resultados por competencias",
                route: "resultadosporcompetencia",
                activate: true
            },
            {
                name: "Recomendaciones",
                route: "recomendaciones",
                activate: true
            }
        ],
        messageSelectedView: "Selecciona un estudiante",
        placeHolder: "Ingrese un estudiante",
        tittleListSearch: "Estudiantes",
        showAllData: "General",
        routeForFetchListSearch:
            "https://raw.githubusercontent.com/DuvanMorenoCardona/json/master/department.json"
    };

    const { url } = useRouteMatch();

    const [isHovering, setIsHovering] = useState(false);

    const [nameItemClicked, setnameItemClicked] = useState("");

    useEffect(() => {
        setIsHovering(!props.isHovering);
    }, [props.isHovering]);

    const getNameItemClicked = name => {
        setnameItemClicked(name);
    };

    return (
        <div className="contentDepartment row h-100">
            <ListSearch
                tittle={state.tittleListSearch}
                placeHolder={state.placeHolder}
                routeForFetchListSearch={state.routeForFetchListSearch}
                isInput={true}
                isData={true}
                infoForSelectList={state.infoForSelectList}
                isHovering={props.isHovering}
                getNameItemClicked={getNameItemClicked}
                headquarters={props.headquarters}
                type={6}
            />
            <Switch>
                <Route exact path={`${url}`}>
                    <SelectedView text={state.messageSelectedView} />
                </Route>
                <Route path={`${url}/:idForFetch`}>
                    <RouterTabsStudent
                        tabsPage={state.tabsPage}
                        showAllData={state.showAllData}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={nameItemClicked}
                    />
                </Route>
            </Switch>
            {/* <ContentPageStudent
                    messageSelectedView={state.messageSelectedView}
                    getIdForSearch={state.idForSearch}
                    tabsPage={state.tabsPage}
                    showAllData={state.showAllData}
                    limitsForyLabels={props.limitsForyLabels}
                    nameItemClicked={state.nameItemClicked}
                /> */}
        </div>
    );
};

export default StudentPage;
