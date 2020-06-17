import React, { useState , useEffect } from 'react'

const RadioButton = ({ data , checkButtonSelected, disabled, Action, idChecked }) => {
    const [isActivate, setIsActivate] = useState()

    function handleClick() {
        // setIsActivate(!isActivate)
        checkButtonSelected( data.id ,data.slug_permission)
    }

useEffect(() => {
    console.log("TCL: RadioButton -> `${idChecked}-${Action}`", `${idChecked}-${Action}`)
}, [data])

    return (
        <div className="custom-control custom-radio">
            <input type="radio" className="label-group custom-control-input" id={data.id} name={Action} checked={data.id === `${idChecked}-${Action}`  } onClick={handleClick} disabled={disabled} />
            <label name={act} className="custom-control-label" htmlFor={data.id}>{data.name}</label>
        </div>
    )
}
export default RadioButton