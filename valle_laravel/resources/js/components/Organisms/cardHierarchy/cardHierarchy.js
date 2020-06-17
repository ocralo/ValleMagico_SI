import React from 'react'

import TittleTab from '../../Atoms/tittleTab';
import { Link } from 'react-router-dom';

const styles = {
    cardStyle: {
        height: "25rem",
        overflow: "scroll"
    },
    containerStyle: {
        display: "flex",
        flexWrap: 'wrap'
    },
    itemStyle: {
        display: 'flex',
        justifyContent: 'center',
        flexBasis: '33.3%'
    },
    aStyle: {
        width: "95%",
        padding: "1rem 0 1rem 0",
        margin: "0.5rem 0 0.5rem 0",
        color: "white",
        opacity: 0.5
    }
}

function cardHierarchy({ title, data, url }) {
    return (
        <div className="container">
            <div className="row">
                <div className="card col mb-3 px-4" style={styles.cardStyle}>
                    <div className="card-body">
                        <TittleTab tittle={title} />

                        <div className="container" style={styles.containerStyle}>
                            {Array.isArray(data) ? (data.map(info => (
                                <div style={styles.itemStyle}>
                                    <Link className="btn btn-secondary" style={styles.aStyle} to={url + `${info.id}/resultadosporasignatura`}>
                                            {/* <a className="btn btn-secondary" style={styles.aStyle}> */}{info.name}{/* </a> */}
                                    </Link>
                                </div>
                                // <li className="list-group-item">
                                //     {info.name}
                                // </li>
                            ))) : (<div style={styles.itemStyle}>Sin datos</div>)
                            }
                        </div>

                        {/* <ul className="list-group list-group-flush">
                            {

                            }
                        </ul> */}
                    </div>
                </div>
            </div>
        </div>
    )
}

export default cardHierarchy;
