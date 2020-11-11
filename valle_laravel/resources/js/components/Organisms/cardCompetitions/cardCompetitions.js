import React from 'react'
import Graphline from '../graphline/graphline'

const CardCompetitions = ({ title, titleGraph1, titleGraph2, dataForGraph1, dataForGraph2 }) => {
    return (
        <div className="container" >
            <div className="row">
                <div className="card col mb-3">
                    <div className="card-body">
                        <h6 className="card-title title-card-competition col-12">{title}</h6>
                        <div className="row">
                            <div className='col-sm-12 col-md-12 col-lg-6'>
                                <div className='title-graph-competition text-center col-lg-12' >{titleGraph1}</div>
                                <Graphline typeGraph={'bar'} jsonApi={dataForGraph1} />
                            </div>
                            <div className='col-sm-12 col-md-12 col-lg-6'>
                                <div className='title-graph-competition text-center col-lg-12 '>{titleGraph2}</div>
                                <Graphline typeGraph={'bar'} jsonApi={dataForGraph2} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default CardCompetitions