import React from 'react'
import { Switch, Route, useRouteMatch } from 'react-router-dom'
import ContentSelectedListRole from './contentSelectedListRole';
import SelectedView from '../selectedView/selectedView';


const ContentPageRoles = ({messageSelectedView , infoPermissions }) => {
    const { url } = useRouteMatch();

    return( 
        <Switch>
        <Route exact path={`${url}`}>
            <SelectedView text={messageSelectedView} />
        </Route>
        <Route path={`${url}/:idForFetch`}>
            <ContentSelectedListRole infoPermissions = {infoPermissions} />
        </Route>
    </Switch>
    )
}
export default ContentPageRoles