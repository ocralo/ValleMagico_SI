import React from 'react'

const EditButton = ({ iconButton , EventHandleClick}) => {


    function handleClick(e) {
        EventHandleClick()
    }
    return (
        <button type="button" className="btn btn-edit d-flex justify-content-center align-items-center" onClick={handleClick}>
            <i className={`fas fa-${iconButton}`}></i>
        </button>
    )
}
export default EditButton