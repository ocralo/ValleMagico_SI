import React from "react";

const CardRecomendation = ({
    dataInfo,
    title,
    idCard,
    show,
    idHeader,
    expander,
    infoRecomendation,
    isSubject
}) => {
    return (
        <div className="card-faq card">
            <button
                className="btn-faq btn"
                data-toggle="collapse"
                data-target={`#${idCard}`}
                aria-expanded={expander}
                aria-controls={idCard}
            >
                <div className="card-faq-header card-header" id={idHeader}>
                    <h5 className="mb-0">{title}</h5>
                </div>
            </button>

            <div
                id={idCard}
                className={`collapse ${show}`}
                aria-labelledby={idHeader}
                data-parent="#accordion"
            >
                <div className="card-body">
                    {isSubject &&
                        dataInfo.map((item, i) => (
                            <div key={i} className="mt-3 mb-3">
                                <div className="title-text-pdf">
                                    <label>{item.name}</label>
                                </div>
                                {item.subjects.map((subject, i) => (
                                    <div>
                                        {
                                            <div key={i}>
                                                <div>
                                                    <div className="subtitle-text-pdf">
                                                        <h5>
                                                            <strong>
                                                                {" "}
                                                                {subject.name
                                                                    .charAt(0)
                                                                    .toUpperCase() +
                                                                    subject.name.slice(
                                                                        1
                                                                    )}{" "}
                                                            </strong>
                                                        </h5>
                                                    </div>
                                                    <label>
                                                        <strong>
                                                            Rendimiento:{" "}
                                                        </strong>{" "}
                                                        {subject.performance}
                                                    </label>
                                                    <div>
                                                        <div className="subtitle-text-pdf py-2">
                                                            Recomendaciones
                                                        </div>
                                                        <label>
                                                            {
                                                                subject.recomendation
                                                            }
                                                        </label>
                                                    </div>
                                                    {subject.all_dbas.length >
                                                        0 && (
                                                        <div>
                                                            <label>
                                                                Estos son los
                                                                DBA que se debe
                                                                reforzar
                                                            </label>
                                                            <ul>
                                                                <dl>
                                                                    {subject.all_dbas.map(
                                                                        (
                                                                            text,
                                                                            i
                                                                        ) => (
                                                                            <dd
                                                                                key={
                                                                                    i
                                                                                }
                                                                            >
                                                                                {text !=
                                                                                    null && (
                                                                                    <li type="disc">
                                                                                        <div className="list-pdf py-1">
                                                                                            {
                                                                                                text
                                                                                            }
                                                                                        </div>
                                                                                    </li>
                                                                                )}
                                                                            </dd>
                                                                        )
                                                                    )}
                                                                </dl>
                                                            </ul>
                                                        </div>
                                                    )}
                                                </div>
                                            </div>
                                        }
                                    </div>
                                ))}
                            </div>
                        ))}
                    {isSubject == false &&
                        dataInfo.map((item, i) => (
                            <div key={i} className="mt-3 mb-3">
                                <div className="title-text-pdf">
                                    <label>{item.name}</label>
                                </div>
                                <div>
                                    <label>
                                        <strong>Puntaje:</strong> {item.average}
                                    </label>
                                </div>
                                <div>
                                    <div className="subtitle-text-pdf py-2">
                                        Recomendaciones
                                    </div>
                                    {infoRecomendation.find(
                                        recomendation =>
                                            recomendation.title === item.name
                                    ) === undefined && (
                                        <label>
                                            No se tiene ninguna recomendación
                                        </label>
                                    )}
                                    {infoRecomendation.find(
                                        recomendation =>
                                            recomendation.title === item.name
                                    ) !== undefined && (
                                        <label>
                                            {
                                                infoRecomendation.find(
                                                    recomendation =>
                                                        recomendation.title ===
                                                        item.name
                                                ).recomendation
                                            }
                                        </label>
                                    )}
                                </div>
                            </div>
                        ))}
                </div>
            </div>
        </div>
    );
};

export default CardRecomendation;
