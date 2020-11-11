import React from 'react';

import { useRouteMatch, NavLink } from 'react-router-dom'


const TabsContentSelectedList = (props) => {
    const { url } = useRouteMatch();

    return (
        <div className="list-tabs d-none d-lg-flex justify-content-around row pt-3" >
            {
                props.namesTabs.map(
                    (navTabs, i) =>
                        <div key={i} >
                            {
                                navTabs.activate ?
                                    <NavLink className="tabs-selected" activeClassName="activeTabs" to={`${url}/${navTabs.route}`}>
                                        {navTabs.name}
                                    </NavLink>
                                    :
                                    <div className='desactivate-nav'>{navTabs.name} </div>
                        }
                        </div>
                )
            }
        </div>
    )
}

export default TabsContentSelectedList;