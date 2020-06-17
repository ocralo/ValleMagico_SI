import React, { useState, useEffect, useLayoutEffect, useRef } from 'react'

import ReactDOM from 'react-dom'

import ItemResult from '../Atoms/itemResult'

import ReactPaginate from 'react-paginate'

import { fetchPost } from './../../function/GlobalFunctions';


const ListResult = (props) => {
    const [data, setData] = useState([])
    const [filter, setFilter] = useState([])
    const [textForFilter, setTextForFilter] = useState('')

    const [pageCount, setpageCount] = useState()

    //  Paginate vars, perPage is the number of data items you want on a single page.
    //  data array holds all the items. currentPage is the current page selected,
    //  initially you may want to set it to 0 i.e.
    //  the first page.elements stores the items to be displayed on the current page and offset helps us select those items.
    const [offset, setoffset] = useState(null)
    const [perPage, setperPage] = useState(null)
    const [currentPage, setcurrentPage] = useState(0)
    const [elements, setelements] = useState([])

    const [hiddenPagination, sethiddenPagination] = useState(false)

    useEffect(() => {
        // console.log(props.headquarters_hq)
        setData(props.items)
        setFilter(props.items)
        setpageCount(Math.ceil(props.items.length / perPage))
        if (props.headquarters) fetchStudents()
        // if (props.headquarters_hq) fetchGrades()
    }, [props.items])


    useEffect(() => {
        // if (!props.headquarters) {
        let selectedPage = 0;
        let offset = selectedPage * perPage;
        setcurrentPage(selectedPage)
        setoffset(offset)
        setElementsForCurrentPage();
        // }
    }, [filter])


    useEffect(() => {
        setTextForFilter(props.textForFilter)
        if (props.textForFilter !== "") {
            if (props.headquarters) {
                fetchStudentsSearch(props.textForFilter.toLowerCase().replace(/\s+/g, ""));
            } else {
                setFilter(
                    data.filter(function (i) {
                        return i.name.toLowerCase().match(props.textForFilter.toLowerCase());
                    })
                )
            }
        } else {
            if (props.headquarters) fetchStudents();
            setFilter(props.items)
        }

    }, [props.textForFilter])

    useEffect(() => {
        // if (!props.headquarters)
        setElementsForCurrentPage()
    }, [offset, perPage])

    useEffect(() => {
        let heighWindows = window.innerHeight;
        let elementsPerPage = Math.floor(heighWindows * (15 / 768))
        setperPage(elementsPerPage)
    }, [props.heighComponent])

    async function fetchStudents(page = 1) {
        if (perPage !== null) {
            let hqs = props.headquarters.map(hq => hq.id);
            let jsonToPost = { headquarters: hqs, pagination: perPage };
            try {

                let infoStudents = await fetchPost(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/students?page=${page}`, jsonToPost);
                setData(infoStudents.game_users.data);
                setelements(infoStudents.game_users.data);
                setFilter(infoStudents.game_users.data);
                setpageCount(Math.ceil(infoStudents.quantity / perPage));
            } catch (error) {
                console.warn(error);
            }
        }
    }

    async function fetchStudentsSearch(toSearch) {
        let hqs = props.headquarters.map(hq => hq.id);
        let jsonToPost = { headquarters: hqs, pagination: perPage, toSearch };
        try {
            let infoStudents = await fetchPost(`${process.env.OPEN_VALLE_MAGICO_URL}infoUser/students`, jsonToPost);
            setData(infoStudents.game_users.data);
            setelements(infoStudents.game_users.data);
            setFilter(infoStudents.game_users.data);
            setpageCount(Math.ceil(infoStudents.quantity / perPage));
        } catch (error) {
            console.warn(error);
        }
    }

    function setElementsForCurrentPage() {

        let prevElements = filter.slice(offset, offset + perPage)
        setelements(prevElements)
        if (filter.length < perPage) {
            sethiddenPagination(false)
        } else {
            sethiddenPagination(true)
        }

    }

    function handleClick(e) {
        props.handleMouseHover(true)
        let id = e.target.href.split("/");
        let parseId = parseInt(id[5]);
        props.handleClickItem(e.target.name, parseId)
    }

    function handlePageClick(data) {
        let selectedPage = props.headquarters ? data.selected + 1 : data.selected;
        let offset = selectedPage * perPage;
        if (props.headquarters) {
            fetchStudents(selectedPage)
        } else {
            setcurrentPage(selectedPage)
            setoffset(offset)
        }
        // setElementsForCurrentPage();
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
            {
                hiddenPagination &&
                <ReactPaginate
                    previousLabel={" Anterior"}
                    nextLabel={"Siguiente "}
                    breakLabel={<span className="gap">...</span>}
                    pageCount={pageCount}
                    onPageChange={handlePageClick}
                    forcePage={currentPage}
                    containerClassName={"pagination"}
                    previousLinkClassName={"previous_page"}
                    nextLinkClassName={"next_page"}
                    disabledClassName={"disabled"}
                    activeClassName={"active"}
                />
            }
        </div>
    )
}

export default ListResult;
