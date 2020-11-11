import React, { useEffect, useState, useCallback } from "react";
import TittleListSearch from "../../Atoms/tittleListSearch";
import InputSearch from "../../Atoms/inputSearch";
import ListResult from "../../Molecules/listResult";

import LoadingPage from "../../Views/loadingPage/loadingPage";

import ReactPaginate from 'react-paginate'

import { fetchPost } from "../../../function/GlobalFunctions";


const ListSearch = props => {
    const [isHovering, setIsHovering] = useState(false);
    const [isLoaded, setIsLoaded] = useState(false);
    const [itemsForListResult, setItemsForListResult] = useState([]);
    const [textForFilter, setTextForFilter] = useState("");

    const [heighComponent, setheighComponent] = useState(0);

    const [pagination, setPagination] = useState({perPage:1,page:1});
    const [pageCount,setPageCount] = useState(0);

    const [initialChar, setInitialChar] = useState('A');

    const [initialCharacters, setInitialCharacters] = useState(['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'])

    const [isFetching, setIsFetching ] = useState(false);

    useEffect(() => {
        setheighComponent(
            document.getElementById("listSearch").getBoundingClientRect().height
        );
        let heighWindows = window.innerHeight;
        let elementsPerPage = Math.floor(heighWindows * (15 / 768))
        setPagination({perPage:elementsPerPage-2,page:1});
    }, [window.innerHeight]);

    useEffect(()=>{
        renderData(props.type)
    },[pagination,props.type])

    const state = {
        tittle: props.tittle,
        infoForSelectList: props.infoForSelectList,
        isHovering: false,
        placeHolder: props.placeHolder,
        routeForFetchListSearch: props.routeForFetchListSearch,
        isInput: props.isInput,
        isData: props.isData,
        infoForSelectList: props.infoForSelectList,
        items: [],
        loading: true,
        error: null,
        itemsgetvalues: false,
        textForFilter: ""
    };

    useEffect(()=>{
        if(textForFilter.length>2 || textForFilter==""){
            renderData(props.type)
        }
    },[textForFilter])

    async function resolveData(endpoint){
        if(pagination.perPage>1){
            setIsFetching(true)
            let jsonToPost = { pagination, initialChar, textForFilter};
            try {
                let dataToList = [];
                    let infoData = await fetchPost(
                        endpoint,
                        jsonToPost
                    );
                    infoData.data.map(row => {
                        let toPush = {
                            id: `${row.id}`,
                            name: `${row.name}`
                        };
                        dataToList.push(toPush);
                    });
                    setPageCount(infoData.last_page)
                setItemsForListResult(dataToList);
            } catch (error) {
                console.warn(error);
            }
            setIsFetching(false)
        }
    }
    const renderData = async (type)=>{
        switch(type){
            case 1:
                await resolveData(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/deparments`)
                break;
            case 2:
                await resolveData(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/towns`)
                break;
            case 3:
                await resolveData(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/institutions`)
                break;
            case 4:
                await resolveData(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/headquarters`)
                break;
            case 5:
                await resolveData(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/grades`)
                break;
            case 6:
                await resolveData(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/students`)
                break;
        }
    }
    // useEffect(()=>{
    //     renderData(props.type);
    // },[initialChar])

    // useEffect(() => {
    //     getElementsofData();
    // }, [props.infoForSelectList]);

    // function getElementsofData() {
    //     const items = [];
    //     state.infoForSelectList.map(response => {
    //         items.push(response);
    //         // console.log('prueba3', items)
    //     });
    //     setItemsForListResult(items);
    //     fetchGrades();
    //     setIsLoaded(false);
    //     state.itemsgetvalues = false;
    //     // setState({ items, loading: false, itemsgetvalues: false });
    // }

    // recive props to son component
    function getPropsFromInputSearch(e) {
        setTextForFilter(e.trim());
    }

    function handleInitialCharSelect(e){
        const pag = {...pagination}
        pag.page = 1;
        setPagination(pag)
        setInitialChar(e.target.value)
    }
    function isInput() {
        return (
            <div>
                <div className="row align-items-center justify-content-end mx-2 mt-2">
                        <InputSearch
                            placeHolder={state.placeHolder + ' (min 3 letras)'}
                            onChange={getPropsFromInputSearch}
                            className="col-12"
                        />
                        {props.type > 4 &&
                            <label className="col mb-0">Seleccione letra inicial para buscar</label>
                        }
                         {props.type > 4 &&
                            <select className="form-control col-3 mr-4" onChange={handleInitialCharSelect} value={initialChar}>
                                {
                                    initialCharacters.map((c,i)=>{
                                        return <option key={i+c} value={c}>{c}</option>
                                    })
                                }
                            </select>
                        }
                </div>
            </div>
        );
    }

    function isData() {
        let headquarters = props.headquarters || undefined;
        let headquarters_hq = props.headquarters_hq || undefined;
        return (
            <div>
                {
                    isFetching && <div style={{transform:'scale(0.5)'}}><LoadingPage/></div>
                }
                {
                    !isFetching &&
                    <ListResult
                    items={itemsForListResult}
                    heighComponent={heighComponent}
                    handleMouseHover={handleMouseHover}
                    handleClickItem={handleClick}
                    headquarters={headquarters}
                    setPagination = {setPagination}
                    />
                }

            </div>
        );
    }

    function handleMouseHover(e) {
        setIsHovering(!isHovering);
    }

    function handleClick(e) {
        props.getNameItemClicked(e);
    }

    useEffect(() => {
        setIsHovering(true);
    }, [/* props.isHovering */]);

    // If for check loading data fetch

    function handlePageClick(data) {
        const pag = {...pagination}
        pag.page = data.selected+1;
        setPagination(pag)
    }

    return (
        // <div id={'listSearch'} className={'section-listSearch col-md-12 col-sm-12 col-lg-3 ' + (isHovering ? 'hiddenListSelect' : 'showListSelect')} onMouseLeave={handleMouseHover}>
        <div
            id={"listSearch"}
            className={
                "section-listSearch col-md-12 col-sm-12 col-lg-3 h-100 p-0 " +
                (isHovering ? "hiddenListSelect" : "showListSelect")
            }
        >
            <div className=" div-non d-none d-none d-sm-none  d-sm-block d-md-block d-lg-none col-md-3 col-sm-12" />
            <TittleListSearch tittle={state.tittle} />
            {!state.isData && !state.isInput ? isIntro() : null}
            {state.isInput ? isInput() : null}
            {state.isData ? isData() : null}
            {
                pageCount>1&&
                <ReactPaginate
                previousLabel={" Anterior"}
                nextLabel={"Siguiente "}
                breakLabel={<span className="gap">...</span>}
                pageCount={pageCount}
                onPageChange={handlePageClick}
                forcePage={pagination.page-1}
                containerClassName={"pagination"}
                previousLinkClassName={"previous_page"}
                nextLinkClassName={"next_page"}
                disabledClassName={"disabled"}
                activeClassName={"active"}
            />
            }

        </div>
    );
};

export default ListSearch;
