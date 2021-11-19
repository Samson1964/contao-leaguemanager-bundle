<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package   bdf
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2014
 */

$GLOBALS['BE_MOD']['content']['leaguemanager'] = array
(
	'tables'         => array
	(
		'tl_leaguemanager', 
		'tl_leaguemanager_staffeln',
		'tl_leaguemanager_mannschaften',
		'tl_leaguemanager_spieler',
		'tl_leaguemanager_paarungen'
	),
	'icon'           => 'bundles/contaoleaguemanager/images/icon.png',
);

/**
 * Frontend-Module
 */
$GLOBALS['FE_MOD']['schach']['leaguemanager'] = 'SaisonView';  

/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'leaguemanager_saisons'; // Erlaubte Saisons
$GLOBALS['TL_PERMISSIONS'][] = 'leaguemanager_saisonrechte'; // Saisonrechte
$GLOBALS['TL_PERMISSIONS'][] = 'leaguemanager_ligen'; // Erlaubte Ligen
