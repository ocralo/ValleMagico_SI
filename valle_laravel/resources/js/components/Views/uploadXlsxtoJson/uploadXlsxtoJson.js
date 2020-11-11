import React, { useState, useEffect } from "react";
import XLSX from "xlsx";
import { make_cols } from "./MakeColumns";
import { SheetJSFT } from "./types";

import { fetchPOST } from "../../../function/GlobalFunctions";

const UploadXlsxtoJson = () => {
    const [file, setFile] = useState({});
    const [dataJson, setDataJson] = useState({
        data: [],
        cols: []
    });
    const [UsersJson, setUsersJson] = useState({
        0: [],
        1: [],
        2: [],
        3: [],
        4: [],
        5: [],
        6: [],
        7: [],
        8: [],
        9: []
    });
    const [textInput, settextInput] = useState("Seleccionar Archivo");
    // const [data , setData] = useState([])
    // const [cols , setCols] = useState([])

    const [disable, setdisable] = useState(false);

    const dataDisability = [
        {
            Docdasability: "AUTISMO",
            text: "cognitiva"
        },
        {
            Docdasability: "BAJA VISION DIAGNOSTICADA",
            text: "visual"
        },
        {
            Docdasability: "CEGUERA",
            text: "visual"
        },
        {
            Docdasability: "DEFICIENCIA COGNITIVA (RETARDO MENTAL)",
            text: "cognitiva"
        },
        {
            Docdasability: "HIPOACUSIA O BAJA AUDICION",
            text: "auditiva"
        },
        {
            Docdasability: "LIMITACION FISICA (MOVILIDAD)",
            text: "motora"
        },
        {
            Docdasability: "PARALISIS CEREBRAL",
            text: "cognitiva"
        },
        {
            Docdasability: "SINDROME DE DOWN",
            text: "cognitiva"
        },
        {
            Docdasability: "SORDERA PROFUNDA",
            text: "auditiva"
        },
        {
            Docdasability: "SORDOS USUARIOS DE CASTELLANO ORAL",
            text: "auditiva"
        },
        {
            Docdasability: "SORDOS USUARIOS DE LENGUA DE SEÑAS",
            text: "auditiva"
        }
    ];

    const handleChange = e => {
        const files = e.target.files;
        if (files && files[0]) setFile(files[0]);
        settextInput(files[0].name);
    };

    const handleFile = () => {
        /* Boilerplate to set up FileReader */
        const reader = new FileReader();
        const rABS = !!reader.readAsBinaryString;

        reader.onload = e => {
            /* Parse data */
            const bstr = e.target.result;
            const wb = XLSX.read(bstr, {
                type: rABS ? "binary" : "array",
                bookVBA: true
            });
            /* Get first worksheet */
            const wsname = wb.SheetNames[0];

            const ws = wb.Sheets[wsname];
            /* Convert array of arrays */
            const data = XLSX.utils.sheet_to_json(ws);
            /* Update state */
            setDataJson({ data: data, cols: make_cols(ws["!ref"]) });
        };

        if (rABS) {
            reader.readAsBinaryString(file);
        } else {
            reader.readAsArrayBuffer(file);
        }
    };

    function detectUndefined(text) {
        if (text == undefined) {
            return "";
        } else {
            return text;
        }
    }

    function keysToLowerCase(obj) {
        if (obj.length > 0) {
            setdisable(true);
        }
        //"TCL: keysToLowerCase -> obj", obj)

        let infoFilterForFetch = {};

        obj.map(item => {
            if (
                parseInt(item.COD_GRADO) >= 0 &&
                parseInt(item.COD_GRADO) <= 9
            ) {
                let doc;

                if (
                    isNaN(
                        parseInt(
                            String(item.NRO_IDENTIDAD).replace(/[^0-9]/g, "")
                        )
                    ) == false
                ) {
                    doc = parseInt(
                        String(item.NRO_IDENTIDAD).replace(/[^0-9]/g, "")
                    );
                } else {
                    doc = 11111111;
                }

                let dissbilityForPush = findDissability(
                    item.TIPOS_DISCAPACIDAD
                );
                setUsersJson({
                    ...UsersJson,
                    [item.COD_GRADO]: UsersJson[item.COD_GRADO].push({
                        nombre_sede: String(detectUndefined(item.NOMBRE_SEDES))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, "")
                            .replace(/ /g, "_"),
                        nombre_institucion: String(
                            detectUndefined(item.ESTABLECIMIENTO)
                        )
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, "")
                            .replace(/ /g, "_"),
                        nombre_municipio: String(
                            detectUndefined(item.MUNICIPIO)
                        )
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, "")
                            .replace(/ /g, "_"),
                        zona: String(detectUndefined(item.ZONAS))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, "")
                            .replace(/ /g, "_"),
                        region: String(detectUndefined(item.Región))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, "")
                            .replace(/ /g, "_"),
                        doc: doc,
                        grado_cod: item.COD_GRADO,
                        apellido1: String(detectUndefined(item.PRI_APE))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, ""),
                        apellido2: String(detectUndefined(item.SEG_APE))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, ""),
                        nombre1: String(detectUndefined(item.PRI_NOM))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, ""),
                        nombre2: String(detectUndefined(item.SEG_NOM))
                            .trim()
                            .normalize("NFD")
                            .replace(/[^-A-Za-z0-9 ]/g, ""),
                        discapacidad: dissbilityForPush
                    })
                });
            }
        });
        // setUsersJson(infoFilterForFetch)
    }

    function findDissability(dissabilityDocument) {
        let isDissability = dataDisability.find(
            Dissability => Dissability.Docdasability == dissabilityDocument
        );
        if (isDissability == undefined) {
            return "ninguna";
        }
        return isDissability.text;
    }

    useEffect(() => {
        //console.log("TCL: UploadXlsxtoJson -> datajson", dataJson.data)
        keysToLowerCase(dataJson.data);
    }, [dataJson]);

    useEffect(() => {
        // if (UsersJson.length > 0) {
        //     UsersJson.map(
        //         (item, i) => {
        //             fetchPOSTDATA({ users: item })
        //             console.log("TCL: UploadXlsxtoJson -> i", i)
        //         }
        //     )
        // }
        //console.log("TCL: UploadXlsxtoJson -> UsersJson", UsersJson);
    }, [UsersJson]);

    async function fetchPOSTDATA(data) {
        var url = `${process.env.OPEN_VALLE_MAGICO_URL}simat/students`;
        //console.log("DAta fetch ", data);

        try {
            const data1 = await fetchPOST(url, data, "POST");
            setdisable(false);
        } catch (error) {}
    }

    function handleClick(e) {
        //console.log("TCL: handleClick -> e", e.target.id);
        //console.log("TCL: handleClick -> UsersJson", UsersJson[e.target.id]);
        fetchPOSTDATA({ users: UsersJson[e.target.id] });
    }

    return (
        <div className="content-uploadxlsm col-md-12 d-flex align-items-center justify-content-center text-center">
            <div>
                <div>
                    <label className="title-group  text-center" htmlFor="file">
                        {" "}
                        Subir un archivo XLSX{" "}
                    </label>
                </div>

                <div className="custom-file mb-5 mt-5">
                    <input
                        type="file"
                        className="custom-file-input"
                        id="customFileLang"
                        lang="es"
                        accept={SheetJSFT}
                        onChange={handleChange}
                    />
                    <label className="custom-file-label" for="customFileLang">
                        {textInput}
                    </label>
                </div>

                <input
                    className="btn-uploadFile btn"
                    type="submit"
                    value="Cargar archivo"
                    disabled={disable}
                    onClick={handleFile}
                />
                {Object.keys(UsersJson).map(grade => (
                    <div>
                        {UsersJson[grade].length > 0 && (
                            <input
                                type="button"
                                value={`Grado ${grade}`}
                                id={grade}
                                onClick={handleClick}
                            />
                        )}
                    </div>
                ))}
            </div>
        </div>
    );
};
export default UploadXlsxtoJson;
