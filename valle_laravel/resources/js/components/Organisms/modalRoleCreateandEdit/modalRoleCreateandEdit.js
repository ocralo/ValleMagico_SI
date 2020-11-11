import React, { useState } from 'react'
import { Formik, Form, Field, ErrorMessage } from 'formik';
import * as Yup from 'yup';

import { fetchPOST } from '../../../function/GlobalFunctions'
import GroupChecked from '../../Molecules/groupChecked';

const ModalRoleCreateandEdit = ({ idModal, title, textButton, roleData, urlFetch, typeFetch, groupPermissions }) => {
    const [role, setRole] = useState(roleData)
    const [disableButton, setdisableButton] = useState(true)
    return (
        <div>
            <div className="modal fade" id={idModal} tabIndex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div className="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5 className="modal-title" id="exampleModalLongTitle">{title}</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <Formik
                                initialValues={role}
                                validationSchema={Yup.object().shape({
                                    name: Yup.string().max(45, 'El nombre debe ser maximo de 45 caracteres')
                                        .required('La ruta es obligatoria'),
                                    desc: Yup.string().max(45, 'La descripción debe ser maximo de 45 caracteres')
                                        .required('La descripción es obligatoria'),

                                })}
                                onSubmit={fields => {
                                    // console.log("TCL: ModalRoleCreateandEdit -> fields", fields)

                                    const newRole = {
                                        name: fields.name,
                                        desc: fields.desc,
                                        permissions: []
                                    }

                                    role.permissions.map(
                                        item => newRole.permissions.push(item.id)
                                    )
                                    // console.log("TCL: ModalRoleCreateandEdit -> newRole", newRole)

                                    async function fetchPOSTDATA() {
                                        try {
                                            const data = await fetchPOST(`${urlFetch}`, newRole, "POST")
                                            // console.log("TCL: fetchPOSTDATA -> data", data)

                                        } catch (error) {
                                            console.warn(error)
                                        }
                                    }

                                    fetchPOSTDATA()

                                }}
                                render={({ errors, status, touched }) => {

                                    function getPermissions1(e) {
                                    // console.log("TCL: ModalRoleCreateandEdit -> e", e)
                                        
                                        if (e.length > 0) {
                                            let auxJsonApi = role
                                            auxJsonApi.permissions = e
                                            setRole({ ...role, permissions: e })
                                        }
                                        if( role.permissions.length > 0 ){
                                            setdisableButton(false)
                                        }else{
                                            setdisableButton(true)
                                        }
                                    }

                                    return (
                                        <Form>
                                            <div className="form-group">
                                                <label htmlFor="name">Nombre del rol</label>
                                                <Field name="name" type="text" className={'form-control' + (errors.name && touched.name ? ' is-invalid' : '')} placeholder="Escribir el nombre del rol" />
                                                <ErrorMessage name="name" component="div" className="invalid-feedback" />
                                            </div>
                                            <div className="form-group">
                                                <label htmlFor="desc">Descripción</label>
                                                <Field name="desc" type="text" className={'form-control' + (errors.desc && touched.desc ? ' is-invalid' : '')} placeholder="Descrición breve del rol" />
                                                <ErrorMessage name="desc" component="div" className="invalid-feedback" />
                                            </div>
                                            <div className="form-group">
                                                <GroupChecked title={'Permisos'} 
                                                    infoGroupCheckBox={groupPermissions}
                                                    idForCheckedInfo={role.permissions}
                                                    checkedButtons={getPermissions1}
                                                    isCreate={true}
                                                    Action={'Create'} />
                                            </div>


                                            <div className="modal-footer">

                                                <button type="reset" className="btn btn-cancel" data-dismiss="modal"> Cancelar </button>
                                                <button type="submit" className="btn btn-save mr-2" disabled={disableButton} >{textButton}</button>

                                            </div>

                                        </Form>
                                    )

                                }}
                            />

                        </div>

                    </div>
                </div>
            </div>
        </div>
    )
}

export default ModalRoleCreateandEdit