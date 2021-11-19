<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Extend default palette
 */
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace('fop;', 'fop;{leaguemanager_legend},leaguemanager_saisons,leaguemanager_saisonrechte,leaguemanager_ligen,leaguemanager_ligenrechte;', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);


/**
 * Add fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields']['leaguemanager_saisons'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user_group']['leaguemanager_saisons'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'foreignKey'              => 'tl_leaguemanager.title',
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['leaguemanager_saisonrechte'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user_group']['leaguemanager_saisonrechte'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('editheader', 'copy', 'create', 'delete', 'toggle', 'show'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_user_group']['leaguemanager_saisonrechte_optionen'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
); 

$GLOBALS['TL_DCA']['tl_user_group']['fields']['leaguemanager_ligen'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user_group']['leaguemanager_ligen'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('\Samson\Ergebnisdienst\Funktionen', 'getLigenliste'),
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_user_group']['fields']['leaguemanager_ligenrechte'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user_group']['leaguemanager_ligenrechte'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options'                 => array('editheader', 'copy', 'create', 'delete', 'toggle', 'show'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_user_group']['leaguemanager_ligenrechte_optionen'],
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
); 

