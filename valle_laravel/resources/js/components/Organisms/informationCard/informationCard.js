import React  from 'react'


const InformationCard = ({ informationData }) => {
    const InformationForCard = Object.entries(informationData)

    return (
        <div className="card  card-info col-md-7">
            <div className="card-body d-flex flex-column align-items-center">
                {
                    InformationForCard.map(
                        (item, i) =>
                            <div key = {i} className="col-md-6">
                                <div className='tittle-items-card'>
                                    {item[0]}
                                </div>
                                <div className='item-card'>
                                    {item[1]}
                                </div>
                            </div>
                    )
                }
            </div>
        </div>
    )
}

export default InformationCard