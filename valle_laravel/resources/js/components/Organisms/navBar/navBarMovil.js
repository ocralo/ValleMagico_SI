import React, { useState, useEffect, useLayoutEffect } from "react";

import { NavLink, Link, useLocation } from "react-router-dom";
import "./navBar.css";

const NavBarM = ({
    user,
    permissions,
    setIsHoveringDeparment,
    isHoveringProp
}) => {
    const [isHovering, setIsHovering] = useState(false);
    const [flagList, setFlagList] = useState(true);
    const [width, height] = useWindowSize();
    const locationn = useLocation();

    function useWindowSize() {
        const [size, setSize] = useState([0, 0]);
        useLayoutEffect(() => {
            function updateSize() {
                setSize([window.innerWidth, window.innerHeight]);
            }
            window.addEventListener("resize", updateSize);
            updateSize();
            return () => window.removeEventListener("resize", updateSize);
        }, []);
        return size;
    }

    useEffect(() => {
        setIsHovering(isHoveringProp);
    }, [isHoveringProp]);

    function getPermissionToPropPermission(namePermission) {
        // Find Permission
        let permissionExist = permissions.find(element =>
            isPermission(element, namePermission)
        );

        if (permissionExist == undefined) {
            return false;
        } else {
            return true;
        }
    }

    function isPermission(element, namePermission) {
        return element.name === namePermission;
    }

    function handleMouseHover() {
        setIsHovering(!isHovering);
        setIsHoveringDeparment(!isHovering);
    }

    useEffect(() => {
        const listSearch = document.getElementById("listSearch");
        if (listSearch != null) {
            if (width < 992) {
                if (flagList) {
                    listSearch.style.display = "none";
                } else {
                    listSearch.style.display = "block";
                }
            } else {
                listSearch.style.display = "block";
            }
        }
    });

    function showList(e) {
        setFlagList(!flagList);
        setIsHoveringDeparment(!flagList);
    }

    return (
        <nav className="nav flex-column">
            <div className="d-lg-none d-xl-block d-xl-none">
                <nav className="navbar navbar-light light-blue lighten-4">
                    <button
                        className="navbar-toggler toggler-example"
                        type="button"
                        data-toggle="collapse"
                        data-target="#navbarSupportedContent1"
                        aria-controls="navbarSupportedContent1"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <img
                            src={
                                __webpack_public_path__ +
                                "img/icon-menu-hamburguer.svg"
                            }
                            className="icon-navbar ml-2 mr-2 icon-menu-mobile"
                            alt="faq"
                        />
                    </button>
                    {locationn.pathname != "/si/home" &&
                        locationn.pathname != "/si/Ayuda" && (
                            <button
                                className="navbar-toggler toggler-example bg-cof"
                                type="button"
                                onClick={e => showList(e)}
                            >
                                {!isHovering ? "Ver lista" : "Ocultar lista"}
                            </button>
                        )}
                    <div
                        className="collapse navbar-collapse"
                        id="navbarSupportedContent1"
                        data-toggle="collapse"
                        data-target="#navbarSupportedContent1"
                    >
                        <ul className="navbar-nav mr-auto">
                            <NavLink
                                className="nav-link"
                                to="/si/home"
                                activeClassName="activate-navbar"
                            >
                                <div className="d-flex">
                                    <img
                                        src={
                                            __webpack_public_path__ +
                                            "img/icon-home.svg"
                                        }
                                        className="icon-navbar ml-2 mr-2"
                                        alt="inicio"
                                    />{" "}
                                    <div>Introducción</div>
                                </div>
                            </NavLink>

                            {getPermissionToPropPermission("Simat") && (
                                <NavLink
                                    className="nav-link"
                                    to="/si/SubirExcel"
                                    activeClassName="activate-navbar"
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-upload.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="Cargar"
                                        />{" "}
                                        <div>Carga de Simat</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission(
                                "Creación de usuarios"
                            ) && (
                                <NavLink
                                    className="nav-link"
                                    to="/si/Usuarios"
                                    activeClassName="activate-navbar"
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-student.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="Usuarios"
                                        />{" "}
                                        <div>Usuarios</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission(
                                "Creación de roles"
                            ) && (
                                <NavLink
                                    className="nav-link"
                                    to="/si/Roles"
                                    activeClassName="activate-navbar"
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-tag.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="inicio"
                                        />{" "}
                                        <div>Roles</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission("Departamentos") && (
                                <NavLink
                                    className="nav-link"
                                    activeClassName="activate-navbar"
                                    to="/si/Departamentos"
                                    onClick={handleMouseHover}
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-map.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="mapa"
                                        />{" "}
                                        <div>Departamentos</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission("Municipios") && (
                                <NavLink
                                    className="nav-link"
                                    activeClassName="activate-navbar"
                                    to="/si/Municipios"
                                    onClick={handleMouseHover}
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-montain.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="montaña"
                                        />{" "}
                                        <div>Municipios</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission("Instituciones") && (
                                <NavLink
                                    className="nav-link"
                                    activeClassName="activate-navbar"
                                    to="/si/Instituciones"
                                    onClick={handleMouseHover}
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-school.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="institucion"
                                        />{" "}
                                        <div>Instituciones</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission("Sedes") && (
                                <NavLink
                                    className="nav-link"
                                    activeClassName="activate-navbar"
                                    to="/si/Sedes"
                                    onClick={handleMouseHover}
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-grade.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="birrete"
                                        />{" "}
                                        <div>Sedes</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission("Grupos") && (
                                <NavLink
                                    className="nav-link"
                                    activeClassName="activate-navbar"
                                    to="/si/Grupos"
                                    onClick={handleMouseHover}
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-users.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="grupo de personas"
                                        />{" "}
                                        <div>Grupos</div>
                                    </div>
                                </NavLink>
                            )}

                            {getPermissionToPropPermission("Estudiantes") && (
                                <NavLink
                                    className="nav-link"
                                    activeClassName="activate-navbar"
                                    to="/si/Estudiantes"
                                    onClick={handleMouseHover}
                                >
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-user.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="estudiante"
                                        />{" "}
                                        <div>Estudiantes</div>
                                    </div>
                                </NavLink>
                            )}

                            <NavLink
                                className="nav-link"
                                activeClassName="activate-navbar"
                                to="/si/Ayuda"
                            >
                                <div className="d-flex">
                                    <img
                                        src={
                                            __webpack_public_path__ +
                                            "img/icon-help.svg"
                                        }
                                        className="icon-navbar ml-2 mr-2"
                                        alt="faq"
                                    />{" "}
                                    <div>FAQ</div>
                                </div>
                            </NavLink>

                            <Link
                                className="nav-link align-text-bottom"
                                to="#bannerformmodal"
                                data-toggle="modal"
                                data-target="#exampleModal"
                            >
                                <div className="d-flex align-middle">
                                    <div className="d-flex">
                                        <img
                                            src={
                                                __webpack_public_path__ +
                                                "img/icon-exit.svg"
                                            }
                                            className="icon-navbar ml-2 mr-2"
                                            alt="salir"
                                        />{" "}
                                        <div>Cerrar sesión</div>
                                    </div>
                                </div>
                            </Link>
                        </ul>
                    </div>
                </nav>
            </div>
        </nav>
    );
};

export default NavBarM;
