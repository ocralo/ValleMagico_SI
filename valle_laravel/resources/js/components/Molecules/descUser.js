import React from 'react'

const DescUser = ({ titledesc, desc }) => {

    return (
        <div className='d-flex nowrap'>
            <div className='title-desc col-md-6'>
                {titledesc}
            </div>
            <div className='desc col-md-6'>
                {desc}
            </div>
        </div>
    )

}

export default DescUser;