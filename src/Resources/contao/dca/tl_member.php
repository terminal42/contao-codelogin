<?php

/**
 * Palettes
 */
\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addField('login_code', 'password')
    ->applyToSubpalette('login', 'tl_member');

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_member']['fields']['login_code'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_member']['login_code'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 32, 'tl_class' => 'clr'],
    'sql'       => "varchar(32) NOT NULL default ''",
];
