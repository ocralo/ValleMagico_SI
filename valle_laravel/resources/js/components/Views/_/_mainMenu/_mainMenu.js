import React, { useState, useContext } from "react";

import { NavLink, Link } from "react-router-dom";

import { EntityTypeContext } from "../_context/_context";

const _MainMenu = ({ user, permissions, isHovering }) => {
    const [isHoveringDeparment, setIsHoveringDeparment] = useState(false);

    const { entityType, setEntityType } = useContext(EntityTypeContext);

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
        setIsHoveringDeparment(!isHoveringDeparment);
    }

    return (
        <nav className="navbar navbar-expand content-Bar d-flex flex-wrap justify-content-around">
            <button
                className="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarTogglerDemo03"
                aria-controls="navbarTogglerDemo03"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span className="navbar-toggler-icon" />
            </button>
            <Link
                className="nav-link align-text-bottom p-0 w-100 btn-menu rounded"
                to="/home"
            >
                <div
                    className={
                        entityType === 0
                            ? "d-flex align-middle w-100 py-3 bg-active-white rounded"
                            : "d-flex align-middle w-100 py-3 rounded"
                    }
                    onClick={() => setEntityType(0)}
                >
                    <img
                        src={__webpack_public_path__ + "img/icon-home.svg"}
                        className="icon-navbar ml-2"
                        alt="inicio"
                    />
                    <div className="pl-1">Introducción</div>
                </div>
            </Link>
            {getPermissionToPropPermission("Simat") && (
                <div
                    className={
                        entityType === 0
                            ? "d-flex align-middle w-100 py-3 bg-active-white rounded"
                            : "d-flex align-middle w-100 py-3 rounded"
                    }
                    onClick={() => setEntityType()}
                >
                    <img
                        src={__webpack_public_path__ + "img/icon-upload.svg"}
                        className="icon-navbar ml-2"
                        alt="cargar"
                    />
                    <div className="pl-1">Carga de Simat</div>
                </div>
            )}

            {getPermissionToPropPermission("Creación de usuarios") && (
                <div className="d-flex" onClick={() => setEntityType()}>
                    <img
                        src={__webpack_public_path__ + "img/icon-student.svg"}
                        className="icon-navbar ml-2"
                        alt="usuario"
                    />
                    <div className="pl-1">Usuarios</div>
                </div>
            )}

            {getPermissionToPropPermission("Creación de roles") && (
                <div className="d-flex" onClick={() => setEntityType()}>
                    <img
                        src={__webpack_public_path__ + "img/icon-tag.svg"}
                        className="icon-navbar ml-2"
                        alt="Roles"
                    />
                    <div className="pl-1">Roles</div>
                </div>
            )}

            {getPermissionToPropPermission("Departamentos") && (
                <Link
                    className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                    to="/"
                >
                    <div
                        className={
                            entityType === 1
                                ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                                : "d-flex align-middle w-100 py-3 btn-menu rounded"
                        }
                        onClick={() => setEntityType(1)}
                    >
                        <img
                            src={__webpack_public_path__ + "img/icon-map.svg"}
                            className="icon-navbar ml-2"
                            alt="mapa"
                        />
                        <div className="pl-1">Departamentos</div>
                    </div>
                </Link>
            )}

            {getPermissionToPropPermission("Municipios") && (
                <Link
                    className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                    to="/"
                >
                    <div
                        className={
                            entityType === 2
                                ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                                : "d-flex align-middle w-100 py-3 btn-menu rounded"
                        }
                        onClick={() => setEntityType(2)}
                    >
                        <img
                            src={
                                __webpack_public_path__ + "img/icon-montain.svg"
                            }
                            className="icon-navbar ml-2"
                            alt="montaña"
                        />
                        <div className="pl-1">Municipios</div>
                    </div>
                </Link>
            )}

            {getPermissionToPropPermission("Instituciones") && (
                <Link
                    className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                    to="/"
                >
                    <div
                        className={
                            entityType === 3
                                ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                                : "d-flex align-middle w-100 py-3 btn-menu rounded"
                        }
                        onClick={() => setEntityType(3)}
                    >
                        <img
                            src={
                                __webpack_public_path__ + "img/icon-school.svg"
                            }
                            className="icon-navbar ml-2"
                            alt="institucion"
                        />
                        <div className="pl-1">Instituciones</div>
                    </div>
                </Link>
            )}

            {getPermissionToPropPermission("Sedes") && (
                <Link
                    className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                    to="/"
                >
                    <div
                        className={
                            entityType === 4
                                ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                                : "d-flex align-middle w-100 py-3 btn-menu rounded"
                        }
                        onClick={() => setEntityType(4)}
                    >
                        <img
                            src={__webpack_public_path__ + "img/icon-grade.svg"}
                            className="icon-navbar ml-2"
                            alt="birrete"
                        />
                        <div className="pl-1">Sedes</div>
                    </div>
                </Link>
            )}

            {getPermissionToPropPermission("Grupos") && (
                <Link
                    className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                    to="/"
                >
                    <div
                        className={
                            entityType === 5
                                ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                                : "d-flex align-middle w-100 py-3 btn-menu rounded"
                        }
                        onClick={() => setEntityType(5)}
                    >
                        <img
                            src={__webpack_public_path__ + "img/icon-users.svg"}
                            className="icon-navbar ml-2"
                            alt="grupo de personas"
                        />
                        <div className="pl-1">Grupos</div>
                    </div>
                </Link>
            )}

            {getPermissionToPropPermission("Estudiantes") && (
                <Link
                    className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                    to="/"
                >
                    <div
                        className={
                            entityType === 6
                                ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                                : "d-flex align-middle w-100 py-3 btn-menu rounded"
                        }
                        onClick={() => setEntityType(6)}
                    >
                        <img
                            src={__webpack_public_path__ + "img/icon-user.svg"}
                            className="icon-navbar ml-2"
                            alt="estudiante"
                        />
                        <div className="pl-1">Estudiantes</div>
                    </div>
                </Link>
            )}
            <Link
                className="nav-link align-text-bottom p-0 w-100 py-0 btn-menu rounded"
                to="/Ayuda"
            >
                <div
                    className={
                        entityType === 7
                            ? "d-flex align-middle w-100 py-3 btn-menu bg-active-white rounded"
                            : "d-flex align-middle w-100 py-3 btn-menu rounded"
                    }
                    onClick={() => setEntityType(7)}
                >
                    <img
                        src={__webpack_public_path__ + "img/icon-help.svg"}
                        className="icon-navbar ml-2"
                        alt="faq"
                    />
                    <div className="pl-1">FAQ</div>
                </div>
            </Link>
            <Link
                className="nav-link align-text-bottom p-0 w-100 py-3 btn-menu rounded"
                to="#bannerformmodal"
                data-toggle="modal"
                data-target="#exampleModal"
            >
                <div
                    className="d-flex align-middle"
                    style={{ color: "#726b62 !important" }}
                >
                    <img
                        src={__webpack_public_path__ + "img/icon-exit.svg"}
                        className="icon-navbar ml-2"
                        alt="salir"
                    />
                    <div className="pl-1">Cerrar sesión</div>
                </div>
            </Link>
        </nav>
    );
};

export default _MainMenu;
