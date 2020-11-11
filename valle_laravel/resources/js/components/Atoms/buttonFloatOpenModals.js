import React, { useState } from 'react'
import GroupRadioButtons from '../Molecules/groupradioButtons'
import GroupChecked from '../Molecules/groupChecked'

const ButtonFloatOpenModals = ({idModal}) => {


    return (
        <div>
            <button type="button" className="float d-flex justify-content-center align-items-center" data-toggle="modal" data-target={`#${idModal}`}>
                <i className="fas fa-plus"></i>
            </button>
        </div>
    )
}

export default ButtonFloatOpenModals;