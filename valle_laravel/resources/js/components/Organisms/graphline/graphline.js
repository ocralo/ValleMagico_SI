import React, { useState, useEffect, forwardRef } from 'react';
import { Bar } from 'react-chartjs-2';
import { useRouteMatch } from 'react-router-dom'

import 'chartjs-plugin-datalabels';

const Graphline = forwardRef(({ jsonApi, showAllData, typeGraph, limitsForyLabels, selectedButton, maxValue }, ref) => {
  const { params } = useRouteMatch();
  const [data, setData] = useState([]);
  const [label, setLabel] = useState([]);

  const [yLabels, setyLabels] = useState({
    yLabels: {
      0: 'Bajo', 20: 'Básico', 40: 'Medio', 60: 'Alto', 80: 'Superior', 100: ''
    },
    min: 0,
    max: 100
  })

  // // const [opti, setopti] = useState(initialState)

  const [isData, setIsData] = useState(false)

  // useEffect(() => {
  //   let dataAux = []
  //   let labelAux = []
  //   if (jsonApi.message === undefined && jsonApi.length > 0 ) {
  //     setIsData(true)
  //     if (params.filterGraph != showAllData) {
  //       jsonApi.map((item) => {
  //         if (changeCaseFirstLetter(item.name)  == params.filterGraph) {
  //           dataAux.push(item.average)
  //           labelAux.push( changeCaseFirstLetter(item.name) )
  //         }
  //       })

  //     } else {
  //       jsonApi.map((item) => {
  //         dataAux.push(item.average)
  //         labelAux.push(changeCaseFirstLetter(item.name) )
  //       })
  //     }
  //     setData(dataAux)
  //     setLabel(labelAux)
  //     // conditional for filter data and labels graph

  //   } else {
  //     setIsData(false)

  //   }
  //   if ( limitsForyLabels !=  undefined ) {
  //       setyLabels(limitsForyLabels)
  //   }
  // }, [params.filterGraph, jsonApi])

  useEffect(() => {
    let dataAux = []
    let labelAux = []
    if (jsonApi.message === undefined && jsonApi.length > 0) {
      setIsData(true)
      if (selectedButton != showAllData) {
        jsonApi.map((item) => {
          if (changeCaseFirstLetter(item.name) == selectedButton) {
            dataAux.push(item.average)
            labelAux.push(changeCaseFirstLetter(item.name))
          }
        })

      } else {
        jsonApi.map((item) => {
          dataAux.push(item.average)
          labelAux.push(changeCaseFirstLetter(item.name))
        })
      }
      setData(dataAux)
      setLabel(labelAux)
      // conditional for filter data and labels graph

    } else {
      setIsData(false)

    }
    if (limitsForyLabels != undefined) {
      setyLabels(limitsForyLabels)
    }
  }, [selectedButton, jsonApi])


  function changeCaseFirstLetter(params) {
    if (typeof params === 'string') {
      return params.charAt(0).toUpperCase() + params.slice(1)
    }
    return null
  }

  //  Data used for Graph
  const dataForGraph = {
    datasets: [
      {
        label: 'Puntaje',
        type: typeGraph,
        fill: false,
        lineTension: 0.1,
        borderWidth: 1,
        backgroundColor: 'rgba(114,107,98,0.6)',
        borderColor: 'rgba(86,80,74,1)',
        borderCapStyle: 'butt',
        borderDash: [],
        borderDashOffset: 0.0,
        borderJoinStyle: 'miter',
        pointBorderColor: 'rgba(114,107,98,1)',
        pointBackgroundColor: '#fff',
        pointBorderWidth: 5,
        pointHoverRadius: 5,
        pointHoverBackgroundColor: 'rgba(114,107,98,1)',
        pointHoverBorderColor: 'rgba(220,220,220,1)',
        pointHoverBorderWidth: 2,
        pointRadius: 1,
        pointHitRadius: 10,
        data: data,
      },
    ]
  }

  // Hide labels
  const legend = {
    display: false
  }

  // Change labels Y to text
  // const yLabels = {
  //   0: 'Sin evidencia', 33: 'Bajo', 66: 'Medio', 100: 'Alto', 110: ''
  // }

  const optionWithoutYLabels = {
    responsive: true,
    scales: {
      xAxes: [
        {
          display: true,
          gridLines: {
            display: false
          },
          labels: label,
        },
      ],
      yAxes: [{
        showAlways: true,
        ticks: {
          display: true,
          min: yLabels.min,
          max: maxValue
        }
      }]
    },
    plugins: {
      datalabels: {
        display: true,
        color: '#726B62',
        align: 'end',
        //  offset: 'top',
        anchor: 'end'
      }
    }
  }

  const optionWithLimitsYlabel = {
    responsive: true,
    scales: {
      xAxes: [
        {
          display: true,
          gridLines: {
            display: false
          },
          labels: label,
        },
      ],
      yAxes: [{
        showAlways: true,
        ticks: {
          callback: function (value, index, values) {
            return yLabels.yLabels[value];
          },
          display: true,
          min: yLabels.min,
          max: yLabels.max,
          stepSize: 1
        }
      }]
    },
    plugins: {
      datalabels: {
        display: true,
        color: '#726B62',
        align: 'end',
        //  offset: 'top',
        anchor: 'end'
      }
    }
  }


  if (isData) {
    return (
      <div className="row d-flex justify-content-center m-auto" ref={ref}>
        <Bar data={dataForGraph} legend={legend} options={limitsForyLabels != undefined ? optionWithLimitsYlabel : optionWithoutYLabels} />
      </div>
    );
  } else {
    return (
      <p className="text-center">
        Sin evidencia de datos
    </p>
    )
  }

})

export default Graphline;
