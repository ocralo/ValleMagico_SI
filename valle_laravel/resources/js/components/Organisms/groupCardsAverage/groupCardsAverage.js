import React from "react";

const GroupCardsAverage = ({
    titleCardTotalGames,
    averageTotalGames,
    titleAverage,
    averageGamesPlayed
}) => {
    return (
        <div className="container-fluid mb-3 p-0">
            <div className="row">
                <div className="col-md-4 col-sm-6">
                    <div className="card ">
                        <div className="card-body">
                            <strong className="card-title">
                                {titleCardTotalGames}
                            </strong>
                            <h4 className="card-text">{averageTotalGames}</h4>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 col-sm-6">
                    <div className="card ">
                        <div className="card-body">
                            <strong className="card-title">
                                {titleAverage}
                            </strong>
                            <h4 className="card-text">{averageGamesPlayed}</h4>
                        </div>
                    </div>
                </div>
                <div className="col-md-4 col-sm-12 .order-sm-0">
                    <div className="card">
                        <div className="card-body">
                            <strong className="card-title">
                                {titleAverage}
                            </strong>
                            <h4 className="card-text">{averageGamesPlayed}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default GroupCardsAverage;
