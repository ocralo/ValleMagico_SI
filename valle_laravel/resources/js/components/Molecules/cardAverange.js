import React from 'react'
import ResultAverange from '../Atoms/resultAverange'
import DescriptAverange from '../Atoms/descriptAverange'

const CardAverange = ({ result, descript }) => {
    return (
        <div className='card col-md-1.5'>
            <ResultAverange result={result} />
            <DescriptAverange descript={descript} />
        </div>
    )
}

export default CardAverange