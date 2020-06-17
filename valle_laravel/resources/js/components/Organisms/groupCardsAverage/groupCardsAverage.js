import React from 'react'

const GroupCardsAverage = ({ titleCardTotalGames, averageTotalGames, titleAverage, averageGamesPlayed }) => {
    return (
        <div className="container">
            <div className="row">
                <div className="card col mb-3 mr-1">
                    <div className="card-body">
                        <strong className="card-title">{titleCardTotalGames}</strong>
                        <h4 className="card-text">{averageTotalGames}</h4>
                    </div>
                </div>
                <div className="card col mb-3 ml-1">
                    <div className="card-body">
                        <strong className="card-title">{titleAverage}</strong>
                        <h4 className="card-text">{averageGamesPlayed}</h4>
                    </div>
                </div>
            </div>

        </div>
    )
}

export default GroupCardsAverage;