import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";

import { BrowserRouter, Switch, Route, Redirect } from "react-router-dom";

// Importar Componentes
import HelpPage from "../helpPage/helpPage";
import IntroPage from "../introPage/introPage";

import { fetchApi } from "../../../function/GlobalFunctions";
import LoadingPage from "../loadingPage/loadingPage";
import { EntityTypeContext } from "../_/_context/_context";

//_refactor
import _informationPage from "../_/_informationPage/_informationPage";
import _MainMenu from "../_/_mainMenu/_mainMenu";
import _MainMenuMobile from "../_/_mainMenuMobile/_mainMenuMobile";

const HomePage = ({ id }) => {
    const [isLoading, setIsLoading] = useState(true);
    const [infoForSelectList, setInfoForSelectList] = useState(null);
    const [isHovering, setIsHovering] = useState(false);

    const [entityType, setEntityType] = useState(0);

    useEffect(() => {
        //console.log(id);
        setIsLoading(true);
        if (id != null) {
            fetchData();
        }
    }, [id]);

    async function fetchData() {
        try {
            let infoUser = await fetchApi(
                `${process.env.OPEN_VALLE_MAGICO_URL}infoUser/${id}`
            );
            //este no se debe machetear :3
            // let performanceResult = await fetchApi(
            //     `${process.env.OPEN_VALLE_MAGICO_URL}performances`
            // );
            setInfoForSelectList(infoUser);
            setIsLoading(false);
        } catch (error) {
            console.warn(error);
        }
    }

    function handleMouseHoverTrue() {
        setIsHovering(true);
    }

    function handleMouseHoverFalse() {
        setIsHovering(false);
    }

    function setIsOpen(e) {
        setIsHovering(!isHovering);
    }

    if (isLoading) {
        return <LoadingPage />;
    } else {
        return (
            <BrowserRouter basename="/si">
                <Redirect to="/home" />
                <EntityTypeContext.Provider
                    value={{ entityType, setEntityType }}
                >
                    <div>
                        <div className="content-BarM  d-none d-md-block d-lg-none  	d-block d-sm-none  d-sm-block d-md-none">
                            <_MainMenuMobile
                                permissions={infoForSelectList.user_permissions}
                                setIsHoveringDeparment={setIsOpen}
                                isHoveringProp={isHovering}
                            />
                        </div>
                    </div>

                    <div className="d-flex">
                        <div className="d-none d-xl-block d-none d-lg-block d-xl-none">
                            <div
                                onMouseEnter={handleMouseHoverTrue}
                                onMouseLeave={handleMouseHoverFalse}
                                className="h-100 pruebaOPgg"
                            >
                                <_MainMenu
                                    permissions={
                                        infoForSelectList.user_permissions
                                    }
                                    isHovering={isHovering}
                                />
                            </div>
                        </div>

                        <div className="content-Page container-fluid">
                            <Switch>
                                <Route
                                    exact
                                    path="/home"
                                    component={IntroPage}
                                />
                                <Route path="/Ayuda" component={HelpPage} />
                                <Route path="/">
                                    <_informationPage
                                        isHovering={isHovering}
                                        handleMouseHoverTrue={
                                            handleMouseHoverTrue
                                        }
                                        handleMouseHoverFalse={
                                            handleMouseHoverFalse
                                        }
                                        infoForSelectList={{
                                            charGroups:
                                                infoForSelectList.charGroups,
                                            charStudents:
                                                infoForSelectList.charStudents
                                        }}
                                    />
                                </Route>
                            </Switch>
                        </div>
                    </div>

                    <div
                        className="modal fade"
                        id="exampleModal"
                        tabIndex="-1"
                        role="dialog"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                    >
                        <div className="modal-dialog" role="document">
                            <div className="modal-content">
                                <div className="modal-body">
                                    <div className="modal-body  ">
                                        <h5
                                            className="modal-title"
                                            id="exampleModalLabel"
                                        >
                                            Cerrar sesión
                                        </h5>
                                    </div>
                                    <div className="modal-footer d-flex justify-content-between ">
                                        <button
                                            type="button"
                                            className="btn btn-modal-close"
                                            data-dismiss="modal"
                                        >
                                            Cancelar
                                        </button>
                                        <a
                                            className="btn-modal-logout"
                                            href={`${
                                                process.env
                                                    .OPEN_VALLE_MAGICO_URL
                                            }/si/logout`}
                                        >
                                            Cerrar sesión
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </EntityTypeContext.Provider>
            </BrowserRouter>
        );
    }
};

export default HomePage;

if (document.getElementById("HomePage")) {
    const el = document.getElementById("HomePage");
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(<HomePage {...props} />, el);
}
