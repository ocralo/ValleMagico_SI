import React, {
    useState,
    useEffect,
    useRef,
    useContext,
    useCallback
} from "react";
import { Bar, Chart } from "react-chartjs-2";
import * as ChartAnnotation from "chartjs-plugin-annotation";
import { useRouteMatch } from "react-router-dom";
import { EntityGraphContext } from "../../../_context/_context";

import "chartjs-plugin-datalabels";
const _EntityGraph = ({ values, labels, extra = false, currentView = "" }) => {
    const placeholder = useRef();
    const { graphs, setGraphs } = useContext(EntityGraphContext);

    Chart.plugins.register({
        beforeDraw: function(c) {
            var ctx = c.chart.ctx;
            ctx.fillStyle = "white";
            ctx.fillRect(0, 0, c.chart.width, c.chart.height);
        }
    });

    useEffect(() => {
        if (!extra) {
            const timeout = setTimeout(() => {
                if (placeholder.current) {
                    const chart =
                        placeholder.current.chartInstance.chart.canvas;
                    const imageB64 = chart.toDataURL("image/jpeg");
                    setGraphs([...graphs, imageB64]);
                }
            }, 500);

            return function cleanup() {
                clearTimeout(timeout);
            };
        }
    }, []);
    const yLabels = {
        yLabels: {
            0: "Bajo",
            20: "Básico",
            40: "Medio",
            60: "Alto",
            80: "Superior",
            100: ""
        },
        min: 0,
        max: 100
    };

    const data = {
        labels: labels,
        datasets: [
            {
                label: "Puntaje promedio",
                backgroundColor: "rgba(114,107,98,0.6)",
                borderColor: "rgba(86,80,74,1)",
                borderWidth: 1,
                pointHoverBackgroundColor: "rgba(114,107,98,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                data: values
            }
        ]
    };

    const options = {
        scales: {
            yAxes: [
                {
                    ticks: {
                        min: 0,
                        stepSize: 20,
                        min: 0,
                        max: 110
                    },
                    gridLines: {
                        display: false
                    }
                }
            ],
            xAxes: [
                {
                    gridLines: {
                        display: false
                    }
                }
            ]
        },
        annotation: {
            annotations: [
                {
                    type: "line",
                    mode: "horizontal",
                    scaleID: "y-axis-0",
                    value: 59,
                    borderColor: "black",
                    borderWidth: 1,
                    borderDash: [5, 15],
                    borderDashOffset: 5,
                    label: {
                        fontSize: 10,
                        position: "right",
                        content: "Bajo",
                        enabled: true
                    }
                },
                {
                    type: "line",
                    mode: "horizontal",
                    scaleID: "y-axis-0",
                    value: 84,
                    borderColor: "black",
                    borderWidth: 1,
                    borderDash: [5, 15],
                    borderDashOffset: 5,
                    label: {
                        fontSize: 10,
                        position: "right",
                        content: "Básico",
                        enabled: true
                    }
                },
                {
                    type: "line",
                    mode: "horizontal",
                    scaleID: "y-axis-0",
                    value: 94,
                    borderColor: "black",
                    borderWidth: 1,
                    borderDash: [5, 15],
                    borderDashOffset: 5,
                    label: {
                        fontSize: 10,
                        position: "right",
                        content: "Alto",
                        enabled: true
                    }
                },
                {
                    type: "line",
                    mode: "horizontal",
                    scaleID: "y-axis-0",
                    value: 100,
                    borderColor: "black",
                    borderWidth: 1,
                    borderDash: [5, 15],
                    borderDashOffset: 5,
                    label: {
                        fontSize: 10,
                        position: "right",
                        content: "Superior",
                        enabled: true
                    }
                }
            ]
        },
        plugins: {
            ChartAnnotation,
            datalabels: {
                display: true,
                color: "#726B62",
                align: "end",
                //  offset: 'top',
                anchor: "end"
            }
        }
    };

    const options2 = {
        scales: {
            yAxes: [
                {
                    ticks: {
                        min: 0,
                        stepSize: 20,
                        min: 0,
                        max: 110
                    },
                    gridLines: {
                        display: false
                    }
                }
            ],
            xAxes: [
                {
                    gridLines: {
                        display: false
                    }
                }
            ]
        }
    };
    // Hide labels
    const legend = {
        display: false
    };
    return (
        <React.Fragment>
            {values.length && (
                <React.Fragment>
                    <Bar
                        data={data}
                        legend={legend}
                        options={currentView == "0" ? options : options2}
                    />
                    <div className="graph-placeholder">
                        {/* needed to preserve in all resolutions */}
                        <Bar
                            data={data}
                            legend={legend}
                            options={currentView == "0" ? options : options2}
                            ref={!extra ? placeholder : null}
                        />
                    </div>
                </React.Fragment>
            )}
            {!values.length && <h3>Sin datos Existentes</h3>}
        </React.Fragment>
    );
};

export default _EntityGraph;
