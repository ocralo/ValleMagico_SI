import React, { useState, useEffect, useContext } from "react";
import { EntityContext, EntityTypeContext } from "../../_context/_context";

import LoadingPage from "../../../../Views/loadingPage/loadingPage";

import { fetchApi } from "../../../../../function/GlobalFunctions";
import { ApiLevel, StringLevel } from "../../_constants/_constants";

const _EntityChildren = ({
    setTotalChildsWhoPlayed,
    setTotalChilds,
    setCurrentView
}) => {
    const [title, setTitle] = useState("");
    const [childs, setChilds] = useState([]);
    const [isLoading, setIsLoading] = useState(true);

    const { currentEntity } = useContext(EntityContext);
    const { entityType, setEntityType } = useContext(EntityTypeContext);

    useEffect(() => {
        if (entityType !== 6) {
            fetchBy();
            setTitle(
                StringLevel[entityType + 1].plural.charAt(0).toUpperCase() +
                    StringLevel[entityType + 1].plural.slice(1)
            );
        }
    }, [entityType, currentEntity]);

    const fetchBy = async () => {
        setIsLoading(true);
        const result = await fetchApi(
            `${ApiLevel[entityType].children}/${currentEntity.id}`
        );

        setChilds(result);
        setTotalChilds(result.length);
        setTotalChildsWhoPlayed(result.filter(r => r.total_played).length);
        setIsLoading(false);
    };

    return (
        <React.Fragment>
            {entityType < 6 && (
                <div className="card my-2">
                    <h4>{title}</h4>
                    <hr
                        style={{
                            borderTop: "3px solid rgba(0, 0, 0, 0.1)"
                        }}
                    />
                    {isLoading && <LoadingPage />}
                    {!isLoading && (
                        <div className="row">
                            {Array.isArray(childs) &&
                                childs.map((child, i) => (
                                    <_Child
                                        key={i + "child"}
                                        id={child.id}
                                        name={child.name || child.full_name}
                                        hasData={child.total_played > 0}
                                        setCurrentView={setCurrentView}
                                    />
                                ))}
                        </div>
                    )}
                </div>
            )}
        </React.Fragment>
    );
};
export default _EntityChildren;

const _Child = ({ id, name, hasData, setCurrentView }) => {
    const { currentEntity, setCurrentEntity } = useContext(EntityContext);
    const { entityType, setEntityType } = useContext(EntityTypeContext);

    const goToChild = () => {
        const auxType = entityType + 1;
        setEntityType(auxType);
        if (auxType == "5") {
            setCurrentEntity({
                id: `${currentEntity.id}/${id}`,
                name: `${currentEntity.name} - ${name}`
            });
        } else {
            setCurrentEntity({ id: id, name: name });
        }
        setCurrentView(0);
    };

    return (
        <div className="col-md-3 " onClick={goToChild}>
            <div className="btn btn-primary-brown btn-lg btn-block my-2 text-truncate position-relative text-uppercase">
                {name}
                {hasData && (
                    <span className="child-data-true position-absolute children-check">
                        ✓
                    </span>
                )}
            </div>
        </div>
    );
};
