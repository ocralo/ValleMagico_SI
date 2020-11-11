import React, { useEffect, useState } from "react";
import { fetchApi } from "../../../function/GlobalFunctions";
import TittleTab from "../../Atoms/tittleTab";
import CardGraph from "../../Organisms/cardGraph/cardGraph";
import CardHierarchy from "../../Organisms/cardHierarchy/cardHierarchy";

import LoadingPage from "../loadingPage/loadingPage";

function ViewLearningStyles({ urlToGetInfoStyles, nameItemClicked, titleChild, dataChild, url }) {
    const [isLoaded, setisLoaded] = useState(true);
    const [error, setError] = useState(null);
    const [jsonApi, setJsonApi] = useState([]);
    const tabs = [
        { id: "General" },
        { id: "Acomodadores" },
        { id: "Asimiladores" },
        { id: "Divergentes" },
        { id: "Convergentes" }
    ];
    const showAllData = "General";
    useEffect(() => {
        fetchData();
    }, [urlToGetInfoStyles]);

    async function fetchData() {
        try {
            const result = await fetchApi(urlToGetInfoStyles);
            setJsonApi(result);
            setisLoaded(false);
        } catch (error) {
            setisLoaded(true);
            setError(error);
        }
    }

    if (isLoaded) {
        return <LoadingPage />;
    } else {
        return (
            <div className="col-12">
                <TittleTab
                    tittle={"Estilos de aprendizaje"}
                    nameItemClicked={nameItemClicked}
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

export default ViewLearningStyles;
