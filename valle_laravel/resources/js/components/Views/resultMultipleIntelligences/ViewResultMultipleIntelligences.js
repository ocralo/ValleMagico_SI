import React, { useState, useEffect } from "react";
import LoadingPage from "../loadingPage/loadingPage";
import TittleTab from "../../Atoms/tittleTab";
import GroupCardsAverage from "../../Organisms/groupCardsAverage/groupCardsAverage";
import CardGraph from "../../Organisms/cardGraph/cardGraph";
import CardHierarchy from "../../Organisms/cardHierarchy/cardHierarchy";

import { fetchApi } from "../../../function/GlobalFunctions";

function ViewResultMultipleIntelligences({
    urlToGetInfoIntelligences,
    urlToGetInfoGamesPlayed,
    nameItemClicked,
    titleChild,
    dataChild,
    url
}) {
    const [isLoaded, setisLoaded] = useState(true);
    const [error, setError] = useState(null);
    const [jsonApi, setJsonApi] = useState([]);
    const [dataGamesPlayed, setdataGamesPlayed] = useState();

    const tabs = [
        { id: "General" },
        { id: "Visoespacial" },
        { id: "Musical" },
        { id: "Kinestésica" },
        { id: "Interpersonal" },
        { id: "lingüística" },
        { id: "Matemática" }
    ];

    const showAllData = "General";

    useEffect(() => {
        // console.log( urlToGetInfoGamesPlayed);
        fetchData();
    }, [urlToGetInfoIntelligences, urlToGetInfoGamesPlayed]);

    async function fetchData() {
        try {
            const result = await fetchApi(urlToGetInfoIntelligences);
            setJsonApi(result);
            const gamesPlayedInfo = await fetchApi(urlToGetInfoGamesPlayed);
            setdataGamesPlayed(gamesPlayedInfo);
            setisLoaded(false);
        } catch (error) {
            setisLoaded(true);
            setError(error);
            console.log("TCL: fetchData -> error", error);
        }
    }

    if (isLoaded) {
        return <LoadingPage />;
    } else {
        return (
            <div className="col-12">
                <TittleTab
                    tittle={"Inteligencias Múltiples"}
                    nameItemClicked={nameItemClicked}
                />
                <GroupCardsAverage
                    titleCardTotalGames="Total de juegos"
                    averageTotalGames={dataGamesPlayed.total_games}
                    titleAverage="Promedio de juegos jugados"
                    averageGamesPlayed={dataGamesPlayed.average}
                />
                <CardGraph
                    tabs={tabs}
                    jsonApi={jsonApi}
                    showAllData={showAllData}
                    heightGraph={225}
                    widthGraph={768}
                    typeGraph="bar"
                />
                {
                    titleChild !== null ? <CardHierarchy 
                    title={titleChild}
                    data={dataChild}
                    url={url}
                /> : null
                }
            </div>
        );
    }
}

export default ViewResultMultipleIntelligences;
