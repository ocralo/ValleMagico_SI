import React, { useState, useEffect } from 'react'
import GroupRadioButtons from '../../Molecules/groupradioButtons'
import GroupChecked from '../../Molecules/groupChecked'
import { Formik, Form, Field, ErrorMessage } from 'formik';
import * as Yup from 'yup';
import LoadingPage from '../../Views/loadingPage/loadingPage';

import { fetchPOST } from '../../../function/GlobalFunctions'
import GroupCheckedBoxLocation from '../../Molecules/groupCheckedBoxForLocation';

const ModalFloatButtons = ({ idModal, title, textButton, userData, roles, urlFetch, typeFetch, isCreateUser, infoLocation }) => {
    const [isLoaded, setisLoaded] = useState(true);
    const [user, setUser] = useState(userData)
    const [validationSchema, setValidationSchema] = useState()

    const [slug_Permission, setslug_Permission] = useState(null)
    const [roleSelect, setroleSelect] = useState(null)


    const [locationUsers, setlocatinoUsers] = useState()


    const [LocationUserGrades, setuserHerarquyGrades] = useState([])

    const [isRoleAndPermissionSelected, setIsRoleAndPermissionSelected] = useState(false)

    const [checkedBox, setcheckedBox] = useState([])

    useEffect(() => {
        if (user.role != null) {
            setIsRoleAndPermissionSelected(true)
        }
    }, [user])

    useEffect(() => {
        if (isCreateUser) {
            setValidationSchema(
                Yup.object().shape({
                    name: Yup.string()
                        .required('El nombre es obligatorio'),
                    username: Yup.string()
                        .required('El nombre de usuario es obligatorio'),
                    email: Yup.string()
                        .email('El correo es invalido')
                        .required('El correo es obligatorio'),
                    password: Yup.string()
                        .min(8, 'La contraseña debe deten por lo menos 8 caracteres')
                        .required('La contraseña es obligatoria'),
                    confirmPassword: Yup.string()
                        .oneOf([Yup.ref('password'), null], 'La contraseña no es la misma')
                        .required('La confirmación de contraseña es obligatoria')
                })
            )
        } else {
            setValidationSchema(
                Yup.object().shape({
                    name: Yup.string()
                        .required('El nombre es obligatorio'),
                    username: Yup.string()
                        .required('El nombre de usuario es obligatorio'),
                    email: Yup.string()
                        .email('El correo es invalido')
                        .required('El correo es obligatorio')
                })
            )
        }
    }, [user])

    useEffect(() => {
        if (roles != undefined && userData != undefined) {
            setisLoaded(false)
        } else {
            setisLoaded(true)
        }
    }, [roles, userData])

    useEffect(() => {
        if (slug_Permission != undefined) {
            console.log("TCL: ModalFloatButtons -> infoLocation[slug_Permission]", infoLocation[slug_Permission])
            setlocatinoUsers(infoLocation[slug_Permission])
            setcheckedBox([])
        }
    }, [slug_Permission])

    if (isLoaded) {
        return (
            <LoadingPage />
        )
    } else {
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
                                    initialValues={user}


                                    validationSchema={validationSchema}

                                    onSubmit={fields => {


                                        async function fetchPOSTDATA() {
                                            console.log("TCL: ModalFloatButtons -> fields", fields)
                                            try {
                                                const data = await fetchPOST(`${urlFetch}`, fields, typeFetch)
                                            } catch (error) {
                                                console.warn(error)
                                            }
                                        }

                                        fields.role = Number.parseInt(roleSelect);

                                        if (slug_Permission == "hq_grades") {
                                            let auxLocationUserGrade = []
                                            checkedBox.map(
                                                item => {
                                                    let idGrade = item.split("-")
                                                    auxLocationUserGrade.push(idGrade[0], idGrade[1])
                                                }
                                            )
                                            setuserHerarquyGrades(auxLocationUserGrade)
                                            console.log("TCL: ModalFloatButtons -> auxLocationUserGrade", auxLocationUserGrade)
                                            fields.destiny_ids = [...auxLocationUserGrade]
                                        } else {
                                            fields.destiny_ids = [...checkedBox]
                                        }

                                        fetchPOSTDATA()

                                    }}

                                    onReset={(initialValues, { resetForm }) => {
                                        resetForm(initialValues)
                                    }}
                                    render={({ errors, status, touched }) => {

                                        function getIdandSlug_Permission(slug_perrmissionCheck, idRadioButton) {
                                            console.log("TCL: functiongetIdandSlug_Permission -> slug_perrmissionCheck , idRadioButton", slug_perrmissionCheck, idRadioButton)


                                            setroleSelect(Number.parseInt(idRadioButton))
                                            setUser({
                                                ...user,
                                                role: Number.parseInt(idRadioButton)
                                            })
                                            // console.log("TCL: functiongetIdandSlug_Permission -> idRadioButton", idRadioButton)
                                            setslug_Permission(slug_perrmissionCheck)
                                            // console.log("TCL: functiongetIdandSlug_Permission -> slug_perrmissionCheck", slug_perrmissionCheck)
                                        }

                                        function getIdChecked(idsCheckedButtons, existValue) {
                                            console.log("TCL: getIdChecked -> idsCheckedButtons", idsCheckedButtons)
                                            if (existValue) {
                                                setcheckedBox(checkedBox => [...checkedBox, idsCheckedButtons])
                                            } else {
                                                let auxCheckedBox = [...checkedBox]
                                                let index = auxCheckedBox.indexOf(idsCheckedButtons)
                                                let spliceCheckbox = auxCheckedBox.splice(index, 1)

                                                setcheckedBox(auxCheckedBox)
                                            }

                                        }

                                        return (
                                            <Form >
                                                <div className="form-group">
                                                    <label htmlFor="name">Nombre</label>
                                                    <Field name="name" type="text" className={'form-control' + (errors.name && touched.name ? ' is-invalid' : '')} placeholder="Escribir nombre" />
                                                    <ErrorMessage name="name" component="div" className="invalid-feedback" />
                                                </div>
                                                <div className="form-group">
                                                    <label htmlFor="username">Nombre de usuario</label>
                                                    <Field name="username" type="text" className={'form-control' + (errors.username && touched.username ? ' is-invalid' : '')} placeholder="Escribir nombre de usuario" />
                                                    <ErrorMessage name="username" component="div" className="invalid-feedback" />
                                                </div>
                                                <div className="form-group">
                                                    <label htmlFor="email">Correo electronico</label>
                                                    <Field name="email" type="text" className={'form-control' + (errors.email && touched.email ? ' is-invalid' : '')} placeholder="Escribir correo electronico" />
                                                    <ErrorMessage name="email" component="div" className="invalid-feedback" />
                                                </div>
                                                {
                                                    isCreateUser ?
                                                        <div className="form-group">
                                                            <label htmlFor="password">Contraseña</label>
                                                            <Field name="password" type="password" className={'form-control' + (errors.password && touched.password ? ' is-invalid' : '')} placeholder="Escribir la contraseña" />
                                                            <ErrorMessage name="password" component="div" className="invalid-feedback" />
                                                        </div>

                                                        :
                                                        null
                                                }
                                                {
                                                    isCreateUser ?
                                                        <div className="form-group">
                                                            <label htmlFor="confirmPassword">Confirmación de contraseña</label>
                                                            <Field name="confirmPassword" type="password" className={'form-control' + (errors.confirmPassword && touched.confirmPassword ? ' is-invalid' : '')} placeholder="Confirme la contraseña" />
                                                            <ErrorMessage name="confirmPassword" component="div" className="invalid-feedback" />
                                                        </div>
                                                        :
                                                        null
                                                }

                                                <div className="form-row d-flex">
                                                    <GroupRadioButtons
                                                        title={'Roles'}
                                                        dataArray={roles}
                                                        idRadioButtonChecked={roleSelect}
                                                        checkedButton={getIdandSlug_Permission} Action={'create'} />
                                                </div>

                                                <GroupCheckedBoxLocation
                                                    locationUsers={locationUsers}
                                                    checkedBox={checkedBox}
                                                    getIdChecked={getIdChecked}
                                                />

                                                <div className="form-group">

                                                </div>
                                                <div className="modal-footer">
                                                    <button type="reset" className="btn btn-cancel" data-dismiss="modal"> Cancelar </button>
                                                    <button type="submit" className="btn btn-save mr-2" disabled={false} >{textButton}</button>

                                                </div>

                                            </Form>
                                        )

                                    }
                                    }
                                />

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        )
    }


}
export default ModalFloatButtons