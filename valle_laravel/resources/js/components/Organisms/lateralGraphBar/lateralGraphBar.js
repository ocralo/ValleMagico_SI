import React, { useState, useEffect } from 'react'
import { HorizontalBar } from 'react-chartjs-2';

const LateralGraphBar = ({ jsonApi }) => {
    const [dataMath, setDataMath] = useState([])
    const [dataLanguage, setDataLanguage] = useState([])
    const [dataComp, setDataComp] = useState([])
    const [dataEnglish, setDataEnglish] = useState([])
    const [dataSocial, setDataSocial] = useState([])
    const [dataNature, setDataNature] = useState([])
    const [label, setLabel] = useState([]);

    const data = {
        labels: [
            "Absence of OB",
            "Closeness",
            "Credibility",
            "Heritage",
            "M Disclosure",
            "Provenance",
            "Reliability",
            "Transparency"
        ],
        datasets: [
            {
                label: "Matematicas",
                backgroundColor: "#00B2BF",
                borderWidth: 1,
                data: dataMath
            },
            {
                label: "Lenguaje",
                backgroundColor: "#23E3B6",
                borderWidth: 1,
                data: dataLanguage
            },
            {
                label: "Competencias",
                backgroundColor: "#00BF60",
                borderWidth: 1,
                data: dataComp
            },
            {
                label: "Ingles",
                backgroundColor: "#F5E947",
                borderWidth: 1,
                data: dataEnglish
            },
            {
                label: "Sociales",
                backgroundColor: "#F7C773",
                borderWidth: 1,
                data: dataSocial
            },
            {
                label: "Naturales",
                backgroundColor: "#F78F73",
                borderWidth: 1,
                data: dataNature
            }
        ]
    };

    const xLabels = {
        20: 'Bajo', 40: 'Basico', 60: 'Medio', 80: 'Alto',
        100: 'Superior', 120: ''
    }

    const options = {
        responsive: true,
        legend: {
            position: "top"
        },
        scales: {
            yAxes: [
                {
                    display: true,
                    gridLines: {
                        display: false
                    },
                    labels: label
                }
            ],
            xAxes: [{
                showAlways: true,
                ticks: {
                    callback: function (value, index, values) {
                        return xLabels[value];
                    },
                    min: 0,
                    max: 120
                }
            }]
        }
    }

    useEffect(() => {
        resetData()
        jsonApi.map(
            (institution) => {
                setLabel(label => [...label, institution.name]);
                institution.point.map(
                    (comp) => {

                        if (comp.name == "Matematicas") {
                            setDataMath(dataMath => [...dataMath, comp.average])
                        }
                        if (comp.name == "Lenguaje") {
                            setDataLanguage(dataLanguage => [...dataLanguage, comp.average])
                        }
                        if (comp.name == "Competencias") {
                            setDataComp(dataComp => [...dataComp, comp.average])
                        }
                        if (comp.name == "Ingles") {
                            setDataEnglish(dataEnglish => [...dataEnglish, comp.average])
                        }
                        if (comp.name == "Sociales") {
                            setDataSocial(dataSocial => [...dataSocial, comp.average])
                        }
                        if (comp.name == "Naturales") {
                            setDataNature(dataNature => [...dataNature, comp.average])
                        }
                    }
                )
            }
        )
    }, [jsonApi])

    function resetData(){
        setDataMath([])
        setDataLanguage([])
        setDataComp([])
        setDataEnglish([])
        setDataSocial([])
        setDataNature([])
        setLabel([])
    }

    return (
        <div>
            <HorizontalBar data={data} options={options} height={324} width={768} />
        </div>
    )
}

export default LateralGraphBar