import React, { useState, useEffect, useContext } from "react";
import _EntityGraph from "./_entityGraph/_entityGraph";
import _LoadingPage from "../../../loadingPage/loadingPage";
import _EntityRecomendationsAcordion from "./_entityRecomendationsAcordion/_entityRecomendationsAcordion";

import { EntityContext, EntityTypeContext } from "../../_context/_context";

import { fetchApi } from "../../../../../function/GlobalFunctions";

import { ApiLevel } from "../../_constants/_constants";

const _EntityDetailContent = ({ currentView }) => {
    const [isLoading, setIsLoading] = useState(true);
    const [data, setData] = useState({
        data: {},
        dataGrade: {}
    });

    const { currentEntity } = useContext(EntityContext);
    const { entityType } = useContext(EntityTypeContext);

    useEffect(() => {
        setIsLoading(true);
        getData();
    }, [currentView, currentEntity]);

    const getData = async () => {
        let infoData = { ...data };
        let endpoint;
        let endpoint2;
        switch (currentView) {
            case 0:
                endpoint = `${ApiLevel.statsArea}/${entityType}/${
                    currentEntity.id
                }`;
                infoData.data = await fetchApi(endpoint);
                break;
            case 1:
                endpoint = `${ApiLevel.statsIntelligences}/${entityType}/${
                    currentEntity.id
                }`;
                infoData.data = await fetchApi(endpoint);
                break;
            case 2:
                endpoint = `${ApiLevel.statsStyles}/${entityType}/${
                    currentEntity.id
                }`;
                infoData.data = await fetchApi(endpoint);
                break;
            case 3:
                /* endpoint = `${statsCompetences[entityType].competences.intelligences}/${
                    currentEntity.id
                }`; */
                endpoint = `${ApiLevel.statsCompetences}/${entityType}/${
                    currentEntity.id
                }`;
                infoData.data = await fetchApi(endpoint);
                break;
            case 4:
                /* endpoint = `${
                    statsCompetences[entityType].competences.intelligences
                }/${currentEntity.id}`; */
                endpoint = `${
                    ApiLevel.statsRecomendationsAreas
                }/${entityType}/${currentEntity.id}`;
                endpoint2 = `${
                    ApiLevel.statsRecomendationsIntelligences
                }/${entityType}/${currentEntity.id}`;

                let recomendations = await fetchApi(endpoint);
                let intelligences = await fetchApi(endpoint2);
                let response = {
                    recomendations: recomendations.recomendation,
                    intelligences: intelligences.recomendation
                };
                infoData.data = response;
                //infoData = undefined;
                break;
            default:
                infoData.data = {};
                break;
        }
        setData(infoData.data);
        setIsLoading(false);
    };

    const switchView = () => {
        switch (currentView) {
            case 0:
            case 1:
            case 2:
                return (
                    <div className="row">
                        <div className="col-md-12">
                            <div className="card p-4">
                                <h4 className="mb-4">
                                    Promedio de asignaturas
                                </h4>
                                <div className="container-fluid">
                                    <div className="row justify-content-center">
                                        <div className="col-md-10">
                                            <_EntityGraph
                                                currentView={currentView}
                                                values={
                                                    Array.isArray(data.data)
                                                        ? data.data.map(
                                                              d => d.average
                                                          )
                                                        : []
                                                }
                                                labels={
                                                    Array.isArray(data.data)
                                                        ? data.data.map(
                                                              d => d.name
                                                          )
                                                        : []
                                                }
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {entityType === 6 && currentView === 0 ? (
                            <div className="col-12 mx-auto mt-2">
                                <div className="card p-4">
                                    {data.dataGrade
                                        ? Object.entries(data.dataGrade).map(
                                              ([key, value]) => {
                                                  return (
                                                      <>
                                                          <h4>
                                                              Grado:{" "}
                                                              {key.toUpperCase()}
                                                          </h4>
                                                          <_EntityGraph
                                                              extra={true}
                                                              currentView={
                                                                  currentView
                                                              }
                                                              values={
                                                                  Array.isArray(
                                                                      value
                                                                  )
                                                                      ? value.map(
                                                                            d =>
                                                                                d.average
                                                                        )
                                                                      : []
                                                              }
                                                              labels={
                                                                  Array.isArray(
                                                                      value
                                                                  )
                                                                      ? value.map(
                                                                            d =>
                                                                                d.name
                                                                        )
                                                                      : []
                                                              }
                                                          />
                                                      </>
                                                  );
                                              }
                                          )
                                        : ""}
                                </div>
                            </div>
                        ) : (
                            ""
                        )}
                    </div>
                );
                break;

            case 3:
                return (
                    <React.Fragment>
                        {typeof data.data === "object" ? (
                            Object.entries(data.data).map(([key, value]) => {
                                return (
                                    <div
                                        className="card p-4 my-3"
                                        key={"dato-" + key}
                                    >
                                        <div className="container-fluid">
                                            <div className="row mb-4">
                                                <div className="col-12">
                                                    <h3 className="text-uppercase">
                                                        {key}
                                                    </h3>
                                                </div>
                                            </div>
                                            <div className="row justify-content-center">
                                                <div className="col-md-6 mt-2">
                                                    <h4 className="text-center text-uppercase text-primary-color mb-2">
                                                        Inteligencias Múltiples
                                                    </h4>
                                                    <_EntityGraph
                                                        values={
                                                            Array.isArray(
                                                                value.intelligences
                                                            )
                                                                ? value.intelligences.map(
                                                                      d =>
                                                                          d.average
                                                                  )
                                                                : []
                                                        }
                                                        labels={
                                                            Array.isArray(
                                                                value.intelligences
                                                            )
                                                                ? value.intelligences.map(
                                                                      d =>
                                                                          d.name.toUpperCase()
                                                                  )
                                                                : []
                                                        }
                                                    />
                                                </div>
                                                <div className="col-md-6 mt-2">
                                                    <h4 className="text-center text-uppercase text-primary-color mb-2">
                                                        Estilos de aprendizaje
                                                    </h4>
                                                    <_EntityGraph
                                                        values={
                                                            Array.isArray(
                                                                value.styles
                                                            )
                                                                ? value.styles.map(
                                                                      d =>
                                                                          d.average
                                                                  )
                                                                : []
                                                        }
                                                        labels={
                                                            Array.isArray(
                                                                value.styles
                                                            )
                                                                ? value.styles.map(
                                                                      d =>
                                                                          d.name.toUpperCase()
                                                                  )
                                                                : []
                                                        }
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                );
                            })
                        ) : (
                            <div className="col-12 mt-2">
                                <div className="card p-4">
                                    <h4>No hay datos existentes</h4>
                                </div>
                            </div>
                        )}
                    </React.Fragment>
                );
                break;

            case 4:
                return (
                    <div className="row">
                        <div className="col-12">
                            <div className="card p-4">
                                <h2>Recomendaciones</h2>
                                {typeof data === "object" ? (
                                    <_EntityRecomendationsAcordion
                                        data={data}
                                    />
                                ) : (
                                    "nonas"
                                )}
                            </div>
                        </div>
                    </div>
                );
                break;

            default:
                return "Not available";
                break;
        }
    };
    return (
        <div>
            {isLoading && (
                <div style={{ transform: "scale(0.5)" }}>
                    <_LoadingPage />
                </div>
            )}
            {!isLoading && switchView()}
        </div>
    );
};

export default _EntityDetailContent;
