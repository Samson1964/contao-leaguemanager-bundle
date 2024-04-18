<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package News
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Table tl_leaguemanager_spieler
 */
$GLOBALS['TL_DCA']['tl_leaguemanager_spieler'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_leaguemanager_mannschaften',
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('sorting'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_leaguemanager_spieler', 'listPlayers'), 
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['toggle'],
				'attributes'           => 'onclick="Backend.getScrollOffset()"',
				'haste_ajax_operation' => array
				(
					'field'            => 'published',
					'options'          => array
					(
						array('value' => '', 'icon' => 'invisible.svg'),
						array('value' => '1', 'icon' => 'visible.svg'),
					),
				),
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{name_legend},surname,prename,title;{alias_legend},alias;{life_legend},birthday,country;{nwz_legend},nwz,dewis_id;{elo_legend},elo,ftitel,fide_id;{image_legend},singleSRC;{publish_legend},published'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'foreignKey'              => 'tl_leaguemanager_mannschaften.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		), 
		'surname' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['surname'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'prename' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['prename'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['title'],
			'exclude'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>10, 'tl_class'=>'w50 clr'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['alias'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'rgxp'                => 'alias', 
				'unique'              => true, 
				'maxlength'           => 128, 
				'tl_class'            => 'w50'
			),
			'save_callback'           => array
			(
				array('tl_leaguemanager_spieler', 'generateAlias')
			),
			'sql'                     => "varbinary(128) NOT NULL default ''"
		), 
		'birthday' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['birthday'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'maxlength'           => 10,
				'tl_class'            => 'w50',
				'rgxp'                => 'alnum'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager_spieler', 'getDate')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_spieler', 'putDate')
			),
			'sql'                     => "int(8) unsigned NOT NULL default '0'"
		), 
		'country' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['country'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'default'                 => 'GER',
			'inputType'               => 'select',
			'options'                 => $GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['countries'],
			'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "varchar(3) NOT NULL default ''"
		), 
		'nwz' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['nwz'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50', 'maxlength'=>4),
			'sql'                     => "smallint(4) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('tl_leaguemanager_spieler', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_spieler', 'putNumber')
			),
		), 
		'elo' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['elo'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'digit', 'tl_class'=>'w50 clr', 'maxlength'=>4),
			'sql'                     => "smallint(4) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('tl_leaguemanager_spieler', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_spieler', 'putNumber')
			),
		), 
		'ftitel' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['ftitel'],
			'exclude'                 => true,
			'default'                 => '',
			'inputType'               => 'select',
			'options'                 => array('-', 'GM', 'IM', 'WGM', 'FM', 'WIM', 'CM', 'WFM', 'WCM'),
			'reference'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['ftitel_list'],
			'eval'                    => array('tl_class'=>'w50'),
			'sql'                     => "varchar(3) NOT NULL default ''"
		), 
		'fide_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['fide_id'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>10, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('tl_leaguemanager_spieler', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_spieler', 'putNumber')
			),
		),
		'dewis_id' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['dewis_id'],
			'exclude'                 => true,
			'search'                  => false,
			'inputType'               => 'text',
			'eval'                    => array('maxlength'=>10, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'load_callback'           => array
			(
				array('tl_leaguemanager_spieler', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_spieler', 'putNumber')
			),
		), 
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "binary(16) NULL",
		), 
		// Spieler veröffentlicht
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_spieler']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'default'                 => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'doNotCopy'           => true
			),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
	)
);


/**
 * Class tl_leaguemanager_spieler
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_leaguemanager_spieler extends Backend
{

	var $nummer = 0;
	
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listPlayers($arrRow)
	{
		$this->nummer++;
		
		$temp = '<div class="tl_content_left">['.$this->nummer.'] ';
		if($arrRow['ftitel']) $temp .= $arrRow['ftitel'] . ' ';
		$temp .= $arrRow['surname'];
		if($arrRow['prename']) $temp .= ','.$arrRow['prename'];
		if($arrRow['title']) $temp .= ','.$arrRow['title'];
		if($arrRow['club']) $temp .= ' <i>('.$arrRow['club'].')</i>';
		return $temp.'</div>';
	}

	/**
	 * Zahl aus Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function getNumber($varValue)
	{
		if($varValue == 0) return '';
		else return $varValue;
	}

	/**
	 * Zahl für Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function putNumber($varValue)
	{
		return $varValue + 0;
	}

	/**
	 * Datumswert aus Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function getDate($varValue)
	{
		$laenge = strlen($varValue);
		$temp = '';
		switch($laenge)
		{
			case 8: // JJJJMMTT
				$temp = substr($varValue,6,2).'.'.substr($varValue,4,2).'.'.substr($varValue,0,4);
				break;
			case 6: // JJJJMM
				$temp = substr($varValue,4,2).'.'.substr($varValue,0,4);
				break;
			case 4: // JJJJ
				$temp = $varValue;
				break;
			default: // anderer Wert
				$temp = '';
		}

		return $temp;
	}

	/**
	 * Datumswert für Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function putDate($varValue)
	{
		$laenge = strlen(trim($varValue));
		$temp = '';
		switch($laenge)
		{
			case 10: // TT.MM.JJJJ
				$temp = substr($varValue,6,4).substr($varValue,3,2).substr($varValue,0,2);
				break;
			case 7: // MM.JJJJ
				$temp = substr($varValue,3,4).substr($varValue,0,2);
				break;
			case 4: // JJJJ
				$temp = $varValue;
				break;
			default: // anderer Wert
				$temp = 0;
		}

		return $temp;
	}

	/**
	 * Generiert automatisch ein Alias aus dem Titel
	 * @param mixed
	 * @param \DataContainer
	 * @return string
	 * @throws \Exception
	 */
	public function generateAlias($varValue, DataContainer $dc)
	{
		$autoAlias = false;

		// Generate alias if there is none
		if ($varValue == '')
		{
			$autoAlias = true;
			$varValue = standardize(String::restoreBasicEntities($dc->activeRecord->surname . '-' . $dc->activeRecord->prename));
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_leaguemanager_spieler WHERE alias=?")
								   ->execute($varValue);

		// Check whether the news alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	} 
 	
}
