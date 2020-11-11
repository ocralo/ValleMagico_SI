import React, { useEffect, useState } from "react";
import { Switch, Route, useRouteMatch } from "react-router-dom";

import ListSearch from "../../Organisms/listSearch/listSearch";
import SelectedView from "../selectedView/selectedView";
import RoutesTabsDepartment from "./RoutesTabsDepartment";
const DeparmentPage = props => {
    const [isHovering, setIsHovering] = useState(false);
    const [nameItemClicked, setnameItemClicked] = useState("");

    const state = {
        idForSearch: null,
        infoForSelectList: props.infoForSelectList,
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
        messageSelectedView: "Selecciona un Departamento",
        placeHolder: "Ingrese el departamento",
        tittleListSearch: "Departamentos",
        showAllData: "General",
        routeForFetchListSearch:
            "https://raw.githubusercontent.com/DuvanMorenoCardona/json/master/department.json"
    };

    const { url } = useRouteMatch();


    useEffect(() => {
        setIsHovering(!props.isHovering);
    }, [props.isHovering]);

    function getNameItemClicked(name) {
        setnameItemClicked(name);
    }

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
                type={1}
            />
            <Switch>
                <Route exact path={`${url}`}>
                    <SelectedView text={state.messageSelectedView} />
                </Route>
                <Route path={`${url}/:idForFetch`}>
                    <RoutesTabsDepartment
                        tittle={state.tittleListSearch}
                        tabsPage={state.tabsPage}
                        showAllData={state.showAllData}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={nameItemClicked}
                        // idDepartment={idDepartment}
                    />
                </Route>
            </Switch>
        </div>
    );
};

export default DeparmentPage;
