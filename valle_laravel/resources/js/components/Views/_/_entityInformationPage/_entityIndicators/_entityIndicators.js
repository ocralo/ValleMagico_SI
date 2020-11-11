import React, { useEffect, useState, useContext } from "react";
import { EntityContext, EntityTypeContext } from "../../_context/_context";

import { fetchApi } from "../../../../../function/GlobalFunctions";

import { ApiLevel, StringLevel } from "../../_constants/_constants";

const _EntityIndicators = ({
    totalChildsWhoPlayed,
    totalChilds,
    currentView
}) => {
    const { currentEntity } = useContext(EntityContext);
    const { entityType } = useContext(EntityTypeContext);
    const [averageTotalGames, setAverageTotalGames] = useState("-");
    const [averageGamesPlayed, setAverageGamesPlayed] = useState("-");

    useEffect(() => {
        getData();
    }, [entityType, currentEntity, currentView]);

    const getData = async () => {
        let uri = "";
        if (currentView == "0") {
            uri = `${ApiLevel[entityType].games_played}/${currentEntity.id}`;
        } else {
            uri = `${ApiLevel[entityType].games_played}/${
                currentEntity.id
            }/true`;
        }

        const gamesPlayedInfo = await fetchApi(uri);

        setAverageTotalGames(gamesPlayedInfo.total_games);
        setAverageGamesPlayed(gamesPlayedInfo);
    };

    return (
        <div className="row my-2">
            <div className="col-md-4 col-12">
                <div className="card ">
                    <div className="card-body">
                        <strong className="card-title">Total de Juegos</strong>
                        <h4 className="card-text">{averageTotalGames}</h4>
                    </div>
                </div>
            </div>
            <div className="col-md-4 col-12">
                <div className="card ">
                    <div className="card-body">
                        <strong className="card-title">
                            {entityType == 6
                                ? "Juegos jugados"
                                : "Promedio de juegos jugados"}
                        </strong>
                        <h4 className="card-text">
                            {entityType == 6
                                ? averageGamesPlayed.games_played
                                : averageGamesPlayed.average}
                        </h4>
                    </div>
                </div>
            </div>
            {entityType != 6 && (
                <div className="col-md-4 col-12">
                    <div className="card ">
                        <div className="card-body">
                            <strong className="card-title">
                                Total {StringLevel[entityType + 1].plural} que
                                jugaron
                            </strong>
                            <h4 className="card-text">
                                {totalChildsWhoPlayed} de {totalChilds}
                            </h4>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default _EntityIndicators;
