import React, { useEffect, useState } from 'react'
import TabsGraph from '../../Molecules/tabsGraph'
import GraphLine from '../graphline/graphline'

import { Switch, Route, Redirect, useRouteMatch } from 'react-router-dom'
import TittleTab from '../../Atoms/tittleTab'

const CardGraph = ({ jsonApi, showAllData, typeGraph, limitsForyLabels, titleCard }) => {
    const [tabsFilter, settabsFilter] = useState([
        { id: "General" }
    ])

    const [isActivateButton, setisActivateButton] = useState("General")

    const [isTabsFilter, setisTabsFilter] = useState(false)

    const [maxValue, setmaxValue] = useState(0)

    const { url } = useRouteMatch()

    useEffect(() => {
        settabsFilter([{ id: "General" }])
        getTabsFilter()
        getMaxValue()
    }, [jsonApi])

    function getMaxValue() {
        if (Array.isArray(jsonApi) && jsonApi.length > 0) {

            let jsonApiSort = jsonApi.sort(function (a, b) {
                if (a.average < b.average) {
                    return 1;
                }
                if (a.average > b.average) {
                    return -1;
                }
                // a must be equal to b
                return 0;
            });
            setmaxValue(parseInt(jsonApiSort.slice(0, 1)[0].average + 5))
        }
    }


    function getTabsFilter() {
        if (jsonApi.message === undefined) {
            setisTabsFilter(true)
            jsonApi.map(
                (item) => settabsFilter(tabsFilter => (
                    [...tabsFilter, { id: changeCaseFirstLetter(item.name) }]
                ))
            )




        } else {
            setisTabsFilter(false)
        }
    }

    function changeCaseFirstLetter(params) {
        if (typeof params === 'string') {
            return params.charAt(0).toUpperCase() + params.slice(1)
        }
        return null
    }

    function changeActivateButton(e) {
        setisActivateButton(e)
    }


    return (
        <div className="container">
            <div className="row">
                <div className="card col mb-3 px-4">
                    <div className="card-body justify-content-center">
                        {
                            titleCard !== undefined &&
                            <TittleTab tittle={`${titleCard}`} />
                        }
                        {
                            isTabsFilter == true &&
                            <TabsGraph tabs={tabsFilter} selectedButton={isActivateButton} changeActivateButton={changeActivateButton} />
                        }
                        <GraphLine jsonApi={jsonApi} showAllData={showAllData} typeGraph={typeGraph} limitsForyLabels={limitsForyLabels} selectedButton={isActivateButton} maxValue={maxValue} />

                    </div>
                </div>
            </div>
        </div>
    )
}

export default CardGraph;