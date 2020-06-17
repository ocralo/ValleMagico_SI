import React, { useState, useEffect } from 'react';

import { useRouteMatch, NavLink, Link } from 'react-router-dom'


const SelectListMovil = (props) => {
    const { url } = useRouteMatch();
    const [textButton, setTextButton] = useState('Inteligencias Multiples')

    function handleClick(e) {
        setTextButton(e.target.textContent)
    }

    return (
        <div className="selectListMovil list-tabs d-block d-lg-none col-12" >
            <div className="dropdown">
                <button className="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {textButton}
                </button>
                <div className="dropdown-menu px-2" aria-labelledby="dropdownMenuButton">
                    {
                        props.namesTabs.map(
                            (navTabs, i) =>
                                <div key={i}>
                                    <NavLink key={i} className="tabs-selected hover-2" onClick={handleClick} activeClassName="active" to={`${url}/${navTabs.route}`}>
                                        {navTabs.name}
                                    </NavLink>
                                </div>
                        )
                    }
                </div>
            </div>


        </div>
    )
}

export default SelectListMovil;