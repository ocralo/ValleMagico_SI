import React, { useState, useEffect } from 'react'

const CardConvenciones = ({ conventions, desc, showDesc }) => {

    const [showTabDesc, setshowTabDesc] = useState(true)

    useEffect(() => {
        if (showDesc == undefined) {
            setshowTabDesc(true)
        } else {
            setshowTabDesc(showDesc)
        }
    }, [showDesc])

    return (

        <div className="container">
            <div className="row">
                <div className="card col mb-3">
                    <ul className="nav justify-content-around nav-tabs" role="tablist">
                        <li className="nav-item">
                            <a className="nav-link-conventions active" href="#convetions" role="tab" data-toggle="tab" >Convenciones</a>
                        </li>
                        {
                            showTabDesc == true &&
                            <li className="nav-item">
                                <a className="nav-link-conventions" href="#description" role="tab" data-toggle="tab">Descripción</a>
                            </li>
                        }
                    </ul>

                    <div className="tab-content">
                        <div role="tabpanel" className="tab-pane fade in active show" id="convetions">
                            <div className="card-body">
                                {
                                    conventions.map(
                                        (convention, i) =>
                                            <div key={i} className='item-conventions d-flex'>
                                                <div className="tittle-conventions">
                                                    {convention.title}
                                                </div>
                                                <div className="descript-conventions">
                                                    {convention.desc}
                                                </div>
                                            </div>
                                    )
                                }
                            </div>

                        </div>
                        {
                            showTabDesc == true &&
                            <div role="tabpanel" className="tab-pane fade" id="description">
                                <div role="tabpanel" className="tab-pane fade in active show" id="convetions">
                                    <div className="card-body">
                                        {
                                            desc.map(
                                                (item, i) =>
                                                    <div key={i} className='item-conventions d-flex'>
                                                        <div className="tittle-conventions">
                                                            {item.title}
                                                        </div>
                                                        <div className="descript-conventions">
                                                            {item.desc}
                                                        </div>
                                                    </div>
                                            )
                                        }
                                    </div>
                                </div>
                            </div>
                        }
                    </div>

                </div>
            </div>
        </div>


    )
}

export default CardConvenciones;