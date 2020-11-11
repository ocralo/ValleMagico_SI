import React, { useState, useEffect, useContext } from "react";

import _EntityDetailMenu from "./_entityDetailMenu/_entityDetailMenu";
import _EntityIndicators from "./_entityIndicators/_entityIndicators";
import _EntityDetailContent from "./_entityDetailContent/_entityDetailContent";
import _EntityChildren from "./_entityChildren/_entityChildren";

import _ButtonGenerateInform from "./../../../Atoms/_buttonGenerateInform";

import {
    EntityContext,
    EntityTypeContext,
    EntityGraphContext
} from "../_context/_context";
import { ApiLevel, StringLevel } from "../_constants/_constants";

const _EntityInformationPage = () => {
    const [currentView, setCurrentView] = useState(0);
    const [graphs, setGraphs] = useState([]);
    const [totalChildsWhoPlayed, setTotalChildsWhoPlayed] = useState(0);
    const [totalChilds, setTotalChilds] = useState(0);

    const { currentEntity } = useContext(EntityContext);
    const { entityType, setEntityType } = useContext(EntityTypeContext);

    useEffect(() => {
        setGraphs([]);
    }, [currentView, currentEntity]);

    return (
        <EntityGraphContext.Provider value={{ graphs, setGraphs }}>
            <div className="col-md-12 col-sm-12 col-lg-12  m-0">
                <div className="container-fluid">
                    <_EntityDetailMenu
                        currentView={currentView}
                        setCurrentView={setCurrentView}
                    />
                    <h3 className="my-4">
                        <b>
                            {StringLevel[entityType].singular
                                .charAt(0)
                                .toUpperCase() +
                                StringLevel[entityType].singular.slice(1)}
                            :{" "}
                        </b>
                        {currentEntity.name}
                    </h3>
                    {currentView != 4 && (
                        <_EntityIndicators
                            totalChildsWhoPlayed={totalChildsWhoPlayed}
                            totalChilds={totalChilds}
                            currentView={currentView}
                        />
                    )}
                    <_EntityDetailContent currentView={currentView} />
                    <_EntityChildren
                        setTotalChildsWhoPlayed={setTotalChildsWhoPlayed}
                        setTotalChilds={setTotalChilds}
                        setCurrentView={setCurrentView}
                    />
                    <_ButtonGenerateInform currentView={currentView} />
                </div>
            </div>
        </EntityGraphContext.Provider>
    );
};

export default _EntityInformationPage;
