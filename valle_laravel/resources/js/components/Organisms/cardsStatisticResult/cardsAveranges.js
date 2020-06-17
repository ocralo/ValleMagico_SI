import React from 'react'
import CardStatistic from '../../Molecules/cardAverange'
import CardAverange from '../../Molecules/cardAverange'

const CardsAveranges = ({averanges}) => {

    return(
        <div className="d-flex">
        {
            averanges.map(
                (item , i) => <CardAverange key = {i} result = {item.averange} descript = {item.descript} /> 
            )
        }
        </div>
    )
}
export default CardsAveranges;