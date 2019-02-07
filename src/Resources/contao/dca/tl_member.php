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

/**
 * Adjust mandatoriness of the regular login fields
 */
$GLOBALS['TL_DCA']['tl_member']['fields']['username']['eval']['mandatory']   = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['username']['eval']['nullIfEmpty'] = true;
$GLOBALS['TL_DCA']['tl_member']['fields']['password']['eval']['mandatory']   = false;
$GLOBALS['TL_DCA']['tl_member']['fields']['password']['eval']['nullIfEmpty'] = true;
