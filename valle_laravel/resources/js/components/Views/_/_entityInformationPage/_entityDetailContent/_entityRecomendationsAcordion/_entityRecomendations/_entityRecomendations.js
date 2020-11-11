import React from "react";

export default function _entityRecomendations({
    id,
    performance,
    name,
    recomendation,
    type
}) {
    return (
        <div>
            <h5 className="">{name.toUpperCase()}</h5>
            <p className="">
                <b>{type}:</b> {performance}
            </p>
            <p className="">{recomendation}</p>
        </div>
    );
}
