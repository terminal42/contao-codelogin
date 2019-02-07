<?php

/**
 * Add palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['code_login'] = '{title_legend},name,headline,type;{redirect_legend},code_param,jumpTo;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['code_param'] = [
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['code_param'],
    'inputType'         => 'text',
    'eval'              => ['maxlength' => 16, 'tl_class' => 'w50'],
    'sql'               => "varchar(16) NOT NULL default ''",
];
