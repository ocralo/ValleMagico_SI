import React from 'react'
import { NavLink, useRouteMatch } from 'react-router-dom';

const ItemResult = ({ name, itemid }) => {
    const { path } = useRouteMatch();

    return (
        <div>
            <NavLink to={`${path}/${itemid}`} className='item-result d-flex align-items-center justify-content-between'
            name={name}
            activeClassName="selected-item">
                {name}
            <i className="fas fa-angle-right"></i>
            </NavLink>
        </div>
    )
}

export default ItemResult;