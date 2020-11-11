import React, { useState, useEffect } from "react";

const _InputSearch = ({ onChange, placeHolder, dataValue }) => {
    const [inputValue, setInputValue] = useState(dataValue);

    useEffect(() => {
        if (dataValue == "") {
            setInputValue("");
        }
    }, [dataValue]);

    useEffect(() => {
        const typingTimer = setTimeout(() => {
            onChange(inputValue);
        }, 500);
        return () => {
            clearTimeout(typingTimer);
        };
    }, [inputValue]);

    return (
        <div className="input-group input-Search w-100 p-0">
            <input
                type="text"
                className="form-control inputFilter w-75"
                onChange={e => setInputValue(e.target.value)}
                placeholder={placeHolder}
                value={inputValue}
            />
            <div className="input-group-append w-25">
                <button
                    className="btn btn-outline-secondary btn-search border-secondary"
                    type="button"
                    id="button-addon2"
                >
                    <img
                        src={__webpack_public_path__ + "img/icon-search.svg"}
                        className="icon-navbar"
                        alt="buscar"
                    />
                </button>
            </div>
        </div>
    );
};

export default _InputSearch;
