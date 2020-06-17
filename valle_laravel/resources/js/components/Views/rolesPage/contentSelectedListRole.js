import React, { useState, useEffect } from 'react'
import ModalRoleCreateandEdit from '../../Organisms/modalRoleCreateandEdit/modalRoleCreateandEdit'
import EditButton from '../../Atoms/EditButton'
import DescUser from '../../Molecules/descUser'
import TittleTab from '../../Atoms/tittleTab'
import LoadingPage from '../loadingPage/loadingPage'
import { useRouteMatch } from 'react-router-dom';
import { fetchApi } from '../../../function/GlobalFunctions';
import { fetchPOST } from '../../../function/GlobalFunctions';
import GroupChecked from '../../Molecules/groupChecked'
import ModalDelete from '../../Organisms/modalDelete/modalDelete'

import { Formik, Form, Field, ErrorMessage } from 'formik';
import * as Yup from 'yup';


const ContentSelectedListRole = ({ infoPermissions }) => {
    const { params, url } = useRouteMatch();
    const [isLoaded, setisLoaded] = useState(true);
    const [jsonApi, setJsonApi] = useState();
    const [error, setError] = useState(null);
    const [initialPermissions, setinitialPermissions] = useState([])


    const [isDisabled, setisDisabled] = useState(true)
    const [isCancel, setisCancel] = useState(false)

    const [permissions, setpermissions] = useState()

    const [permissionInitial, setpermissionInitial] = useState([])


    const urlFetch = `${process.env.OPEN_VALLE_MAGICO_URL}updateRole/${params.idForFetch}`
    useEffect(() => {
        setpermissions(infoPermissions)
    }, [infoPermissions])


    async function fetchData() {
        try {
            let result = await fetchApi(`${process.env.OPEN_VALLE_MAGICO_URL}getRole/${params.idForFetch}`)
            setJsonApi(result)
            setpermissionInitial(result.permissions)
            // addOptionCheckedIntoPermissions(result)
            setisLoaded(false)

        } catch (error) {
            setisLoaded(true)
            console.warn(error)
            setError(error)
        }
    }

    function addOptionCheckedIntoPermissions(result) {
        let auxAllPermission = permissions;
        auxAllPermission.map(
            item => {
                let permission = result.permissions.find(permission =>
                    permission.id === item.id);

                if (permission == undefined) {
                    item.checked = false
                } else {
                    item.checked = true
                }
            }
        )

        setinitialPermissions(auxAllPermission)
        setpermissions(auxAllPermission)
    }

    function handleClickEdit() {
        setisDisabled(!isDisabled)
    }

    function changeStateCancel() {
        setisCancel(!isCancel)
    }


    useEffect(() => {
        setisLoaded(true)
        fetchData();
    }, [params.idForFetch])

    if (isLoaded) {
        return (<LoadingPage />)
    } else {
        return (
            <div className='col-6 container container-roles-page'>
                <div className='card ' >
                    <div className='d-flex justify-content-between mt-1 mb-1'>
                        <TittleTab tittle={'Información del Rol'} />

                        {
                            isDisabled == true &&
                            <div className='d-flex'>
                                <EditButton iconButton={'edit'} EventHandleClick={handleClickEdit} />
                                {/* <EditButton idModal={"ModalDelete"} iconButton={'trash'} /> */}
                                <button type="button" className="btn btn-edit d-flex justify-content-center align-items-center" data-toggle="modal" data-target="#ModalDelete" >
                                    <i className={`fas fa-trash`}></i>
                                </button>
                            </div>
                        }
                        {/* <ModalRoleCreateandEdit idModal={"ModalEditRole"} title={'Editar Role'} textButton={'Guardar cambios'} roleData={jsonApi} urlFetch={`http://127.0.0.1:8000/updateRole/${jsonApi.id}`} permissions={permissions} typeFetch={'PUT'} addExtentionIdChecked={'Edit'} /> */}
                        <ModalDelete modalId={'ModalDelete'} title={'Eliminar rol'} textBody={'Seguro quiere eliminar este Rol'} urlFetch={`${process.env.OPEN_VALLE_MAGICO_URL}deleteRole`} element={jsonApi} />
                    </div>

                    <Formik
                        initialValues={jsonApi}
                        enableReinitialize={true}
                        validationSchema={Yup.object().shape({
                            name: Yup.string().max(45, 'El nombre debe ser maximo de 45 caracteres')
                                .required('El nombre del rol es obligatorio'),
                            desc: Yup.string().max(45, 'La descripción debe ser maximo de 45 caracteres')
                                .required('La descripción es obligatoria'),

                        })}
                        onSubmit={fields => {

                            const a = {
                                name: fields.name,
                                desc: fields.desc,
                                permissions: [],
                            }

                            fields.permissions.map(
                                item => a.permissions.push(item.id)
                            )



                            async function fetchPOSTDATA() {
                                try {
                                    const data = await fetchPOST(`${urlFetch}`, a, "PUT")
                                } catch (error) {
                                    console.warn(error)
                                }
                            }

                            fetchPOSTDATA()
                            handleClickEdit()
                        }}

                        onReset={(initialValues, { resetForm }) => {
                            resetForm(initialValues)
                            changeStateCancel()
                            handleClickEdit()
                        }

                        }

                        render={({ errors, status, touched }) => {


                            function getPermissions(e) {
                                if (e.length > 0) {
                                    let auxJsonApi = jsonApi
                                    auxJsonApi.permissions = e
                                    setJsonApi({ ...jsonApi, permissions: e })

                                }

                            }


                            return (
                                <Form>
                                    <div className="form-group">
                                        <label htmlFor="name">Nombre del rol</label>
                                        <Field name="name" type="text" className={'form-control' + (errors.name && touched.name ? ' is-invalid' : '')} placeholder="Escribir el nombre del rol" disabled={isDisabled} />
                                        <ErrorMessage name="name" component="div" className="invalid-feedback" />
                                    </div>
                                    <div className="form-group">
                                        <label htmlFor="desc">Descripción</label>
                                        <Field name="desc" type="text" className={'form-control' + (errors.desc && touched.desc ? ' is-invalid' : '')} placeholder="Descrición breve del rol" disabled={isDisabled} />
                                        <ErrorMessage name="desc" component="div" className="invalid-feedback" />
                                    </div>
                                    <div className="form-group">
                                        <GroupChecked
                                            title={'Permisos'}
                                            infoGroupCheckBox={permissions}
                                            idForCheckedInfo={jsonApi.permissions}
                                            initialValues={permissionInitial}
                                            checkedButtons={getPermissions}
                                            isDisabled={isDisabled}
                                            Action={'Edit'}
                                            isCancel={isCancel}
                                            isCreate={false}
                                            changeStateCancel={changeStateCancel} />
                                    </div>

                                    {
                                        isDisabled == false &&
                                        <div className="modal-footer">

                                            <button type='reset' className="btn btn-cancel" >Cancelar</button>
                                            <button type="submit" className="btn btn-save mr-2" >Guardar Cambios</button>

                                        </div>
                                    }

                                </Form>
                            )

                        }}
                    />

                </div>

            </div>
        )
    }
}

export default ContentSelectedListRole
