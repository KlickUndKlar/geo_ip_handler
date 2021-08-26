<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geoiphandler_domain_model_redirect',
        'label' => 'isocode',
        'label_alt' => 'target',
        'label_alt_force' => true,
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'tstamp' => 'tstamp',
        'versioningWS' => false,
        'default_sortby' => 'isocode, target',
        'rootLevel' => 1,
        'security' => [
            'ignoreWebMountRestriction' => true,
            'ignoreRootLevelRestriction' => true,
        ],
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => 'EXT:geo_ip_handler/ext_icon.png',
        'searchFields' => 'isocode,target',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general, --palette--;;source, --palette--;;targetdetails,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, --palette--;;visibility'
        ],
    ],
    'palettes' => [
        'visibility' => [
            'showitem' => 'hidden, --linebreak--, starttime, endtime'
        ],
        'source' => [
            'showitem' => 'isocode, --linebreak--, target, trigger'
        ]
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ]
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ]
        ],
        'isocode' => [
            'label' => 'LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geoiphandler_domain_model_redirect.isocode',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required,lower,unique'
            ],
        ],
        'target' => [
            'label' => 'LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geoiphandler_domain_model_redirect.target',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required',
                'max' => 2048
            ],
        ],
        'trigger' => [
            'exclude' => true,
            'label' => 'LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geoiphandler_domain_model_redirect.trigger',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geoiphandler_domain_model_redirect.trigger.in', 'in'],
                    ['LLL:EXT:geo_ip_handler/Resources/Private/Language/locallang_db.xlf:tx_geoiphandler_domain_model_redirect.trigger.out', 'out'],
                ],
                'default' => 'in',
                'size' => 1,
            ]
        ],
    ],
];
