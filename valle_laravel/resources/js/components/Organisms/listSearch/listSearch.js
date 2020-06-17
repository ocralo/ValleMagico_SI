import React, { useEffect, useState, useCallback } from 'react';
import TittleListSearch from '../../Atoms/tittleListSearch';
import InputSearch from '../../Atoms/inputSearch';
import ListResult from '../../Molecules/listResult';

import LoadingPage from '../../Views/loadingPage/loadingPage'

import { fetchPost } from '../../../function/GlobalFunctions';

const ListSearch = (props) => {
    const [isHovering, setIsHovering] = useState(false)
    const [isLoaded, setIsLoaded] = useState(false)
    const [itemsForListResult, setItemsForListResult] = useState([])
    const [textForFilter, setTextForFilter] = useState("")

    const [heighComponent, setheighComponent] = useState(0)


    useEffect(() => {
        setheighComponent(document.getElementById('listSearch').getBoundingClientRect().height)
    }, [window.innerHeight])

    const state = {
        tittle: props.tittle,
        infoForSelectList: props.infoForSelectList,
        isHovering: false,
        placeHolder: props.placeHolder,
        routeForFetchListSearch: props.routeForFetchListSearch,
        isInput: props.isInput,
        isData: props.isData,
        isData: props.isData,
        infoForSelectList: props.infoForSelectList,
        items: [],
        loading: true,
        error: null,
        itemsgetvalues: false,
        textForFilter: ''
    }

    async function fetchGrades() {
        let jsonToPost = { headquarters: props.headquarters_hq };
        try {

            let infoGrades = await fetchPost(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/grades`, jsonToPost);
            let dataToList = [];
            props.headquarters_hq.map(element => {
                infoGrades.hq_grades.map(grade => {
                    let toPush = { id: `${element.id}-${grade.id}`, name: `${element.name} - ${grade.name}` };
                    dataToList.push(toPush);
                });
            })
            setItemsForListResult(dataToList);
            // console.log(state.infoForSelectList)
        } catch (error) {
            console.warn(error);
        }
    }

    useEffect(() => {
        getElementsofData()
    }, [props.infoForSelectList])

    function getElementsofData() {
        const items = []
        state.infoForSelectList.map(
            response => {
                items.push(response)
                // console.log('prueba3', items)
            }
        )
        setItemsForListResult(items)
        fetchGrades()
        setIsLoaded(false)
        state.itemsgetvalues = false
        // setState({ items, loading: false, itemsgetvalues: false });

    }

    // recive props to son component
    function getPropsFromInputSearch(e) {
        setTextForFilter(e)
    }

    function isInput() {
        return (
            <div>
                <div>
                    {props.headquarters ?
                        <InputSearch placeHolder={state.placeHolder} onSearch={getPropsFromInputSearch} /> :
                        <InputSearch placeHolder={state.placeHolder} onChange={getPropsFromInputSearch} />
                    }
                </div>

            </div>
        )
    }

    function isData() {
        let headquarters = props.headquarters || undefined;
        let headquarters_hq = props.headquarters_hq || undefined;
        return (
            <div>
                <ListResult items={itemsForListResult} textForFilter={textForFilter} heighComponent={heighComponent} handleMouseHover={handleMouseHover} handleClickItem={handleClick}
                    headquarters={headquarters}
                />
            </div>
        )
    }

    function handleMouseHover(e) {
        setIsHovering(!isHovering)
    }

    function handleClick(e) {
        props.getNameItemClicked(e)
    }

    useEffect(() => {
        setIsHovering(true)
    }, [props.isHovering])

    // If for check loading data fetch

    if (isLoaded) {
        return (<LoadingPage />)
    } else {
        return (
            // <div id={'listSearch'} className={'section-listSearch col-md-12 col-sm-12 col-lg-3 ' + (isHovering ? 'hiddenListSelect' : 'showListSelect')} onMouseLeave={handleMouseHover}>
            <div id={'listSearch'} className={'section-listSearch col-md-12 col-sm-12 col-lg-3 h-100 p-0 ' + (isHovering ? 'hiddenListSelect' : 'showListSelect')}>
                <div className=' div-non d-none d-none d-sm-none  d-sm-block d-md-block d-lg-none col-md-3 col-sm-12'>

                </div>
                <TittleListSearch tittle={state.tittle} />
                {
                    !state.isData && !state.isInput ? isIntro() : null
                }
                {
                    state.isInput ? isInput() : null
                }
                {
                    state.isData ? isData() : null
                }
            </div>
        );
    }


}

export default ListSearch;
