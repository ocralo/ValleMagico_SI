import React, { useState, useEffect } from "react";
import { Switch, Route, useRouteMatch } from "react-router-dom";

import ListSearch from "../../Organisms/listSearch/listSearch";
import RoutesTabsHeadquater from "./RoutesTabsHeadquater";
import SelectedView from "../selectedView/selectedView";

const HeadquaterPage = props => {
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
        messageSelectedView: "Selecciona una sede",
        placeHolder: "Ingrese la sede",
        tittleListSearch: "Sedes",
        showAllData: "General",
        routeForFetchListSearch:
            "https://raw.githubusercontent.com/DuvanMorenoCardona/json/master/department.json"
    };

    const [isHovering, setIsHovering] = useState(false);

    const [nameItemClicked, setnameItemClicked] = useState("");

    const { url } = useRouteMatch();

    useEffect(() => {
        setIsHovering(!props.isHovering);
    }, [props.isHovering]);

    const getNameItemClicked = (name) => {
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
                type={4}
            />
            <Switch>
                <Route exact path={`${url}`}>
                    <SelectedView text={state.messageSelectedView} />
                </Route>
                <Route path={`${url}/:idForFetch`}>
                    <RoutesTabsHeadquater
                        tabsPage={state.tabsPage}
                        showAllData={state.showAllData}
                        limitsForyLabels={props.limitsForyLabels}
                        nameItemClicked={nameItemClicked}
                        // idHeadquarter={idHeadquarter}
                    />
                </Route>
            </Switch>
            {/* <ContentPageHeadquater
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

export default HeadquaterPage;
