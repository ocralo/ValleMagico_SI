import React, { useEffect, useState, useContext } from "react";

import _listMenu from "../_listMenu/_listMenu";
import _EntityInformationPage from "../_entityInformationPage/_entityInformationPage";

import { EntityContext, EntityTypeContext } from "../_context/_context";

const _informationPage = ({
    handleMouseHoverTrue,
    handleMouseHoverFalse,
    infoForSelectList,
    isHovering
}) => {
    const [currentEntity, setCurrentEntity] = useState();
    const [isEntitySelected, setisEntitySelected] = useState(false);

    const { entityType } = useContext(EntityTypeContext);

    useEffect(() => {
        setisEntitySelected(false);
    }, [entityType]);
    useEffect(() => {
        setisEntitySelected(true);
    }, [currentEntity]);

    return (
        <EntityContext.Provider value={{ currentEntity, setCurrentEntity }}>
            <div className="contentDepartment row h-100">
                {entityType && (
                    <_listMenu
                        isHovering={isHovering}
                        handleMouseHoverTrue={handleMouseHoverTrue}
                        handleMouseHoverFalse={handleMouseHoverFalse}
                        infoForSelectList={infoForSelectList}
                    />
                )}
                {currentEntity && isEntitySelected && (
                    <_EntityInformationPage />
                )}
                {!isEntitySelected && <span>{/* Seleccionar algo */}</span>}
            </div>
        </EntityContext.Provider>
    );
};

export default _informationPage;
