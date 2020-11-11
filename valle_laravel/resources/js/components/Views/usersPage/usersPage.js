import React, { useState, useEffect } from 'react'
import ListSearch from '../../Organisms/listSearch/listSearch'
import ContentPageUsers from './contentPageUsers'
import ModalFloatButtons from '../../Organisms/modalFloatButtons/modalFloatButtons'
import ButtonFloatOpenModals from '../../Atoms/buttonFloatOpenModals'
import { fetchApi } from '../../../function/GlobalFunctions';
import LoadingPage from '../loadingPage/loadingPage'


const UsersPage = ({ infoUsers, infoRols, isHovering, Allinfo }) => {

    const [isLoadedRole, setisLoadedRole] = useState(true);
    const [error, setError] = useState(null);
    const [jsonRoles, setJsonRoles] = useState([]);
    const [jsonPermissions, setJsonPermissions] = useState([]);
    const userData = {
        'name': '',
        'email': '',
        'username': '',
        'role': []
    }

    const [infoLocation, setinfoLocation] = useState()

    const [jsonUsers, setjsonUsers] = useState([])

    //  vars to gobal text to ListSearche and LoadPage
    const titleListSearch = 'Usuarios'
    const placeHolder = 'Ingrese el usuario'
    const messageSelectedView = 'Selecciona un usuario'

    const routeForFetchListSearch = `${process.env.OPEN_VALLE_MAGICO_URL}users/all`

    async function fetchRoles() {
        try {
            let result = await fetchApi(`${process.env.OPEN_VALLE_MAGICO_URL}roles/all`)
            setJsonRoles(result)
            setisLoadedRole(false)
        } catch (error) {
            setisLoadedRole(true)
            setError(error)
        }
    }


    useEffect(() => {
        setjsonUsers(infoUsers)
        setJsonRoles(infoRols)
    }, [infoUsers, infoRols])


    useEffect(() => {
        setinfoLocation(Allinfo)
    }, [Allinfo])

    return (
        <div className='contentDepartment row h-100'>
            <ListSearch tittle={titleListSearch} placeHolder={placeHolder} isInput={true} isData={true} infoForSelectList={jsonUsers} isHovering={isHovering} />
            <ContentPageUsers
                messageSelectedView={messageSelectedView}
                roles={jsonRoles}
                infoLocation={infoLocation}
            />
            <ButtonFloatOpenModals idModal={"ModalCreateUser"} />
            <ModalFloatButtons
                idModal={"ModalCreateUser"}
                title={'Crear un nuevo Usuario'}
                textButton={'Crear Usuario'}
                userData={userData}
                roles={jsonRoles}
                urlFetch={`${process.env.OPEN_VALLE_MAGICO_URL}createUser`}
                typeFetch={'POST'}
                isCreateUser={true}
                infoLocation={infoLocation}
            />
        </div>
    )
}
export default UsersPage
