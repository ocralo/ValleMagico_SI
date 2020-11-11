import React, { useState, useEffect } from 'react'

import { NavLink as a, useRouteMatch } from 'react-router-dom';


const ButtonTab = ({ id, selectedButton, changeActivateButton }) => {

    const [isActivate, setisActivate] = useState(false)


    useEffect(() => {
        if (id == selectedButton) {
            setisActivate(true)
        } else {
            setisActivate(false)
        }
    }, [selectedButton])

    function handleClick() {
        changeActivateButton(id)
    }

    return (
        <button id={id} className={(isActivate ? ' tabs-selected activeTabs btn btn-link hover-2' : 'tabs-selected hover-2 btn btn-link')} onClick={handleClick}>
            {id}
        </button>
    )

}

export default ButtonTab;

/* <NavLink id={id} className="tabs-selected hover-2"
            activeClassName="activeTabs"
            to={`#${id}`} exact>
            {id}
        </NavLink> */