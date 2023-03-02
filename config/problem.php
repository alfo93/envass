<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Training Mode
    |--------------------------------------------------------------------------
    |
    | Available values:
    | - "FullTraining" (trains and test onto the same 100% of data)
    | - [train_w, test_w] (train/test split according to these two weights)
    |
    */

    'trainingMode' => [
        .8,
        .2
    ],

    /*
    |--------------------------------------------------------------------------
    | Cut Off Value
    |--------------------------------------------------------------------------
    |
    | The cut off value is the value between 0 and 1 representing the minimum percentage
    | of any of the two classes (in the binary classification case) that is needed
    | for telling whether a dataset is too unbalanced to be good, or not.
    |
    */

    'cutOffValue' => 0.10,

    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    |
    | Default options, to be set via ->setDefaultOption().
    |
    */

    'defaultOptions' => [
        /* Default language for text pre-processing */
        [
            "textLanguage",
            "it"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Input Tables
    |--------------------------------------------------------------------------
    |
    | The database tables where the input columns are (array of table-terms, one for each table)
    |
    | For each table, the name must be specified. The name alone is sufficient for
    | the first specified table, so the first term can be the name in the form of a string (e.g. "patient").
    | For the remaining tables, join criteria can be specified, by means of 'joinClauses' and 'joinType'.
    | If one wants to specify these parameters, then the table-term should be an array
    |   [tableName, joinClauses=[], joinType="INNER JOIN"].
    | joinClauses is a list of 'MySQL constraint strings' such as "patent.ID = report.patientID",
    | used in the JOIN operation. If a single constraint is desired, then joinClauses can also simply be the string
    | representing the constraint (as compared to the array containing the single constraint).
    | The join type, defaulted to "INNER JOIN", is the MySQL type of join.
    | By default, an example of configuration is given.
    |
    */

    'inputTables' => [
        "referti",
        [
            "pazienti",
            "pazienti.id = referti.id_paziente",
            "LEFT JOIN"
        ],
        [
            "anamnesi",
            "anamnesi.id_referto = referti.id",
            "LEFT JOIN"
        ],
        [
            "diagnosi",
            "diagnosi.id_referto = referti.id",
            "LEFT JOIN"
        ],
        [
            "densitometrie",
            "densitometrie.id_referto = referti.id",
            "LEFT JOIN"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Where Clauses
    |--------------------------------------------------------------------------
    |
    | SQL WHERE clauses for the concerning inputTables (array of {array of strings, or single string})
    |
    | The input array provides, for each recursion level, the set of where clauses (to be joined with AND's).
    | For example:
    | - [["patient.Age > 30"]]
    | - ["patient.Age > 30"]
    |   -> at the first level: "...WHERE patient.Age > 30..."
    |   -> at the second level: (no WHERE clause)
    | - [["patient.Age > 30", "patient.Name IS NOT NULL"], []]
    |   -> at the first level: "...WHERE patient.Age > 30 AND patient.Name IS NOT NULL..."
    |   -> at the second level: (no WHERE clause)
    | By default, an example of configuration is given.
    |
    */

    'whereClauses' => [
        'default' => [
            /* Structural constraints */
            "pazienti.sesso = 'F'",
            "DATEDIFF(referti.data_referto,pazienti.data_nascita) / 365 >= 40",
        ],
        'onlyTraining' => [
            /* Structural constraints */
            "referti.data_referto > '2018-09-01'",
            "!ISNULL(anamnesi.stato_menopausale)",

            /* Constraints for manual cleaning */
            "anamnesi.bmi is NOT NULL",
            "anamnesi.bmi != -1",
            "referti.ai_eligibile = 1",
            "referti.stato >= 10",
            [
                "referti.id",
                "NOT IN",
                [
                    "reuse_current_query",
                    1,
                    [
                        "!ISNULL(raccomandazioni_terapeutiche.tipo)",
                        "ISNULL(principi_attivi.nome)"
                    ]
                ]
            ],
            [
                "referti.id",
                "NOT IN",
                [
                    "reuse_current_query",
                    1,
                    [],
                    [
                        "GROUP BY" => [
                            "raccomandazioni_terapeutiche.tipo",
                            "principi_attivi.nome",
                            "referti.id"
                        ],
                        "HAVING" => "COUNT(*) > 1"
                    ]
                ]
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Order By Clauses
    |--------------------------------------------------------------------------
    |
    | SQL ORDER BY clauses (array of strings, or single string)
    |
    | Differently from whereClauses, the ORDER BY clauses are fixed at all levels.
    | For example:
    | - [["patient.Age", "DESC"]]
    |   -> "...ORDER BY patient.ID DESC..."
    | - ["patient.Age", ["patient.ID", "DESC"]]
    |   -> "...ORDER BY patient.Age, patient.ID DESC..."
    | By default, an example of configuration is given.
    |
    */

    'orderByClauses' => [
        [
            "referti.data_referto",
            "ASC"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Identifier Column Name
    |--------------------------------------------------------------------------
    |
    | An identifier column, used for
    | - sql-based prediction
    | - a correct retrieval step of prediction results
    | Furthermore, a value for the identifier column identifies a set of data rows that are to be
    |   compressed into a single data instance before use.
    | By default, an example of configuration is given.
    |
    */

    'identifierColumnName' => "referti.id",

    /*
    |--------------------------------------------------------------------------
    | Input Columns
    |--------------------------------------------------------------------------
    |
    | Input columns. (array of inputColumn-terms, one for each column)
    |
    | For each input column, the name must be specified, and it makes up sufficient information.
    | As such, a term can simply be the name of the input column (e.g. "Age").
    | When dealing with more than one MySQL table, it is mandatory that each column name references the table
    | it belongs using the dot notation, as in "patient.Age".
    | Additional parameters can be supplied for managing the column pre-processing.
    | The generic form for a column-term is [columnName, treatment=NULL, attrName=columnName].
    | - A "treatment" for a column determines how to derive an attribute from the
    |    column data. For example, "YearsSince" translates each value of
    |    a date/datetime column into an attribute value representing the number of
    |    years since the date. "DaysSince", "MonthsSince" are also available.
    |   "DaysSince" is the default treatment for dates/datetimes
    |   "ForceCategorical" forces the corresponding attribute to be nominal. If the column is an enum fields,
    |   the enum domain will be inherited, otherwise a domain will be built using the unique values found in the column.
    |   "ForceCategoricalBinary" takes one step further and translates the nominal attribute to become a set of k binary
    |   attributes, with k the original number of classes.
    |
    |   For text fields, "BinaryBagOfWords" can be used to generate k binary attributes, each representing the presence
    |   of one of the most frequent words.
    |   When a treatment is desired, the column-term must be an array
    |    [columnName, treatment=NULL] (e.g. ["BirthDate", "ForceCategorical"])
    |   Treatments may require/allow arguments, and these can be supplied through
    |    an array instead of a simple string. For example, "BinaryBagOfWords"
    |    requires a parameter k, representing the size of the dictionary.
    |    As an example, the following term requires BinaryBagOfWords with k=10:
    |    ["Description", ["BinaryBagOfWords", 10]].
    |   The treatment for input column is defaulted to NULL, which implies no such pre-processing step.
    |   Note that the module complains whenever it encounter text fields with no treatment specified.
    |   When dealing with many text fields, consider setting the default option "textTreatment"
    |   via ->setDefaultOption(). For example, ->setDefaultOption("textTreatment", ["BinaryBagOfWords", 10]).
    | - The name of the attribute derived from the column can also be specified:
    |    for instance, ["BirthDate", "YearsSince", "Age"] creates an "Age" attribute
    |    by processing a "BirthDate" sql column.
    | By default, an example of configuration is given.
    |
    */
    'inputColumns' => [
        /* Age */
        [
            "0+DATEDIFF(referti.data_referto,pazienti.data_nascita) / 365",
            null,
            "age"
        ],

        /* Body Mass Index */
        [
            "0+IF(ISNULL(anamnesi.bmi) OR anamnesi.bmi = -1, NULL, anamnesi.bmi)",
            null,
            "body mass index"
        ],

        /* Gender */
        [
            "CONCAT('', pazienti.sesso)",
            "ForceCategorical",
            "gender"
        ],

        [
            "0+IF(ISNULL(referti.ai_eligibile) OR referti.ai_eligibile = -1, NULL, referti.ai_eligibile)",
            null,
            "ai_eligibile"
        ],

        /* Menopause State */
        [
            "CONCAT('', anamnesi.stato_menopausale)",
            "ForceCategorical",
            "menopause state"
        ],

        /* Age at last menopause */
        [
            "0+anamnesi.eta_menopausa",
            null,
            "age at last menopause"
        ],

        [
            "CONCAT('', COALESCE(anamnesi.terapia_stato,'Mai'))",
            "ForceCategorical",
            "therapy status"
        ],

        // TO DO
        // [
        //     "CONCAT('', COALESCE(IF(anamnesi.terapia_compliance,anamnesi.terapia_osteoprotettiva_ormonale,'0'),'0'))",
        //     "ForceCategorical",
        //     "hormonal osteoprotective therapy"
        // ],

        // [
        //     "CONCAT('', COALESCE(IF(anamnesi.terapia_compliance,anamnesi.terapia_osteoprotettiva_specifica,'0'),'0'))",
        //     "ForceCategorical",
        //     "specific osteoprotective therapy"
        // ],

        // [
        //     "CONCAT('', COALESCE(IF(anamnesi.terapia_compliance,anamnesi.vitamina_d_terapia_osteoprotettiva,'0'),'0'))",
        //     "ForceCategorical",
        //     "vitamin D based osteoprotective therapy"
        // ],
        // [
        //     "CONCAT('', COALESCE(IF(anamnesi.terapia_compliance,anamnesi.terapia_altro_checkbox,'0'),'0'))",
        //     "ForceCategorical",
        //     "other osteoprotective therapy"
        // ],

        /* Fragility fractures in spine (one or more) */
        [
            "CONCAT('', IF(ISNULL(anamnesi.frattura_vertebre),
            '0', anamnesi.frattura_vertebre))",
            "ForceCategorical",
            "vertebral fractures"
        ],

        /* Fragility fractures in hip (one or more) */
        [
            "CONCAT('', IF(ISNULL(anamnesi.frattura_femore), '0', anamnesi.frattura_femore))",
            "ForceCategorical",
            "femoral fractures"
        ],

        /* Fragility fractures in other sites (one or more) */
        [
            "CONCAT('', COALESCE(anamnesi.frattura_siti_diversi,0))",
            "ForceCategorical",
            "fractures in other sites"
        ],

        /* Familiarity */
        [
            "CONCAT('', COALESCE(anamnesi.frattura_familiarita,0))",
            "ForceCategorical",
            "fracture familiarity"
        ],

        /* Current smoker */
        [
            "CONCAT('', IF(ISNULL(anamnesi.abuso_fumo),'No',IF(anamnesi.abuso_fumo, anamnesi.abuso_fumo, 'No')))",
            "ForceCategorical",
            "smoking habits"
        ],

        /* Alcol abuse */
        [
            "CONCAT('', IF(ISNULL(anamnesi.alcol),NULL,IF(anamnesi.alcol, anamnesi.alcol, 'No')))",
            "ForceCategorical",
            "alcohol intake"
        ],

        /* Current corticosteoroid use */
        [
            "CONCAT('', IF(ISNULL(anamnesi.uso_cortisone),'No',IF(anamnesi.uso_cortisone, anamnesi.uso_cortisone, 'No')))",
            "ForceCategorical",
            "cortisone"
        ],

        /* Current illnesses */
        [
            "CONCAT('', COALESCE(anamnesi.malattie_attuali_artrite_reum,0))",
            "ForceCategorical",
            "rheumatoid arthritis"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.malattie_attuali_artrite_psor,0))",
            "ForceCategorical",
            "psoriatic arthritis"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.malattie_attuali_lupus,0))",
            "ForceCategorical",
            "systemic lupus"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.malattie_attuali_sclerodermia,0))",
            "ForceCategorical",
            "scleroderma"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.malattie_attuali_altre_connettiviti,0))",
            "ForceCategorical",
            "other connective tissue diseases"
        ],

        /* Secondary causes */
        [
            "CONCAT('', COALESCE(anamnesi.diabete_insulino_dipendente,0))",
            "ForceCategorical",
            "diabetes mellitus"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.menopausa_prematura,0))",
            "ForceCategorical",
            "early menopause"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.malnutrizione_cronica,0))",
            "ForceCategorical",
            "chronic malnutrition"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.osteogenesi_imperfecta_in_eta_adulta,0))",
            "ForceCategorical",
            "adult osteogenesis imperfecta"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.ipertiroidismo_non_trattato_per_lungo_tempo,0))",
            "ForceCategorical",
            "untreated chronic hyperthyroidism"
        ],

        /* FRAX */
        [
            "IF(ISNULL(diagnosi.algoritmi_non_applicabile),0+IF(ISNULL(diagnosi.frax_fratture_maggiori_percentuale_01),NULL,IF(diagnosi.frax_fratture_maggiori_percentuale_01 OR diagnosi.frax_fratture_maggiori < 0.1, 0, diagnosi.frax_fratture_maggiori)),NULL)",
            null,
            "FRAX (major fractures)"
        ],

        /* DeFRA */
        [
            "IF(ISNULL(diagnosi.algoritmi_non_applicabile),0+IF(ISNULL(diagnosi.defra_percentuale_01),NULL,IF((diagnosi.defra_percentuale_01 OR diagnosi.defra < 0.1) AND diagnosi.defra_percentuale_50 = 0, 0,IF(ISNULL(diagnosi.defra_percentuale_50),NULL,IF(diagnosi.defra_percentuale_50 OR diagnosi.defra > 50, 50, diagnosi.defra)))),NULL)",
            null,
            "DeFRA"],

        /* Clinical information (20 fields) */
        [
            "CONCAT('', COALESCE(anamnesi.patologie_uterine,0))",
            "ForceCategorical",
            "endometrial pathologies"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.neoplasia,0))",
            "ForceCategorical",
            "breast cancer"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.sintomi_vasomotori,0))",
            "ForceCategorical",
            "vasomotor symptoms"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.sintomi_distrofici,0))",
            "ForceCategorical",
            "distrofic symptoms"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.dislipidemia,0))",
            "ForceCategorical",
            "dyslipidemia"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.ipertensione,0))",
            "ForceCategorical",
            "hypertension"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.rischio_tev,0))",
            "ForceCategorical",
            "venous thromboembolism risk factors"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.patologia_cardiaca,0))",
            "ForceCategorical",
            "cardiac pathologies"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.patologia_vascolare,0))",
            "ForceCategorical",
            "vascular pathologies"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.insufficienza_renale,0))",
            "ForceCategorical",
            "kidney failure"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.patologia_respiratoria,0))",
            "ForceCategorical",
            "respiratory pathologies"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.patologia_cavo_orale,0))",
            "ForceCategorical",
            "oral pathologies"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.parologia_esofagea,0))",
            "ForceCategorical",
            "esophageal pathologies"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.gastro_duodenite,0))",
            "ForceCategorical",
            "gastroduodenitis"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.gastro_resezione,0))",
            "ForceCategorical",
            "gastrectomy"
        ],
        [
            "CONCAT('', COALESCE(anamnesi.resezione_intestinale,0))",
            "ForceCategorical",
            "bowel resection"
        ],
        [
            "0+anamnesi.vitamina_d",
            null,
            "vitamin D-25OH"
        ],
        /* Previous DXA spine total T score */
        [
            "0+anamnesi.colonna_t_score",
            null,
            "previous spine T-score"
        ],
        /* Previous DXA spine total Z score */
        [
            "0+anamnesi.colonna_z_score",
            null,
            "previous spine Z-score"
        ],
        /* Previous DXA hip total T score */
        [
            "0+anamnesi.femore_t_score",
            null,
            "previous neck T-score"
        ],
        /* Previous DXA hip total Z score */
        [
            "0+anamnesi.femore_z_score",
            null,
            "previous neck Z-score"
        ],

        [
            "CONCAT('', IF(CONCAT('', IF(ISNULL(anamnesi.frattura_vertebre), '0', anamnesi.frattura_vertebre)) != '0' OR CONCAT('', IF(ISNULL(anamnesi.frattura_femore), '0', anamnesi.frattura_femore)) != '0','1',diagnosi.osteoporosi_grave))",
            "ForceCategorical",
            "severe osteoporosis"
        ],

        // [
        //     "CONCAT('', IF(diagnosi.situazione_femore_sn_checkbox, diagnosi.situazione_femore_sn, IF(diagnosi.situazione_femore_dx_checkbox, diagnosi.situazione_femore_dx, NULL)))",
        //     "ForceCategorical",
        //     "femur status"
        // ],

        // [
        //     "CONCAT('', diagnosi.situazione_femore_sn, diagnosi.situazione_femore_dx)",
        //     "ForceCategorical",
        //     "femur status"
        // ],

        [
            "CONCAT('', IF(diagnosi.situazione_femore_sn, diagnosi.situazione_femore_sn, IF(diagnosi.situazione_femore_dx, diagnosi.situazione_femore_dx, NULL)))",
            "ForceCategorical",
            "femur status"
        ],

        /* Spine (normal, osteopenic, osteoporotic) */
        [
            "CONCAT('', diagnosi.situazione_colonna)",
            "ForceCategorical",
            "spine status"
        ],

        /* Current DXA spine total T score */
        [
            "0+densitometrie.tot_t_score",
            null,
            "spine T-score"
        ],
        /* Current DXA spine total Z score */
        [
            "0+densitometrie.tot_z_score",
            null,
            "spine Z-score"
        ],
        /* Current DXA hip total T score */
        /*  TODO maybe here we want to consider them as the same attribute? Is it relevant they are separated in l/r? */
        [
            "0+densitometrie.neck_l_t_score",
            null,
            "neck left T-score"
        ],
        [
            "0+densitometrie.neck_r_t_score",
            null,
            "neck right T-score"
        ],
        /* Current DXA hip total Z score */
        /*  TODO maybe here we want to consider them as the same attribute? Is it relevant they are separated in l/r? */
        [
            "0+densitometrie.neck_l_z_score",
            null,
            "neck left Z-score"
        ],
        [
            "0+densitometrie.neck_r_z_score",
            null,
            "neck right Z-score"
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Output Columns
    |--------------------------------------------------------------------------
    |
    | Columns that are to be treated as output.
    |   (array of outputColumn-terms, one for each column)
    |
    | This module supports hierarchical models. This means that a unique DBFit object can be used to train different
    | models at predicting different output columns that are inter-related, with different sets of data.
    | In the simplest case, the user specifies a unique output column, from which M attributes are generated.
    | Then, M models are generated, each predicting an attribute value, which is then used for deriving a value for
    | the output column.
    | One can then take this a step further and, for each of the M models, independently train K models, where K is
    | the number of output classes of the attribute, using data that is only relevant to that given output class and
    | model. Generally, this hierarchical training and prediction structur takes the form of a tree with depth O
    | (number of "nested" outputColumns).
    | Having said this, the outputColumns array specifies one column per each depth of the recursion tree.
    |
    | outputColumn-terms are very similar to inputColumn-terms (see documentation for inputColumns a few lines above),
    | with a few major differences:
    | - The default treatment is "ForceCategorical": note, in fact, that output columns must generate categorical
    | attributes (this module only supports classification and not regression). Also consider using
    | "ForceCategoricalBinary", which breaks a nominal class attribute into k disjoint binary attributes.
    | - Each output column can be derived from join operations (thus it can also belong to inputTables that are not
    | in $this->inputTables).
    | Additional join criteria can be specified using table-terms format (see documentation for inputTables).
    | The format for an outputColumn is thus [columnName, tables=[], treatment="ForceCategorical"].
    | TODO [ ... , attrName=columnName], where tables is an array of table-terms.
    |
    | As such, the following is a valid outputColumns array:
    | [
    |   // first outputColumn
    |   ["report.Status",
    |     [
    |       ["RaccomandazioniTerapeuticheUnitarie",
    |           ["RaccomandazioniTerapeuticheUnitarie.ID_RACCOMANDAZIONE_TERAPEUTICA = RaccomandazioniTerapeutiche.ID"]]
    |     ],
    |     "ForceCategoricalBinary"
    |   ],
    |   // second outputColumn
    |   ["PrincipiAttivi.NOME",
    |     [
    |       ["ElementiTerapici", ["report.ID = Recommandations.reportID"]],
    |       ["PrincipiAttivi", "ElementiTerapici.PrAttID = PrincipiAttivi.ID"]
    |     ]
    |   ]
    | ]
    | By default, an example of configuration is given.
    |
    */

    'outputColumns' => [
        [
            "raccomandazioni_terapeutiche.tipo",
            [
                [
                    "raccomandazioni_terapeutiche",
                    [
                        "raccomandazioni_terapeutiche.id_referto = referti.id",
                        "raccomandazioni_terapeutiche.tipo != 'Indagini approfondimento'"
                    ],
                    "LEFT JOIN"
                ]
            ],
            "ForceCategoricalBinary",
            "Terapia"
        ],
        [
            "principi_attivi.nome",
            [
                [
                    "raccomandazioni_terapeutiche_unitarie",
                    [
                        "raccomandazioni_terapeutiche.id = raccomandazioni_terapeutiche_unitarie.id_raccomandazione_terapeutica"
                    ],
                    "LEFT JOIN"
                ],
                [
                    "principi_attivi",
                    [
                        "raccomandazioni_terapeutiche_unitarie.id_principio_attivo = principi_attivi.id"
                    ],
                    "LEFT JOIN"
                ]
            ],
            "ForceCategoricalBinary",
            "PrincipioAttivo"
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Global Node Order
    |--------------------------------------------------------------------------
    | This array is used to tweak the (generally random) order in which the problems are discovered and solved.
    | By default, an example of configuration is given.
    |
    */

    'globalNodeOrder' => [
        "Terapie ormonali",
        "Terapie osteoprotettive",
        "Vitamina D terapia",
        "Vitamina D Supplementazione",
        "Calcio supplementazione",
        "Alendronato",
        "Denosumab",
        "Risedronato",
        "Calcifediolo",
        "Colecalciferolo",
        "Calcio citrato",
        "Calcio carbonato",
        "Teriparatide",
        "Clodronato",
        "Zoledronato",
        "Ibandronato",
        "Bazedoxifene",
        "Raloxifene"
    ],
];
