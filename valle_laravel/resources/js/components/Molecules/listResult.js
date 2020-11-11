import React, { useState, useEffect, useLayoutEffect, useRef } from 'react'

import ReactDOM from 'react-dom'

import ItemResult from '../Atoms/itemResult'

import { fetchPost } from './../../function/GlobalFunctions';


const ListResult = (props) => {
    const [data, setData] = useState([])
    const [elements, setElements] = useState([])

    useEffect(() => {
        setData(props.items)
        setElements(props.items)
    }, [props.items])

    function handleClick(e) {
        props.handleMouseHover(true)
        let id = e.target.href.split("/");
        let parseId = parseInt(id[5]);
        props.handleClickItem(e.target.name, parseId)
    }

    return (
        <div className='list-result'>

            {
                elements.map(
                    (item, i) => <div key={i} onClick={handleClick} >
                        <ItemResult name={item.name} itemid={item.id} />
                    </div>
                )
            }
        </div>
    )
}

export default ListResult;
