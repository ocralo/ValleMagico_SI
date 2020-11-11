import React, { useState, useEffect, useLayoutEffect } from "react";
import RadioButton from "../Atoms/radioButton";

const GroupRadioButtons = ({
    title,
    dataArray,
    checkedButton,
    idRadioButtonChecked,
    Action,
    isDisabled,
    initialValues,
    isCancel
}) => {
    const [disabledButton, setDisabledButton] = useState(false);

    const [dataForRadioButtons, setdataForRadioButtons] = useState([]);

    function handleOptionChange(slug_permission, event) {
        //console.log("TCL: handleOptionChange ->  slug_permission  , event", slug_permission, event.target.value)
        checkedButton(slug_permission, event.target.value);
    }

    useEffect(() => {
        const auxDataArray = [...dataArray];
        const auxDataforRadioButtons = [];
        auxDataArray.map(item => {
            auxDataforRadioButtons.push({
                ...item
            });
        });
        setdataForRadioButtons(auxDataforRadioButtons);
    }, [idRadioButtonChecked]);

    useLayoutEffect(() => {
        if (isCancel) {
            // checkedButton(slug_permission, event.target.value)
        }
    }, [isCancel]);

    return (
        <div className="col-md-12 justify-content-center">
            <div>
                <div className=" title-group col-md-12 text-center mt-2 mb-2">
                    {title}
                </div>
                <div className="col-md-12 d-flex justify-content-center">
                    <div>
                        {dataForRadioButtons.map((data, i) => (
                            <div
                                key={i}
                                className="custom-control custom-radio"
                            >
                                <label>
                                    <input
                                        type="radio"
                                        value={data.id}
                                        checked={
                                            idRadioButtonChecked === data.id
                                        }
                                        onChange={e =>
                                            handleOptionChange(
                                                data.slug_permission,
                                                e
                                            )
                                        }
                                        disabled={isDisabled}
                                    />
                                    {data.name}
                                </label>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
};

/* <RadioButton key={i} data={data} checkButtonSelected={checkButtonSelected} disabled={disabledButton} Action={Action} idChecked={idRadioButtonChecked} /> */
export default GroupRadioButtons;
