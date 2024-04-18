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
 * Table tl_leaguemanager_paarungen
 */
$GLOBALS['TL_DCA']['tl_leaguemanager_paarungen'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_leaguemanager_staffeln',
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
			'fields'                  => array('round', 'pairing'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_leaguemanager_paarungen', 'listPairings'), 
		),
		'label' => array
		(
			'fields'                  => array('pairing', 'homeTeam', 'guestTeam'),
			'group_callback'          => array('tl_leaguemanager_paarungen', 'groupFormat')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['toggle'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{team_legend},homeTeam,guestTeam;{results_legend:hide},boardresults,resultbox,referee_result,referee_comment;{round_legend},round,pairing,eventDate,eventTime;{place_legend:hide},place,address;{referee_legend:hide},referee;{more_legend:hide},comment;{publish_legend},published'
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
			'foreignKey'              => 'tl_leaguemanager_staffeln.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'homeTeam' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['homeTeam'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_leaguemanager_paarungen', 'getTeam'),
			'eval'                    => array
			(
				'mandatory'           => true,
				'chosen'              => true,
				'submitOnChange'      => true,
				'tl_class'            => 'w50 clr'
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'guestTeam' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['guestTeam'],
			'exclude'                 => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_leaguemanager_paarungen', 'getTeam'),
			'eval'                    => array
			(
				'mandatory'           => true,
				'chosen'              => true,
				'submitOnChange'      => true,
				'tl_class'            => 'w50'
			),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'boardresults' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['boardresults'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'multiColumnWizard',
			'eval'                    => array
			(
				'style'               => 'width:100%;',
				'buttons'             => array
				(
					'copy'            => false, 
					'delete'          => false, 
					'up'              => false,
					'down'            => false,
				),
				'columnFields'        => array
				(
					'homePlayers' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['homePlayers'],
						'exclude'               => true,
						'inputType'             => 'select',
						'options_callback'      => array('tl_leaguemanager_paarungen', 'getHomeTeam'),
						'eval'                  => array
						(
							'style'             => 'width:240px', 
							'includeBlankOption'=> true, 
							'chosen'            => true
						)
					),
					'result' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['result'],
						'exclude'               => true,
						'default'               => '',
						'inputType'             => 'select',
						'options'               => array
						(
							'1:0'               => '1:0',
							'½:½'               => '½:½',
							'0:1'               => '0:1',
							'+:-'               => '+:-',
							'=:='               => '=:=',
							'-:+'               => '-:+',
							'-:-'               => '-:-',
							'H:H'               => 'H:H'
						),
						'eval' 			        => array
						(
							'style'             => 'width:60px', 
							'includeBlankOption'=> true, 
							'submitOnChange'    => true,
							'chosen'            => true
						)
					),
					'guestPlayers' => array
					(
						'label'                 => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['guestPlayers'],
						'exclude'               => true,
						'inputType'             => 'select',
						'options_callback'      => array('tl_leaguemanager_paarungen', 'getGuestTeam'),
						'eval' 			        => array
						(
							'style'             => 'width:240px', 
							'includeBlankOption'=> true, 
							'chosen'            => true
						)
					),
				)
			),
			'sql'                     => "blob NULL"
		),
		'resultbox' => array
		(
			'exclude'                 => true,
			'input_field_callback'    => array('tl_leaguemanager_paarungen', 'getResultbox')
		),  
		'referee_result' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['referee_result'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'maxlength'           => 10,
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(10) NOT NULL default ''"
		), 
		'referee_comment' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['referee_comment'],
			'exclude'                 => true,
			'search'                  => false,
			'sorting'                 => false,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'maxlength'           => 255,
				'tl_class'            => 'long clr'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		), 
		'round' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['round'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'rgxp'                => 'digit', 
				'tl_class'            => 'w50 clr', 
				'mandatory'           => true, 
				'maxlength'           => 2
			),
			'sql'                     => "smallint(2) unsigned NOT NULL default '0'"
		), 
		'pairing' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['pairing'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'rgxp'                => 'digit', 
				'tl_class'            => 'w50', 
				'mandatory'           => true, 
				'maxlength'           => 2
			),
			'sql'                     => "smallint(2) unsigned NOT NULL default '0'"
		), 
		'eventDate' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['eventDate'],
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
				array('tl_leaguemanager_paarungen', 'getDate')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_paarungen', 'putDate')
			),
			'sql'                     => "int(8) unsigned NOT NULL default '0'"
		), 
		'eventTime' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['eventTime'],
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'rgxp'                => 'time', 
				'mandatory'           => false, 
				'doNotCopy'           => false, 
				'tl_class'            => 'w50'
			),
			'sql'                     => "int(10) unsigned NULL"
		), 
		'place' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['place'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		), 
		'address' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['address'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		), 
		'referee' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['referee'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => false, 
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		), 
		'comment' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['comment'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'ace|html', 'helpwizard'=>true),
			'explanation'             => 'insertTags',
			'sql'                     => "mediumtext NULL"
		), 
		// Paarung veröffentlicht
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['published'],
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
 * Class tl_leaguemanager_paarungen
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_leaguemanager_paarungen extends Backend
{

	var $team = array();
	var $team_nr = array();
	var $nummer = 0;
	
	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');

		// Mannschaftsliste der Staffel einlesen
		$objTeam = $this->Database->prepare("SELECT id, title FROM tl_leaguemanager_mannschaften WHERE pid=? ORDER BY sorting ASC")
								  ->execute($_GET['id']);
		while ($objTeam->next())
		{
			$this->nummer++;
			$this->team[$this->nummer]['id'] = $objTeam->id;
			$this->team[$this->nummer]['title'] = '['.$this->nummer.'] '.$objTeam->title;
			$this->team_nr[$objTeam->id] = $this->nummer;
		}

	}

	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listPairings($arrRow)
	{
		$this->nummer++;
		$temp = '<div class="tl_content_left">';

		$temp .= '<div style="width:70px; float:left; font-weight:bold;">Spiel ' . $arrRow['pairing'] . '</div>';
		$temp .= '<div style="width:200px; float:left;">' . $this->team[$this->team_nr[$arrRow['homeTeam']]]['title'] . '</div>';
		$temp .= '<div style="width:30px; float:left;">-</div>';
		$temp .= '<div style="width:200px; float:left;">' . $this->team[$this->team_nr[$arrRow['guestTeam']]]['title'] . '</div>';

		return $temp.'</div>';
	}

	public function getTeam(DataContainer $dc)
	{
		// Heim-Spieler in Options-Array laden
		$objSpieler = $this->Database->prepare("SELECT id, sorting, surname, prename FROM tl_leaguemanager_spieler WHERE pid=? ORDER BY sorting ASC")
		                             ->execute($dc->activeRecord->homeTeam);
		$brett = 0;
		$array = array();
		
		while($objSpieler->next())
		{
			$brett++;
			$array[$objSpieler->id] = '[' . $brett . '] ' . $objSpieler->prename . ' ' . $objSpieler->surname;
		}

		$GLOBALS['ERGEBNISDIENST']['homeTeamPlayers'] = $array;
		
		// Gast-Spieler in Options-Array laden
		$objSpieler = $this->Database->prepare("SELECT id, sorting, surname, prename FROM tl_leaguemanager_spieler WHERE pid=? ORDER BY sorting ASC")
		                             ->execute($dc->activeRecord->guestTeam);
		$brett = 0;
		$array = array();
		
		while($objSpieler->next())
		{
			$brett++;
			$array[$objSpieler->id] = '[' . $brett . '] ' . $objSpieler->prename . ' ' . $objSpieler->surname;
		}

		$GLOBALS['ERGEBNISDIENST']['guestTeamPlayers'] = $array;
		
		// Anzahl Stammbretter laden und Variablen setzen
		$stammbretter = 8;
		$objBretter = $this->Database->prepare("SELECT boards FROM tl_leaguemanager_staffeln WHERE id=?")
		                   ->limit(1)
		                   ->execute($dc->activeRecord->pid);
		if($objBretter->boards) $bretter = $objBretter->boards; 
		else $bretter = $stammbretter;
		$GLOBALS['TL_DCA']['tl_leaguemanager_paarungen']['fields']['boardresults']['eval']['minCount'] = $bretter;
		$GLOBALS['TL_DCA']['tl_leaguemanager_paarungen']['fields']['boardresults']['eval']['maxCount'] = $bretter;

		// Mannschaften laden
		$arrForms = array();
		$objForms = $this->Database->prepare("SELECT id, title FROM tl_leaguemanager_mannschaften WHERE pid=? ORDER BY sorting ASC")
		                 ->execute($dc->activeRecord->pid);

		while ($objForms->next())
		{
			$arrForms[$objForms->id] = $objForms->title;
		}

		return $arrForms;
	}

	/**
	 * Label in Liste formatieren
	 * @param mixed
	 * @return mixed
	 */
	public function groupFormat($group, $sortingMode, $firstOrderBy, $row, $dc)
	{
		return $group . '. Runde';
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
	 * Spieler Heimmannschaft eintragen (Callback MultiColumnWizard)
	 * @param -
	 * @return Array mit den Optionen
	 */
	public function getHomeTeam()
	{
		// Spieler-Array zurückgeben
		return $GLOBALS['ERGEBNISDIENST']['homeTeamPlayers'];
	}
  
	public function getGuestTeam()
	{
		// Spieler-Array zurückgeben
		return $GLOBALS['ERGEBNISDIENST']['guestTeamPlayers'];
	}
  
    public function getHomePlayers(DataContainer $dc)
	{
		$array = $this->getPlayerslist($dc, 'home');
		return $array;
	}
  
	public function getGuestPlayers(DataContainer $dc)
	{
		$array = $this->getPlayerslist($dc, 'guest');
		return $array;
	}

	public function getPlayerslist($dc, $param)
	{
		$array = array();

		//echo "<pre>";
		//print_r ($param);
		//print_r($dc);
		//echo "</pre>";
		
		switch($param)
		{
			case 'home':
				$team = $dc->activeRecord->homeTeam;
				break;
			case 'guest':
				$team = $dc->activeRecord->guestTeam;
				break;
		}

		// Spieler laden
		$objSpieler = $this->Database->prepare("SELECT id, sorting, surname, prename FROM tl_leaguemanager_spieler WHERE pid=? ORDER BY sorting ASC")
		                             ->execute($team);
		$brett = 0;
		while($objSpieler->next())
		{
			$brett++;
			$array[$objSpieler->id] = '[' . $brett . '] ' . $objSpieler->prename . ' ' . $objSpieler->surname;
		}
		
		return $array;
	}

	/**
	 * Addiert die Einzelergebnisse und gibt das Gesamtergebnis zurück
	 * @param Datacontainer
	 * @return mixed
	 */
	public function getResultbox(DataContainer $dc)
	{
		// Ergebnis-Optionen serialisieren
		$ergebnis = unserialize($dc->activeRecord->boardresults);
		$heim = 0;
		$gast = 0;
		
		if($ergebnis)
		{
			foreach($ergebnis as $item)
			{
				switch($item['result'])
				{
					case '1:0':	
					case '+:-':	
						$heim += 1; break;
					case '½:½': 
					case '=:=': 
						$heim += .5; $gast += .5; break;
					case '0:1':	
					case '-:+':	
						$gast += 1; break;
				}
			}
		}
		
		$anzeige = sprintf("%0.1f", $heim) . ':' . sprintf("%0.1f", $gast);
		$anzeige = str_replace('.', ',', $anzeige);

		$string = '
<div class="w50 clr">
  <h3><label>' . $GLOBALS['TL_LANG']['tl_leaguemanager_paarungen']['resultbox'] . ': ' . $anzeige . '</label></h3>
</div>'; 
		
		return $string;
	} 	
}
