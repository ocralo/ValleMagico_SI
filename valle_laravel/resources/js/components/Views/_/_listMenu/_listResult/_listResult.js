import React, { useContext } from "react";

import { EntityContext, EntityTypeContext } from "../../_context/_context";
import { StringLevel } from "../../_constants/_constants";

// import ItemResult from '../Atoms/itemResult'

// import { fetchPost } from './../../../../../function/GlobalFunctions';

const _ListResult = ({ items }) => {
    const { setCurrentEntity } = useContext(EntityContext);
    const { entityType } = useContext(EntityTypeContext);
    return (
        <div className="list-result">
            {items &&
                items.map((item, i) => (
                    <div
                        className="btn mt-1 w-100 btn-menu text-truncate text-left"
                        key={`list-result-${i}`}
                        onClick={() =>
                            setCurrentEntity({ id: item.id, name: item.name })
                        }
                    >
                        <span>{item.name}</span>
                        {/* <ItemResult name={item.name} itemid={item.id} /> */}
                    </div>
                ))}
            {!items[0] && (
                <span>
                    No se encontraron{" "}
                    {StringLevel[entityType]
                        ? StringLevel[entityType].plural
                        : ""}
                </span>
            )}
        </div>
    );
};

export default _ListResult;
