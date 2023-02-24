<?php

use Terminal42\LeadsBundle\Export\ExporterInterface;

$GLOBALS['TL_DCA']['tl_lead_export'] = [
    'config' => [
        'dataContainer' => \Contao\DC_Table::class,
        'ptable' => 'tl_form',
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
                'pid' => 'index',
            ],
        ],
    ],
    'list' => [
        'sorting' => [
            'mode' => \Contao\DataContainer::SORT_INITIAL_LETTERS_DESC,
            'fields' => ['type', 'name'],
            'headerFields' => ['title', 'tstamp', 'leadEnabled', 'leadMaster', 'leadMenuLabel', 'leadLabel'],
            'panelLayout' => 'filter;search,limit',
        ],
        'label' => [
            'fields' => ['name', 'export', 'filename'],
            'format' => '<div style="display:flex"><div style="width:50%%;margin-right:10px;font-weight:500">%s</div><div style="width:30%%;margin-right:10px">%s</div><div style="width:20%%;">%s</div></div>'
        ],
        'global_operations' => [
            'all' => [
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations' => [
            'edit' => [
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'copy' => [
                'href' => 'act=paste&amp;mode=copy',
                'icon' => 'copy.svg',
            ],
            'cut' => [
                'href' => 'act=paste&amp;mode=cut',
                'icon' => 'cut.svg',
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? '').'\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],
    'palettes' => [
        '__selector__' => ['type', 'useTemplate', 'export'],
        'default' => '{name_legend},name,type,filename;{data_legend},headerFields,export;{date_legend:hide},lastRun,skipLastRun',
        'csv' => '{name_legend},name,type,filename;{data_legend},headerFields,export;{csv_legend:hide},csvSeparator,csvEnclosure,csvEscape,eol;{date_legend:hide},lastRun,skipLastRun',
        'xls' => '{name_legend},name,type,filename;{data_legend},headerFields,export;{excel_legend:hide},useTemplate;{date_legend:hide},lastRun,skipLastRun',
        'xlsx' => '{name_legend},name,type,filename;{data_legend},headerFields,export;{excel_legend:hide},useTemplate;{date_legend:hide},lastRun,skipLastRun',
    ],
    'subpalettes' => [
        'export_fields' => 'fields',
        'export_tokens' => 'tokenFields',
        'useTemplate' => 'template,startIndex,sheetIndex',
    ],
    'fields' => [
        'id' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'autoincrement' => true],
        ],
        'pid' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
            'relation' => ['table' => 'tl_lead', 'type' => 'belongsTo'],
        ],
        'tstamp' => [
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'name' => [
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'default' => ''],
        ],
        'type' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'eval' => [
                'mandatory' => true,
                'submitOnChange' => true,
                'includeBlankOption' => true,
                'tl_class' => 'w50',
            ],
            'sql' => ['type' => 'string', 'length' => 32, 'default' => ''],
        ],
        'filename' => [
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['decodeEntities' => true, 'maxlength' => 128, 'helpwizard' => true, 'tl_class' => 'w50'],
            'explanation' => 'leadsTags',
            'sql' => ['type' => 'string', 'length' => 128, 'default' => ''],
        ],
        'headerFields' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr'],
            'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
        ],
        'export' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'radio',
            'options' => [ExporterInterface::EXPORT_ALL, ExporterInterface::EXPORT_FIELDS, ExporterInterface::EXPORT_TOKENS],
            'reference' => &$GLOBALS['TL_LANG']['tl_lead_export']['export'],
            'eval' => ['mandatory' => true, 'submitOnChange' => true, 'tl_class' => 'clr'],
            'sql' => ['type' => 'string', 'length' => 8, 'default' => ExporterInterface::EXPORT_ALL],
        ],
        'fields' => [
            'exclude' => true,
            'inputType' => 'multiColumnWizard',
            'eval' => [
                'mandatory' => true,
                'dragAndDrop' => true,
                'columnFields' => [
                    'column_display' => [
                        'input_field_callback' => static fn () => '',
                        'eval' => ['tl_class' => 'column_display', 'hideHead' => true],
                    ],
                    'field' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['fields']['field'],
                        'inputType' => 'select',
                        'eval' => ['mandatory' => true, 'style' => 'width:150px;'],
                    ],
                    'name' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['fields']['name'],
                        'inputType' => 'text',
                        'eval' => ['style' => 'width:150px;'],
                    ],
                    'output' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['fields']['output'],
                        'inputType' => 'select',
                        'options' => [ExporterInterface::OUTPUT_LABEL, ExporterInterface::OUTPUT_BOTH, ExporterInterface::OUTPUT_VALUE],
                        'reference' => &$GLOBALS['TL_LANG']['tl_lead_export']['fields']['output'],
                        'eval' => ['style' => 'width:125px;'],
                    ],
                    'format' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['fields']['format'],
                        'inputType' => 'select',
                        'eval' => ['includeBlankOption' => true, 'blankOptionLabel' => &$GLOBALS['TL_LANG']['tl_lead_export']['fields']['format'][2], 'style' => 'width:150px;'],
                    ],
                ],
            ],
            'sql' => [
                'type' => 'blob',
                'length' => \Doctrine\DBAL\Platforms\MySqlPlatform::LENGTH_LIMIT_MEDIUMBLOB,
                'notnull' => false,
            ],
        ],
        'tokenFields' => [
            'exclude' => true,
            'inputType' => 'multiColumnWizard',
            'eval' => [
                'mandatory' => true,
                'dragAndDrop' => true,
                'columnFields' => [
                    'targetColumn' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['tokenFields']['targetColumn'],
                        'inputType' => 'text',
                        'eval' => ['mandatory' => true, 'style' => 'width:50px;'],
                    ],
                    'headerField' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['tokenFields']['headerField'],
                        'inputType' => 'text',
                        'eval' => ['style' => 'width:100px;'],
                    ],
                    'tokensValue' => [
                        'label' => &$GLOBALS['TL_LANG']['tl_lead_export']['tokenFields']['tokensValue'],
                        'inputType' => 'textarea',
                        'eval' => ['decodeEntities' => true, 'style' => 'width:420px;'],
                    ],
                ],
            ],
            'sql' => ['type' => 'blob', 'length' => \Doctrine\DBAL\Platforms\MySqlPlatform::LENGTH_LIMIT_MEDIUMBLOB, 'notnull' => false],
        ],

        'csvSeparator' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 4, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'length' => 4, 'default' => ','],
        ],
        'csvEnclosure' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 4, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'length' => 4, 'default' => '"'],
        ],
        'csvEscape' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 4, 'decodeEntities' => true, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'length' => 4, 'default' => '\\'],
        ],
        'eol' => [
            'exclude' => true,
            'inputType' => 'select',
            'options' => ['n', 'rn', 'r'],
            'reference' => &$GLOBALS['TL_LANG']['tl_lead_export']['eol'],
            'eval' => ['size' => '3', 'maxlength' => 1, 'tl_class' => 'w50'],
            'sql' => ['type' => 'string', 'length' => 2, 'default' => ''],
        ],

        'useTemplate' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'clr', 'submitOnChange' => true],
            'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
        ],
        'template' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'fileTree',
            'eval' => ['filesOnly' => true, 'fieldType' => 'radio', 'mandatory' => true, 'tl_class' => 'clr'],
            'sql' => ['type' => 'binary_string', 'length' => 16, 'fixed' => true, 'notnull' => false],
        ],
        'startIndex' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'tl_class' => 'w50', 'rgxp' => 'digit'],
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],
        'sheetIndex' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'tl_class' => 'w50', 'rgxp' => 'digit'],
            'sql' => ['type' => 'integer', 'unsigned' => true, 'default' => 0],
        ],

        'lastRun' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['rgxp' => 'datim', 'datepicker' => true, 'nullIfEmpty' => true, 'tl_class' => 'w50 wizard'],
            'sql' => ['type' => 'integer', 'notnull' => false],
        ],
        'skipLastRun' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => ['tl_class' => 'w50 m12'],
            'sql' => ['type' => 'string', 'length' => 1, 'fixed' => true, 'default' => ''],
        ],
    ],
];