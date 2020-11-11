import React, { useState, useEffect } from "react";
import { Switch, Route, useRouteMatch } from 'react-router-dom'

import ListSearch from "../../Organisms/listSearch/listSearch";
import RoutesTabsTown from "./RoutesTabsTown";
import SelectedView from "../selectedView/selectedView";

const TownsPage = (props) => {

    const [isHovering, setIsHovering] = useState(false);

    const [nameItemClicked, setnameItemClicked] = useState("");

    const state = {
        nameItemClicked: "",
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
        messageSelectedView: "Selecciona un Municipio",
        placeHolder: "Ingrese el municipio",
        tittleListSearch: "Municipios",
        showAllData: "General",
        routeForFetchListSearch:
            "https://raw.githubusercontent.com/DuvanMorenoCardona/json/master/town1.json"
    }

    const { url } = useRouteMatch();

    useEffect(() => {
        setIsHovering(!props.isHovering);
    }, [props.isHovering]);

    const getNameItemClicked = (name) => {
        setnameItemClicked(name)
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
                type={2}
            />
            <Switch>
                <Route exact path={`${url}`}>
                    <SelectedView text={state.messageSelectedView} />
                </Route>
                <Route path={`${url}/:idForFetch`}>
                    <RoutesTabsTown
                        tabsPage={state.tabsPage}
                        showAllData={state.showAllData}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={nameItemClicked}
                        // idTown={idTown}
                    />
                </Route>
            </Switch>
        </div>
    );
}

export default TownsPage;
