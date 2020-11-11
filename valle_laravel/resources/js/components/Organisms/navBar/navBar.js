import React, { useState, useEffect } from 'react';

import { NavLink, Link } from 'react-router-dom'


const NavBar = ({ user, permissions, isHovering }) => {
    const [isHoveringDeparment, setIsHoveringDeparment] = useState(false)

    function getPermissionToPropPermission(namePermission) {
        // Find Permission
        let permissionExist = permissions.find(element => isPermission(element, namePermission));

        if (permissionExist == undefined) {
            return false
        } else {
            return true
        }
    }

    function isPermission(element, namePermission) {
        return element.name === namePermission;
    }

    function handleMouseHover() {
        setIsHoveringDeparment(!isHoveringDeparment)
    }

    return (
        <nav className="navbar content-Bar">
            <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/home">
                <div className='d-flex align-middle'>
                    <img src={__webpack_public_path__ + "img/icon-home.svg"} className="icon-navbar" alt="inicio" />
                    <div className='pl-1'>Introducción</div>
                </div>
            </NavLink>
            {
                getPermissionToPropPermission("Simat") &&
                <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/SubirExcel">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-upload.svg"} className="icon-navbar" alt="cargar" />
                        <div className='pl-1'>Carga de Simat</div>
                    </div>
                </NavLink>
            }

            {
                getPermissionToPropPermission("Creación de usuarios") &&
                <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Usuarios">
                    <div className='d-flex'>
                        <img src={__webpack_public_path__ + "img/icon-student.svg"} className="icon-navbar" alt="usuario" />
                        <div className='pl-1'>Usuarios</div>
                    </div>
                </NavLink>
            }

            {
                getPermissionToPropPermission("Creación de roles") &&

                <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Roles">
                    <div className='d-flex'>
                        <img src={__webpack_public_path__ + "img/icon-tag.svg"} className="icon-navbar" alt="Roles" />
                        <div className='pl-1'>Roles</div>
                    </div>
                </NavLink>
            }




            {
                getPermissionToPropPermission("Departamentos") &&

                <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/Departamentos">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-map.svg"} className="icon-navbar" alt="mapa" />
                        <div className='pl-1'>Departamentos</div>
                    </div>
                </NavLink>
            }

            {
                getPermissionToPropPermission("Municipios") &&
                <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/Municipios">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-montain.svg"} className="icon-navbar" alt="montaña" />
                        <div className='pl-1'>Municipios</div>
                    </div>
                </NavLink>

            }

            {
                getPermissionToPropPermission("Instituciones") &&
                <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/Instituciones">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-school.svg"} className="icon-navbar" alt="institucion" />
                        <div className='pl-1'>Instituciones</div>
                    </div>
                </NavLink>

            }

            {
                getPermissionToPropPermission("Sedes") &&
                <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/Sedes">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-grade.svg"} className="icon-navbar" alt="birrete" />
                        <div className='pl-1'>Sedes</div>
                    </div>
                </NavLink>

            }

            {
                getPermissionToPropPermission("Grupos") &&
                <NavLink className="nav-link align-text-bottom" activeClassName="activate-navbar" to="/si/Grupos">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-users.svg"} className="icon-navbar" alt="grupo de personas" />
                        <div className='pl-1'>Grupos</div>
                    </div>
                </NavLink>

            }

            {
                getPermissionToPropPermission("Estudiantes") &&
                <NavLink className="nav-link align-text-bottom mb-5" activeClassName="activate-navbar" to="/si/Estudiantes">
                    <div className='d-flex align-middle'>
                        <img src={__webpack_public_path__ + "img/icon-user.svg"} className="icon-navbar" alt="estudiante" />
                        <div className='pl-1'>Estudiantes</div>
                    </div>
                </NavLink>

            }



            <NavLink className="nav-link align-text-bottom mb-5" activeClassName="activate-navbar" to="/si/Ayuda">
                <div className='d-flex align-middle'>
                    <img src={__webpack_public_path__ + "img/icon-help.svg"} className="icon-navbar" alt="faq" />
                    <div className='pl-1'>FAQ</div>
                </div>
            </NavLink>
            <Link className="nav-link align-text-bottom" to="#bannerformmodal" data-toggle="modal" data-target="#exampleModal" >
                <div className='d-flex align-middle'>
                    <img src={__webpack_public_path__ + "img/icon-exit.svg"} className="icon-navbar" alt="salir" />
                    <div className='pl-1'>Cerrar sesión</div>
                </div>
            </Link>
            {/* <a >
                <div className='d-flex align-middle'>
                    <i className="fas fa-question-circle"></i>
                    <div className='pl-1'>Cerrar sesión</div>
                </div>
            </a> */}
        </nav>
    )
}

export default NavBar;


{/* <nav className="nav flex-column"> */ }
{/* {user} */ }
{/* <NavLink className="nav-link content-Bar" activeClassName="activate-navbar" to="/si/home">
        <div className='d-flex'>
            <i className="fas fa-home"></i> {isHovering ? <div className='pl-1'>{" "}Introducción</div> : null}
            {/* <i className="fas fa-home"></i><div className={'pl-1 '+ (isHovering?'sidenav-nothovered':'sidenav-hovered' )}>Introducción</div> */}
// </div>
// </NavLink>

{/* <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Usuarios">
        <div className='d-flex'>
            <i className="fas fa-user"></i> {isHovering ? <div>Usuarios</div> : null}
        </div>
    </NavLink>

    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Roles">
        <div className='d-flex'>
            <i className="fas fa-user-tag"></i> {isHovering ? <div>Roles</div> : null}
        </div>
    </NavLink>
    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/SubirExcel">
        <div className='d-flex'>
            <i className="fas fa-upload"></i>  {isHovering ? <div>Subir xlms</div> : null}
        </div>
    </NavLink> */}

{/* <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Departamentos" onMouseEnter={handleMouseHover} onMouseLeave={handleMouseHover}>
        <div className='d-flex'>
            <i className="fas fa-map"></i> {isHovering ? <div className='pl-1'>{" "}Departamentos</div> : null}
        </div>
    </NavLink>

    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Municipios">
        <div className='d-flex'>
            <i className="fas fa-mountain"></i> {isHovering ? <div className='pl-1'>{" "}Municipios</div> : null}
        </div>
    </NavLink>

    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Instituciones">
        <div className='d-flex'>
            <i className="fas fa-school"></i> {isHovering ? <div className='pl-1'>{" "}Instituciones</div> : null}
        </div>
    </NavLink>

    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Sedes">
        <div className='d-flex'>
            <i className="fas fa-graduation-cap"></i> {isHovering ? <div className='pl-1'>{" "}Sedes</div> : null}
        </div>
    </NavLink>

    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Grupos">
        <div className='d-flex'>
            <i className="fas fa-users"></i> {isHovering ? <div className='pl-1'>{" "}Grupos</div> : null}
        </div>
    </NavLink>

    <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Estudiantes">
        <div className='d-flex'>
            <i className="fas fa-id-badge"></i> {isHovering ? <div className='pl-1'>{" "}Estudiantes</div> : null}
        </div>
    </NavLink> */}

{/* {
    getPermissionToArray("Departamentos") ?
        <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Departamentos">
            <i className="fas fa-map"></i>
        </NavLink>
        : null
}
{
    getPermissionToArray("Municipios") ?
        <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Municipios">
            <i className="fas fa-mountain"></i>
        </NavLink>
        : null
}
{
    getPermissionToArray("Instituciones") ?
        <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Instituciones">
            <i className="fas fa-school"></i>
        </NavLink>
        : null
}
{
    getPermissionToArray("Sedes") ?
        <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Sedes">
            <i className="fas fa-graduation-cap"></i>
        </NavLink>
        : null
}
{
    getPermissionToArray("Grupos") ?
        <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Grupos">
            <i className="fas fa-users"></i>
        </NavLink>
        : null
}
{
    getPermissionToArray("Estudiantes") ?
        <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Estudiantes">
            <i className="fas fa-id-badge"></i>
        </NavLink>
        : null
} */}

{/* <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Estadisticas">
    <i className="fas fa-chart-bar"></i>
</NavLink>
<NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Informes">
    <i className="fas fa-file-alt"></i>
</NavLink> */}
{/* <NavLink className="nav-link" activeClassName="activate-navbar" to="/si/Ayuda">
        <div className='d-flex'>
            <i className="fas fa-question-circle"></i> {isHovering ? <div className='pl-1'>{" "}FAQ</div> : null}
        </div>
    </NavLink>
    <button type="button" className="btn btn-logout" data-toggle="modal" data-target="#exampleModal">
        <div className='d-flex'>
            <i className="fas fa-sign-out-alt"></i> {isHovering ? <div className='pl-1'>{" "}Cerrar sesión</div> : null}
        </div>
    </button> */}
// </nav>
