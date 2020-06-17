import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import ListSearch from "../../Organisms/listSearch/listSearch";
import RoutesTabsGroup from "./RoutesTabsGroup";

import { Switch, Route, useRouteMatch } from "react-router-dom";
import SelectedView from "../selectedView/selectedView";

const GroupPage = props => {
    const [gradeForInfoUser, setGradeForInfoUser] = useState([]);

    const state = {
        // infoForSelectList: props.infoForSelectList,
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
        messageSelectedView: "Selecciona un grupo",
        placeHolder: "Ingrese el grupo",
        tittleListSearch: "Grupos",
        showAllData: "General",
        routeForFetchListSearch:
            "https://raw.githubusercontent.com/DuvanMorenoCardona/json/master/department.json"
    };

    const { url } = useRouteMatch();

    const [isHovering, setIsHovering] = useState(false);

    const [nameItemClicked, setnameItemClicked] = useState("");

    const [idGroup, setIdGroup] = useState();
    // const [idHeadquarter, setIdHeadquarter] = useState()

    useEffect(() => {
        setIsHovering(!props.isHovering);
    }, [props.isHovering]);

    const getNameItemClicked = (name) => {
        // setIdGroup(idHeadq);
        // setIdHeadquarter(idGroup)
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
                isHovering={isHovering}
                getNameItemClicked={getNameItemClicked}
                headquarters_hq={props.headquarters_hq}
            />
            <Switch>
                <Route exact path={`${url}`}>
                    <SelectedView text={state.messageSelectedView} />
                </Route>
                <Route path={`${url}/:idForFetch`}>
                    <RoutesTabsGroup
                        tabsPage={state.tabsPage}
                        showAllData={state.showAllData}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={nameItemClicked}
                        // idGroup={idGroup}
                        // idHeadquarter={idHeadquarter}
                    />
                </Route>
            </Switch>
        </div>
    );
};

export default GroupPage;
