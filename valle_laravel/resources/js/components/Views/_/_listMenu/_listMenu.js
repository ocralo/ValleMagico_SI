import React, { useEffect, useState, useContext } from "react";

import _InputSearch from "./_inputSearch/_inputSearch";
import _ListResult from "./_ListResult/_ListResult";

import LoadingPage from "../../../Views/loadingPage/loadingPage";

import ReactPaginate from "react-paginate";

import { fetchPost } from "../../../../function/GlobalFunctions";

import { EntityTypeContext } from "../_context/_context";

import { ApiLevel, StringLevel } from "../_constants/_constants";

const _listMenu = ({
    isHovering,
    handleMouseHoverTrue,
    handleMouseHoverFalse,
    infoForSelectList
}) => {
    const [pagination, setPagination] = useState(1);
    const [totalItemsInList, setTotalItemsInList] = useState(1);
    const [totalPages, setTotalPages] = useState(0);

    const [initialChar, setInitialChar] = useState("");

    const [initialCharacters, setInitialCharacters] = useState({
        charGroups: ["A"],
        charStudents: ["A"]
    });

    const [textForFilter, setTextForFilter] = useState("");

    const [isLoading, setIsLoading] = useState(false);

    const [items, setItems] = useState([]);

    const { entityType } = useContext(EntityTypeContext);

    useEffect(() => {
        const heighWindows = window.innerHeight;
        const elementsPerPage = Math.floor(heighWindows * (15 / 768));
        setTotalItemsInList(elementsPerPage);
    }, []);

    useEffect(() => {
        const auxInitialCharacters = { ...initialCharacters };
        auxInitialCharacters.charGroups = infoForSelectList.charGroups;
        auxInitialCharacters.charStudents = infoForSelectList.charStudents;
        setInitialCharacters(auxInitialCharacters);
    }, [infoForSelectList]);

    useEffect(() => {
        setPagination(1);
        setTotalPages(0);
        setTextForFilter("");
        if (entityType == 5 && initialCharacters.charGroup) {
            setInitialChar(initialCharacters.charGroup[0]);
        } else if (entityType == 6 && initialCharacters.charStudents) {
            setInitialChar(initialCharacters.charStudents[0]);
        }
    }, [entityType]);

    useEffect(() => {
        setTextForFilter("");
        if (totalItemsInList > 1) {
            ApiLevel[entityType]
                ? resolveData(ApiLevel[entityType].listEntities)
                : "";
        }
    }, [pagination, totalItemsInList, initialChar, entityType]);

    useEffect(() => {
        if (!textForFilter.length || textForFilter.length > 2) {
            ApiLevel[entityType]
                ? resolveData(ApiLevel[entityType].listEntities)
                : "";
        }
    }, [textForFilter]);

    useEffect(() => {
        setInitialChar(
            entityType === 5
                ? initialCharacters.charGroups[0]
                : initialCharacters.charStudents[0]
        );
    }, [entityType]);

    const resolveData = async endpoint => {
        setIsLoading(true);
        let jsonToPost = {
            pagination: { page: pagination, perPage: totalItemsInList },
            initialChar,
            textForFilter
        };
        try {
            let dataToList = [];
            let infoData = await fetchPost(endpoint, jsonToPost);
            infoData.data.map(row => {
                let toPush = {
                    id: `${row.id}`,
                    name: `${row.name}`
                };
                dataToList.push(toPush);
            });
            setTotalPages(infoData.last_page);
            setItems(dataToList);
        } catch (error) {
            console.warn(error);
        }
        setIsLoading(false);
    };

    return (
        <div
            className={
                "section-listSearch col-md-12 col-sm-12 col-lg-3 p-0 " +
                (!isHovering ? "hiddenListSelect" : "showListSelect")
            }
            onMouseEnter={handleMouseHoverTrue}
            onMouseLeave={handleMouseHoverFalse}
        >
            <div className="container-fluid">
                <div className="row">
                    <div className="col-md-12">
                        <h3 className="text-capitalize pl-3 mt-2">
                            {StringLevel[entityType]
                                ? StringLevel[entityType].plural
                                : ""}
                        </h3>
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-md-12">
                        <_InputSearch
                            placeHolder={
                                "buscar " +
                                StringLevel[entityType].plural +
                                " (min 3 letras)"
                            }
                            onChange={e => setTextForFilter(e)}
                            dataValue={textForFilter}
                        />
                    </div>
                    {entityType > 4 && (
                        <React.Fragment>
                            <label className="col mb-0">
                                Seleccione letra inicial para buscar
                            </label>
                            {entityType == 5 ? (
                                <select
                                    className="form-control col-3 mr-4"
                                    onChange={e => {
                                        setTextForFilter("");
                                        setInitialChar(e.target.value);
                                    }}
                                    value={initialChar}
                                >
                                    {initialCharacters.charGroups.map(
                                        (c, i) => {
                                            return (
                                                <option key={i + c} value={c}>
                                                    {c}
                                                </option>
                                            );
                                        }
                                    )}
                                </select>
                            ) : (
                                <select
                                    className="form-control col-3 mr-4"
                                    onChange={e => {
                                        setTextForFilter("");
                                        setInitialChar(e.target.value);
                                    }}
                                    value={initialChar}
                                >
                                    {initialCharacters.charStudents.map(
                                        (c, i) => {
                                            return (
                                                <option key={i + c} value={c}>
                                                    {c}
                                                </option>
                                            );
                                        }
                                    )}
                                </select>
                            )}
                        </React.Fragment>
                    )}
                </div>
                <div className="row">
                    <div className="col-md-12">
                        {isLoading && (
                            <div style={{ transform: "scale(0.5)" }}>
                                <LoadingPage />
                            </div>
                        )}
                        {!isLoading && <_ListResult items={items} />}
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-12">
                        {totalPages > 1 && (
                            <ReactPaginate
                                previousLabel={" Anterior"}
                                nextLabel={"Siguiente "}
                                breakLabel={<span className="gap">...</span>}
                                pageCount={totalPages}
                                onPageChange={e =>
                                    setPagination(e.selected + 1)
                                }
                                forcePage={pagination - 1}
                                containerClassName={"pagination"}
                                previousLinkClassName={"previous_page"}
                                nextLinkClassName={"next_page"}
                                disabledClassName={"disabled"}
                                activeClassName={"active"}
                            />
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};
export default _listMenu;
