export const ApiLevel = {
    pdfKnowledgeAreas: `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/pdf/knowledgeArea`,
    pdfintelligences: `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/pdf/intelligences`,
    pdfStyles: `${process.env.OPEN_VALLE_MAGICO_URL}api/pdf/styles`,
    pdfVocations: `${process.env.OPEN_VALLE_MAGICO_URL}api/pdf/vocations`,
    statsArea: `${process.env.OPEN_VALLE_MAGICO_URL}api/testareas`,
    statsIntelligences: `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/testintelligences`,
    statsStyles: `${process.env.OPEN_VALLE_MAGICO_URL}api/teststyles`,
    statsCompetences: `${process.env.OPEN_VALLE_MAGICO_URL}api/testcompetences`,
    statsRecomendationsAreas: `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/testRecomendationsAreas`,
    statsRecomendationsIntelligences: `${
        process.env.OPEN_VALLE_MAGICO_URL
    }api/testRecomendationsIntelligences`,

    1: {
        games_played: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }gamesPlayed/department`,
        listEntities: `${process.env.OPEN_VALLE_MAGICO_URL}infoUser/deparments`,

        knowledgeAreas: `${process.env.OPEN_VALLE_MAGICO_URL}department`,
        intelligences: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }intelligences/department`,
        styles: `${process.env.OPEN_VALLE_MAGICO_URL}styles/department`,
        competences: {
            intelligences: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/intelligences/department`,
            styles: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/styles/department`
        },
        recomendations: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }recomendations/department`,
        children: `${process.env.OPEN_VALLE_MAGICO_URL}api/townsByDepartment`,
        excel: `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByDepartment`
    },
    2: {
        games_played: `${process.env.OPEN_VALLE_MAGICO_URL}gamesPlayed/town`,
        listEntities: `${process.env.OPEN_VALLE_MAGICO_URL}infoUser/towns`,

        knowledgeAreas: `${process.env.OPEN_VALLE_MAGICO_URL}town`,
        intelligences: `${process.env.OPEN_VALLE_MAGICO_URL}intelligences/town`,
        styles: `${process.env.OPEN_VALLE_MAGICO_URL}styles/town`,
        competences: {
            intelligences: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/intelligences/town`,
            styles: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/styles/town`
        },
        recomendations: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }recomendations/town`,
        children: `${process.env.OPEN_VALLE_MAGICO_URL}api/institutionsByTown`,
        excel: `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByTown`
    },
    3: {
        games_played: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }gamesPlayed/institution`,
        listEntities: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }infoUser/institutions`,

        knowledgeAreas: `${process.env.OPEN_VALLE_MAGICO_URL}institution`,
        intelligences: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }intelligences/institution`,
        styles: `${process.env.OPEN_VALLE_MAGICO_URL}styles/institution`,
        competences: {
            intelligences: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/intelligences/institution`,
            styles: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/styles/institution`
        },
        recomendations: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }recomendations/institution`,
        children: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }api/headquartersByInstitution`,
        excel: `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByInstitution`
    },
    4: {
        games_played: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }gamesPlayed/headquarter`,
        listEntities: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }infoUser/headquarters`,

        knowledgeAreas: `${process.env.OPEN_VALLE_MAGICO_URL}headquarter`,
        intelligences: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }intelligences/headquarter`,
        styles: `${process.env.OPEN_VALLE_MAGICO_URL}styles/headquarter`,
        competences: {
            intelligences: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/intelligences/headquarter`,
            styles: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/styles/headquarter`
        },
        recomendations: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }recomendations/headquarter`,
        children: `${process.env.OPEN_VALLE_MAGICO_URL}api/groupsByHeadquarter`,
        excel: `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByHeadquarter`
    },
    5: {
        games_played: `${process.env.OPEN_VALLE_MAGICO_URL}gamesPlayed/grade`,
        listEntities: `${process.env.OPEN_VALLE_MAGICO_URL}infoUser/grades`,

        knowledgeAreas: `${process.env.OPEN_VALLE_MAGICO_URL}grade`,
        intelligences: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }intelligences/grade`,
        styles: `${process.env.OPEN_VALLE_MAGICO_URL}styles/grade`,
        competences: {
            intelligences: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/intelligences/grade`,
            styles: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/styles/grade`
        },
        recomendations: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }recomendations/grade`,
        children: `${process.env.OPEN_VALLE_MAGICO_URL}api/studentsByGroup`,
        excel: `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByHeadquarterGroup`
    },
    6: {
        games_played: `${process.env.OPEN_VALLE_MAGICO_URL}gamesPlayed/student`,
        listEntities: `${process.env.OPEN_VALLE_MAGICO_URL}infoUser/students`,

        knowledgeAreas: `${process.env.OPEN_VALLE_MAGICO_URL}student`,
        intelligences: `${process.env.OPEN_VALLE_MAGICO_URL}intelligences`,
        styles: `${process.env.OPEN_VALLE_MAGICO_URL}styles`,
        competences: {
            intelligences: `${
                process.env.OPEN_VALLE_MAGICO_URL
            }competences/intelligences`,
            styles: `${process.env.OPEN_VALLE_MAGICO_URL}competences/styles`
        },
        recomendations: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }recomendations/student`,
        games_played_byGrade: `${
            process.env.OPEN_VALLE_MAGICO_URL
        }byGrade/student`,
        excel: `${process.env.OPEN_VALLE_MAGICO_URL}api/dataByStudent`
    }
};

export const StringLevel = {
    1: {
        singular: "departamento",
        plural: "departamentos",
        arts: "el",
        artp: "los"
    },
    2: {
        singular: "municipio",
        plural: "municipios",
        arts: "el",
        artp: "los"
    },
    3: {
        singular: "institucion",
        plural: "instituciones",
        arts: "la",
        artp: "las"
    },
    4: {
        singular: "sede",
        plural: "sedes",
        arts: "la",
        artp: "las"
    },
    5: {
        singular: "grupo",
        plural: "grupos",
        singularAlt: "grado",
        pluralALt: "grados",
        arts: "el",
        artp: "los"
    },
    6: {
        singular: "estudiante",
        plural: "estudiantes",
        arts: "el",
        artp: "los"
    }
};
