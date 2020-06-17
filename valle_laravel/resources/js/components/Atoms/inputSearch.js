import React , { useState } from 'react'

const InputSearch = (props) => {
    const [searchString , setSearchString] = useState('')
    const [input, setInput] = useState('');

    const handleChange = (e) => {
        // Sent value to parent component
        if (props.onChange) props.onChange(e.target.value)
        setInput(e.target.value);
    }
    const handleSearch = () => {
        props.onSearch(input);
    }

    return (
        <div className="input-group input-Search">
            <input type="text" className="form-control inputFilter" onChange={handleChange} placeholder={props.placeHolder}></input>
            <div className="input-group-append">
                <button className="btn btn-outline-secondary btn-search" type="button" id="button-addon2" onClick={handleSearch}>
                    <img src={__webpack_public_path__+"img/icon-search.svg"} className="icon-navbar" alt="buscar"/>
                </button>
            </div>
        </div>
    )
}

export default InputSearch
