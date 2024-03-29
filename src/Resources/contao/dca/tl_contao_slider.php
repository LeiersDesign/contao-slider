<?php

/*
 * Copyright 2019 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$GLOBALS['TL_DCA']['tl_contao_slider'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ],
        'onsubmit_callback' => [
            ['tl_contao_slider', 'generateUniqueName'],
        ],
    /* 'onload_callback' => [
      ['tl_contao_slider', 'showJsLibraryHint'],
      ], */
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['title'],
            'flag' => 1,
            'panelLayout' => 'search, limit; filter;'
        ],
        'label' => [
            'fields' => ['title'],
            'format' => '%s'
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['edit'],
                'href' => 'act=edit',
                'icon' => 'header.svg'
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ]
    ],
    // Palettes
    'palettes' => [
        //'__selector__' => ['controls_zoom'],
        'default' => 'title, alias;'
        . 'mylistwizard;'
    ],
    /* 'subpalettes' => [
      'controls_zoom' => 'controls_zoom_position'
      ], */
    // Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'title' => [
            'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['title'],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => true,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 100,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'alias' => [
            'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['alias'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'unique' => true,
                'maxlength' => 128,
                'tl_class' => 'w50',
                'disabled' => true,
                'doNotCopy' => true,
                'rgxp' => 'alias'
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'mylistwizard' => array
            (
            'label' => &$GLOBALS['TL_LANG']['tl_contao_slider']['mylistwizard'],
            'exclude' => true,
            'inputType' => 'listWidget',
            'eval' => array(
                'tl_class' => 'clr'
            ),
            'sql' => "blob NULL"
        )
    ]
];

Class tl_contao_slider extends \Contao\Backend {

    function generateUniqueName(DataContainer $dc) {
        $id = $dc->id;
        $varValue = $dc->activeRecord->alias;

        if ($varValue != NULL) {
            return;
        }

        $uniqueName = "contao_slider_$id";

        $sql = "UPDATE tl_contao_slider SET alias = '$uniqueName' WHERE id = '$id'";

        $this->Database->prepare($sql)->execute();
    }

    /**
     * Add a link to the list items import wizard
     *
     * @return string
     */
    public function listImportWizard() {
        return ' <a href="' . $this->addToUrl('key=list') . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['lw_import'][1]) . '" onclick="Backend.getScrollOffset()">' . Image::getHtml('tablewizard.gif', $GLOBALS['TL_LANG']['MSC']['tw_import'][0], 'style="vertical-align:text-bottom"') . '</a>';
    }

}
