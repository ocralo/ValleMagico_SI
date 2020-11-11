import React, { useState, useEffect } from "react";

import TittleTab from "../../Atoms/tittleTab";
import { Link } from "react-router-dom";

import { fetchApi } from "../../../function/GlobalFunctions";

const styles = {
    cardStyle: {
        height: "25rem",
        overflow: "scroll"
    },
    containerStyle: {
        display: "flex",
        flexWrap: "wrap"
    },
    itemStyle: {
        display: "flex",
        justifyContent: "center",
        flexBasis: "33.3%"
    },
    aStyle: {
        width: "95%",
        padding: "1rem 0 1rem 0",
        margin: "0.5rem 0 0.5rem 0",
        color: "white",
        opacity: 0.5
    }
};

function cardHierarchy({ title, data, url, fetchDataFrom, idFetch }) {
    return (
        <div className="container">
            <div className="row">
                <div className="card col mb-3 px-4" style={styles.cardStyle}>
                    <div className="card-body">
                        <TittleTab tittle={title} />

                        <div
                            className="container"
                            style={styles.containerStyle}
                        >
                            {Array.isArray(data) ? (
                                data.map(info => (
                                    <Child
                                        info={info}
                                        key={info.id}
                                        fetchDataFrom={fetchDataFrom}
                                        title={title}
                                        url={url}
                                        idFetch={idFetch}
                                    />
                                ))
                            ) : (
                                <div key={i} style={styles.itemStyle}>
                                    Sin datos
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

const Child = ({ info, fetchDataFrom, title, url, idFetch }) => {
    const [iconHasData, setIconHasData] = useState(false);
    const [isloading, setisloading] = useState(true);

    useEffect(() => {
        (async function() {
            if (
                title.toLowerCase() === "municipios" ||
                title.toLowerCase() === "instituciones" ||
                title.toLowerCase() === "sedes"
            ) {
                var urlAux = `${fetchDataFrom}/${info.id}`;
                const result = await fetchApi(urlAux);
                if (result[0]) {
                    setIconHasData(true);
                }
                setisloading(false);
            } else if (title.toLowerCase() === "grupos") {
                var urlAux = `${fetchDataFrom}/${idFetch}/${info.id}`;
                const result = await fetchApi(urlAux);
                if (result[0]) {
                    setIconHasData(true);
                }
                setisloading(false);
            } else if (title.toLowerCase() === "estudiantes") {
                var urlAux = `${fetchDataFrom}/${idFetch[0]}/${idFetch[1]}`;
                const result = await fetchApi(urlAux);
                if (result[0]) {
                    if (
                        result.some(value => {
                            return info.id === value.id;
                        })
                    ) {
                        setIconHasData(true);
                    }
                }
                //console.log(info.id);
                setisloading(false);
            }
        })();
    }, []);

    return (
        <div style={styles.itemStyle}>
            <Link
                className="btn btn-secondary btn-child-data"
                style={styles.aStyle}
                to={url + `${info.id}/resultadosporasignatura`}
            >
                {info.name}
                {isloading && (
                    <div
                        className="spinner-border child-data-loading"
                        role="status"
                    >
                        <span className="sr-only">Loading...</span>
                    </div>
                )}
                {iconHasData && <span className="child-data-true">✓</span>}
            </Link>
        </div>
    );
};

export default cardHierarchy;
