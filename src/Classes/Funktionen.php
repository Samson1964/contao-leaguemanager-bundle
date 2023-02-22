<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 * 
 * Modul Banner - Check Helper 
 * 
 * PHP version 5
 * @copyright  Glen Langer 2007..2015
 * @author     Glen Langer
 * @package    Banner
 * @license    LGPL
 */


/**
 * Class BannerCheckHelper
 *
 * @copyright  Glen Langer 2015
 * @author     Glen Langer
 * @package    Banner
 */

namespace Schachbulle\ContaoLeaguemanagerBundle\Classes;

class Funktionen extends \Backend
{
	/**
	 * Current object instance
	 * @var object
	 */
	protected static $instance = null;

	var $user;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Benutzerdaten laden
		if(BE_USER_LOGGED_IN)
		{
			// Frontenduser eingeloggt
			$this->user = \BackendUser::getInstance();
		}
		parent::__construct();
	}


	/**
	 * Return the current object instance (Singleton)
	 * @return BannerCheckHelper
	 */
	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new \Schachbulle\ContaoLeaguemanagerBundle\Classes\Funktionen();
		}
	
		return self::$instance;
	}

	public function getLigenliste()
	{
		$array = array();
		$saison = array();
		// Saisons und Staffeln einlesen
		$objLigen = \Database::getInstance()->prepare("SELECT * FROM tl_leaguemanager_staffeln ORDER BY title ASC")
		                           ->execute();
		$objSaisons = \Database::getInstance()->prepare("SELECT * FROM tl_leaguemanager ORDER BY toYear DESC, fromYear DESC")
		                             ->execute();
		while($objSaisons->next())
		{
			$saison[$objSaisons->id] = $objSaisons->title;
		}
		while($objLigen->next())
		{
			$array[$objLigen->id] = $saison[$objLigen->pid] . ' - ' . $objLigen->title;
		}
		return $array;
	}

}