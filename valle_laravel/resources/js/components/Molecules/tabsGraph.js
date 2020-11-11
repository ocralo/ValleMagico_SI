import React from 'react'

import ButtonTab from '../Atoms/buttonTabs'

const TabsGraph = ({ tabs , selectedButton, changeActivateButton }) => {

    

    return (
        <div className="row justify-content-around d-none d-xl-flex m-auto px-3 pb-3">
            {
                tabs.map(
                    (tab, i) =>
                        <ButtonTab key={i} id={tab.id} selectedButton={selectedButton} changeActivateButton={changeActivateButton}/>
                )
            }
        </div>
    )
}

export default TabsGraph;