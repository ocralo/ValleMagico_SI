import React, { useState, useLayoutEffect, useEffect } from 'react'
import CheckButton from '../Atoms/checkButton'
import { useRouteMatch } from 'react-router-dom';

const GroupChecked = ({ title, infoGroupCheckBox, idForCheckedInfo, checkedButtons, Action, isDisabled, initialValues, isCancel, changeStateCancel, isCreate }) => {
    const { params, url } = useRouteMatch();


    const [checkedFiles, setCheckedFiles] = useState([])
    const [dataForInput, setDataForInput] = useState([])
    const [disabledButton, setDisabledButton] = useState(false)


    useEffect(() => {
        if (checkedButtons != null) {
            checkedButtons(checkedFiles)
            setDisabledButton(false)
        } else {
            setDisabledButton(true)
        }
    }, [checkedFiles])

    // add option checked and find if exist or no into infoGroupCheckbox
    useEffect(() => {
        // console.log("TCL: GroupChecked -> idForCheckedInfo", idForCheckedInfo)
        // console.log("TCL: GroupChecked -> infoGroupCheckBox", infoGroupCheckBox)
        if (infoGroupCheckBox != undefined && idForCheckedInfo != undefined) {
            addOptionChecked(infoGroupCheckBox, idForCheckedInfo)
        }
    }, [idForCheckedInfo, infoGroupCheckBox])


    useLayoutEffect(() => {
        if (isCancel) {
            // console.log("TCL: GroupChecked -> isCancel", isCancel)
            addOptionChecked(infoGroupCheckBox, initialValues)
            changeStateCancel()
        }
    }, [isCancel])

    function addOptionChecked(allData, dataForCheck) {
        // console.log("TCL: addOptionChecked -> dataForCheck", dataForCheck)
        // console.log("TCL: addOptionChecked -> allData", allData)

        let auxInfoGroupCheckbox = allData
        let AuxDataForInput = []
        auxInfoGroupCheckbox.map(
            item => {
                let checkBoxExist = dataForCheck.find(itemCheck =>
                    itemCheck.id === item.id);
                // console.log("TCL: addOptionChecked -> checkBoxExist", checkBoxExist)

                if (checkBoxExist == undefined) {
                    AuxDataForInput.push({
                        id: `${item.id}-${item.name}-${Action}`,
                        name: item.name,
                        desc: item.desc,
                        checked: false
                    })
                } else {
                    AuxDataForInput.push({
                        id: `${item.id}-${item.name}-${Action}`,
                        name: item.name,
                        desc: item.desc,
                        checked: true
                    })
                }
                setDataForInput(AuxDataForInput)
            }
        )
    }

    function handleChecked(e) {
        let clicketId = e.target.id.split('-')[0]

        const index = dataForInput.findIndex(dataArray =>
            Number.parseInt(dataArray.id.split('-')[0]) === Number.parseInt(clicketId))

        let arrayData = [...dataForInput]
        if (index >= 0) {
            arrayData[index].checked = e.target.checked
            setDataForInput(arrayData)
        }
        getIdPermisison(arrayData)

    }

    function getIdPermisison(arrayData) {
        let idPermisisons = [];
        arrayData.map(
            item => {
                if (item.checked) {
                    idPermisisons.push({
                        id: Number.parseInt(item.id.split('-')[0])
                    })
                }
            }
        )
        checkedButtons(idPermisisons)
    }

    return (
        <div className='col-md-12 justify-content-center'>
            <div>
                <div className=' title-group col-md-12 text-center mt-2 mb-2'>
                    {title}
                </div>
                <div className='col-md-12 d-flex justify-content-center '>
                    <div>
                        {
                            dataForInput.map(
                                (data, i) =>
                                    <div key={i} className="custom-control custom-checkbox">
                                        <input type="checkbox" className="custom-control-input"
                                            id={data.id}
                                            onChange={handleChecked}
                                            checked={data.checked}
                                            disabled={isDisabled} />
                                        <label className="label-group custom-control-label" htmlFor={data.id}>{data.name} - {data.desc}</label>
                                    </div>
                            )
                        }
                    </div>
                </div>
            </div>

        </div>
    )
}
export default GroupChecked

/* <CheckButton key={i} id={data.id} name={data.name} desc={data.desc} isChecked={isChecked} disabled={isDisabled} Action={Action} checkedInput={data.checked} /> */