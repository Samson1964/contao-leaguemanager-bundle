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
 * Table tl_leaguemanager
 */
$GLOBALS['TL_DCA']['tl_leaguemanager'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ctable'                      => array('tl_leaguemanager_staffeln'),
		'switchToEdit'                => true,
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id'    => 'primary',
			)
		),
		'onload_callback' => array
		(
			array('tl_leaguemanager', 'checkPermission')
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 2,
			'fields'                  => array('toYear', 'fromYear'),
			'flag'                    => 12,
			'panelLayout'             => 'filter;sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title', 'fromYear', 'toYear'),
			'showColumns'             => true,
			'format'                  => '%s'
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager']['edit'],
				'href'                => 'table=tl_leaguemanager_staffeln',
				'icon'                => 'edit.gif',
			),
			'editHeader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager']['editHeader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_leaguemanager', 'generateEditheaderButton')
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif',
				'button_callback'     => array('tl_leaguemanager', 'generateCopyButton')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_leaguemanager', 'generateDeleteButton')
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_leaguemanager']['toggle'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'button_callback'     => array('tl_leaguemanager', 'generateShowButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title;{year_legend},fromYear,toYear;{publish_legend},published'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'tl_class'            => 'w50',
				'maxlength'           => 255
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'fromYear' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager']['fromYear'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 4,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager', 'getYear')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager', 'putYear')
			),
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		'toYear' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager']['toYear'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true,
				'maxlength'           => 4,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager', 'getYear')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager', 'putYear')
			),
			'sql'                     => "int(4) unsigned NOT NULL default '0'"
		),
		// Saison veröffentlicht
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
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
 * Class tl_leaguemanager
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_leaguemanager extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}

	/**
	 * Berechtigungen zum Bearbeiten der Tabelle tl_leaguemanager prüfen
	 */
	public function checkPermission()
	{

		if($this->User->isAdmin)
		{
			// Admin darf alles
			return;
		}
		
		echo "<pre>";
		echo "leaguemanager_saisons\n"; print_r($this->User->leaguemanager_saisons);
		echo "leaguemanager_rechte\n"; print_r($this->User->leaguemanager_rechte);
		echo "leaguemanager_ligen\n"; print_r($this->User->leaguemanager_ligen);
		echo "</pre>";

		if(!$this->User->hasAccess('create', 'leaguemanager_saisonrechte'))
		{
			// Hinzufügen-Button entfernen
			$GLOBALS['TL_DCA']['tl_leaguemanager']['config']['closed'] = true;
		}

		// Alle nicht zugewiesenen Datensätze entfernen
		if(!is_array($this->User->leaguemanager_saisons) || empty($this->User->leaguemanager_saisons))
		{
			$root = array(0); // Erlaubte Datensätze: keine
		}
		else
		{
			$root = $this->User->leaguemanager_saisons; // Erlaubte Saison-ID's übernehmen
		}
		$GLOBALS['TL_DCA']['tl_leaguemanager']['list']['sorting']['root'] = $root;

		// Aktuelle Aktion prüfen
		switch (Input::get('act'))
		{
			case 'create': // Datensatz anlegen
				if (!strlen(Input::get('pid')) || !in_array(Input::get('pid'), $root))
				{
					$this->log('Not enough permissions to create news items in season ID "'.Input::get('pid').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break; 

			case 'select': // Immer erlaubt
				break; 

			case 'cut':
			case 'copy':
				if (!in_array(Input::get('pid'), $root))
				{
					$this->log('Not enough permissions to '.Input::get('act').' league ID "'.$id.'" to season ID "'.Input::get('pid').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break; 
				
			case 'show': // Infobox
				if(!$this->User->hasAccess('show', 'leaguemanager_saisonrechte'))
				{
					$this->log('Not enough permissions to '.Input::get('act').' to season ID "'.Input::get('id').'"', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break;

			case 'edit': // Editheader
		 		if(count(preg_grep('/^tl_leaguemanager::/', $this->User->alexf)) == 0)
				{
					$this->log('Not enough permissions to '.Input::get('act').' Ergebnisdienst', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break; 

			case 'editAll': // Mehrere bearbeiten
			case 'deleteAll': // Mehrere löschen
			case 'overrideAll':
				$session = $this->Session->getData();
				if (Input::get('act') == 'deleteAll' && !$this->User->hasAccess('delete', 'leaguemanager_saisons'))
				{
					$session['CURRENT']['IDS'] = array();
				}
				else
				{
					$session['CURRENT']['IDS'] = array_intersect($session['CURRENT']['IDS'], $root);
				}
				$this->Session->setData($session);
				break; 

			default: // Zugriff verweigern bei jeder anderen Aktion
				if (strlen(Input::get('act')))
				{
					$this->log('Not enough permissions to '.Input::get('act').' Ergebnisdienst', __METHOD__, TL_ERROR);
					$this->redirect('contao/main.php?act=error');
				}
				break; 
		}

	}

	/**
	 * Return the edit header button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function generateEditheaderButton($row, $href, $label, $title, $icon, $attributes)
	{
		// Rechteprüfung für Bearbeitung der Saison-Einstellung
		// 1) Admin?
		// 2) Benutzer/Benutzergruppe: Irgendein Feld in tl_leaguemanager erlaubt? 
 		// Prüfung $this->User->hasAccess('editheader', 'leaguemanager_saisonrechte') wegen 2) unnötig
 		return ($this->User->isAdmin || count(preg_grep('/^tl_leaguemanager::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}

 /**
	 * Return the copy archive button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function generateCopyButton($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || $this->User->hasAccess('copy', 'leaguemanager_saisonrechte')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the delete archive button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function generateDeleteButton($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || $this->User->hasAccess('delete', 'leaguemanager_saisonrechte')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
	}


	/**
	 * Return the show button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function generateShowButton($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || $this->User->hasAccess('show', 'leaguemanager_saisonrechte')) ? '<a onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Details anzeigen\',\'url\':this.href});return false" href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'&amp;popup=1" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml('system/modules/leaguemanager/assets/images/show_.gif').' ';
	}

	/**
	 * Jahreswert aus Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function getYear($varValue)
	{
		if($varValue == 0) return '';
		else return $varValue;
	}

	/**
	 * Jahreswert für Datenbank umwandeln
	 * @param mixed
	 * @return mixed
	 */
	public function putYear($varValue)
	{
		return $varValue + 0;
	}

	public function getLigastatus($saison_id)
	{
		static $geladen, $ligarechte;

		if(!$geladen)
		{
			$geladen = true;
			$ligarechte = array();
			$objLigen = \Database::getInstance()->prepare("SELECT * FROM tl_leaguemanager_staffeln")
			                                    ->execute();
			if($objLigen->numRows)
			{
				while($objLigen->next())
				{
					$ligarechte[$objLigen->id] = $objLigen->pid;
				}
			}
		}

		// Prüfen ob die Saison-ID in den Ligarechten vorkommt
		foreach($this->User->leaguemanager_ligen as $liga)
		{
			if($ligarechte[$liga] == $saison_id) return true;
		}

		return false;

	}
}
