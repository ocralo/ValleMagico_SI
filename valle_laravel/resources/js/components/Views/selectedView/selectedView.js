import React from "react";

const SelectedView = props => {
    return (
        <div className="content-selected-view d-flex flex-column align-items-center justify-content-center  col-md-12 col-sm-12 col-lg-12">
            <div className="">
                <img
                    src={__webpack_public_path__ + "img/logo.png"}
                    className="img-fluid"
                    alt="Responsive image"
                />
            </div>
            <div className="">
                <div className="tittle-selected-view">Por favor...</div>
                <div className="message-selected-view">{props.text}</div>
            </div>
            {/* <div className="col-md-3">
                <img src="../img/know.png" className="img-fluid" alt="Responsive image">
                </img>
            </div> */}
        </div>
    );
};

export default SelectedView;
