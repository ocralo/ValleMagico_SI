import React, { useEffect, useState , forwardRef } from 'react'

const ListInfo = forwardRef(({ tittleList, contentList}, ref) => {

    useEffect(() => {
    }, [tittleList, contentList])

   
    return (
        <div ref = {ref}>
            <table className="table table-striped">
                <thead>
                    <tr>
                        {
                            tittleList.map(
                                (item, i) => <th className='head-table' key={i} scope="col">{item}</th>
                            )
                        }
                    </tr>
                </thead>
                <tbody>
                    {
                        contentList.map(
                            (rowList, i) => {
                                return (
                                    <tr key={i} className='row-table'>
                                        {
                                            rowList.map(
                                                (item, i) => <td key={i} >{item}</td>
                                            )
                                        }
                                    </tr>
                                )
                            }
                        )
                    }

                </tbody>
            </table>
        </div>
    )

})

export default ListInfo