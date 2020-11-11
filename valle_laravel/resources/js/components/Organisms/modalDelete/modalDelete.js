import React from "react";
import { fetchPOST } from "../../../function/GlobalFunctions";

const ModalDelete = ({ modalId, title, textBody, urlFetch, element }) => {
    async function deleteElement() {
        try {
            const data = await fetchPOST(
                `${urlFetch}/${element.id}`,
                element,
                "DELETE"
            );
            //console.log("TCL: deleteElement -> data", data)
        } catch (error) {
            console.warn(error);
        }
    }

    function handleClick() {
        deleteElement();
    }

    return (
        <div
            className="modal fade"
            id={modalId}
            tabIndex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div className="modal-dialog modal-sm" role="document">
                <div className="modal-content">
                    <div className="modal-body  ">
                        <h5 className="modal-title" id="exampleModalLabel">
                            {title}{" "}
                        </h5>
                        <div>{textBody} </div>
                    </div>
                    <div className="modal-footer d-flex justify-content-between ">
                        <button
                            type="button"
                            className="btn btn-modal-close"
                            data-dismiss="modal"
                        >
                            Cancelar
                        </button>
                        <button
                            type="button"
                            className="btn btn-modal-close"
                            onClick={handleClick}
                            data-dismiss="modal"
                        >
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};
export default ModalDelete;
