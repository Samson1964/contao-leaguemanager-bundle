<?php
/**
 * Avatar for Contao Open Source CMS
 *
 * Copyright (C) 2013 Kirsten Roschanski
 * Copyright (C) 2013 Tristan Lins <http://bit3.de>
 *
 * @package    Avatar
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Add palette to tl_module
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['leaguemanager'] = '{title_legend},name,headline,type;{config_legend},leaguemanager_saison,leaguemanager_staffel;{protected_legend:hide},protected;{expert_legend:hide},cssID,align,space';

$GLOBALS['TL_DCA']['tl_module']['fields']['leaguemanager_saison'] = array
(
	'label'                    => &$GLOBALS['TL_LANG']['tl_module']['leaguemanager_saison'],
	'exclude'                  => true,
	'inputType'                => 'select',
	'options_callback'         => array('tl_module_leaguemanager', 'getSaison'),
	'reference'                => &$GLOBALS['TL_LANG']['tl_leaguemanager'],
	'eval'                     => array
	(
		'tl_class'             => 'w50',
		'mandatory'            => true,
		'includeBlankOption'   => true, 
		'submitOnChange'       => true, 
		'allowHtml'            => true, 
		'chosen'               => true
	),
	'sql'                      => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['leaguemanager_staffel'] = array
(
	'label'                    => &$GLOBALS['TL_LANG']['tl_module']['leaguemanager_staffel'],
	'exclude'                  => true,
	'inputType'                => 'select',
	'options_callback'         => array('tl_module_leaguemanager', 'getStaffeln'),
	'reference'                => &$GLOBALS['TL_LANG']['tl_leaguemanager'],
	'eval'                     => array
	(
		'tl_class'             => 'w50',
		'mandatory'            => false,
		'includeBlankOption'   => true, 
		'allowHtml'            => true, 
		'chosen'               => true
	),
	'sql'                      => "int(10) unsigned NOT NULL default '0'"
);

/**
 * Class tl_module_fhcounter
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    Calendar
 */
class tl_module_leaguemanager extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	public function getSaison()
	{
		// Heim-Spieler in Options-Array laden
		$objSaison = $this->Database->prepare("SELECT id, title, published FROM tl_leaguemanager ORDER BY toYear DESC")
		                            ->execute();
		$array = array();
		
		while($objSaison->next())
		{
			if($objSaison->published) $array[$objSaison->id] = $objSaison->title;
			else $array[$objSaison->id] = '<i>' . $objSaison->title . '</i> [unveröffentlicht]';
		}

		return $array;
	}

	public function getStaffeln(Datacontainer $dc)
	{
		$array = array();

		//echo "<pre>";
		//print_r($dc);
		//echo "</pre>";
		
		if($dc->activeRecord->leaguemanager_saison)
		{
			// Heim-Spieler in Options-Array laden
			$objStaffel = $this->Database->prepare("SELECT id, title, published FROM tl_leaguemanager_staffeln WHERE pid=? ORDER BY league AND title ASC")
										->execute($dc->activeRecord->leaguemanager_saison);
			while($objStaffel->next())
			{
				if($objStaffel->published) $array[$objStaffel->id] = $objStaffel->title;
				else $array[$objStaffel->id] = '<i>' . $objStaffel->title . '</i> [unveröffentlicht]';
			}
		}

		return $array;
	}

}
