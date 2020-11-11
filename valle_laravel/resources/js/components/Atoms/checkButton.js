import React, { useEffect, useState } from "react";

const CheckButton = ({
    id,
    name,
    desc,
    isChecked,
    disabled,
    Action,
    checkedInput
}) => {
    const [checked, setchecked] = useState();

    function handleChecked(e) {
        //console.log("TCL: handleChecked -> checked", checked)
        isChecked(e);
    }

    return (
        <div className="custom-control custom-checkbox">
            <input
                type="checkbox"
                className="custom-control-input"
                id={`${id}-${name}-${Action}`}
                onChange={handleChecked}
                checked={checkedInput}
                disabled={disabled}
            />
            <label
                className="label-group custom-control-label"
                htmlFor={`${id}-${name}-${Action}`}
            >
                {name} - {desc}
            </label>
        </div>
    );
};
export default CheckButton;
