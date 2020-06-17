import React from 'react'

const TittleTab = ({ tittle, nameItemClicked }) => {
    return (
        <div className="row col">
            <label className="tittle-tab col-12">
                {tittle} {nameItemClicked}
            </label>
        </div>
    )
}

export default TittleTab;