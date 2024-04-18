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
 * Table tl_leaguemanager_staffeln
 */
$GLOBALS['TL_DCA']['tl_leaguemanager_staffeln'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_leaguemanager',
		'ctable'                      => 'tl_leaguemanager_mannschaften',
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
			'fields'                  => array('title ASC'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'filter;sort,search,limit',
			'child_record_callback'   => array('tl_leaguemanager_staffeln', 'listStaffeln'),  
			'disableGrouping'         => true
		),
		'label' => array
		(
			'format'                  => '%s',
			//'group_callback'          => array('tl_leaguemanager_staffeln', 'groupFormat')
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['edit'],
				'href'                => 'table=tl_leaguemanager_mannschaften',
				'icon'                => 'edit.gif'
			),
			'editHeader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['editHeader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_leaguemanager_staffeln', 'generateEditheaderButton')
			), 
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif',
				'button_callback'     => array('tl_leaguemanager_staffeln', 'generateCopyButton')
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif',
				'button_callback'     => array('tl_leaguemanager_staffeln', 'generateCutButton')
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
				'button_callback'     => array('tl_leaguemanager_staffeln', 'generateDeleteButton')
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['toggle'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'button_callback'     => array('tl_leaguemanager_staffeln', 'generateShowButton')
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title;{settings_legend},up,down,pointsWin,pointsDraw,boards,modus;{publish_legend},published'
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
			'foreignKey'              => 'tl_leaguemanager.title',
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'belongsTo', 'load'=>'eager')
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['title'],
			'exclude'                 => true,
			'search'                  => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'mandatory'           => true, 
				'maxlength'           => 255, 
				'tl_class'            => 'w50'
			),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'up' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['up'],
			'exclude'                 => true,
			'search'                  => true,
			'default'                 => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'maxlength'           => 1,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager_staffeln', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_staffeln', 'putNumber')
			),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		), 
		'down' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['down'],
			'exclude'                 => true,
			'search'                  => true,
			'default'                 => 2,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'maxlength'           => 1,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager_staffeln', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_staffeln', 'putNumber')
			),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		), 
		'pointsWin' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['pointsWin'],
			'exclude'                 => true,
			'search'                  => true,
			'default'                 => 2,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'maxlength'           => 1,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager_staffeln', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_staffeln', 'putNumber')
			),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		), 
		'pointsDraw' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['pointsDraw'],
			'exclude'                 => true,
			'search'                  => true,
			'default'                 => 1,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'maxlength'           => 1,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager_staffeln', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_staffeln', 'putNumber')
			),
			'sql'                     => "int(1) unsigned NOT NULL default '0'"
		), 
		'boards' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['boards'],
			'exclude'                 => true,
			'search'                  => false,
			'default'                 => 8,
			'inputType'               => 'text',
			'eval'                    => array
			(
				'maxlength'           => 2,
				'tl_class'            => 'w50',
				'rgxp'                => 'digit'
			),
			'load_callback'           => array
			(
				array('tl_leaguemanager_staffeln', 'getNumber')
			),
			'save_callback' => array
			(
				array('tl_leaguemanager_staffeln', 'putNumber')
			),
			'sql'                     => "int(2) unsigned NOT NULL default '0'"
		), 
		'modus' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['modus'],
			'exclude'                 => true,
			'filter'                  => false,
			'inputType'               => 'select',
			'options'                 => $GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['modis'], 
			'eval'                    => array
			(
				'doNotCopy'           => true,
				'tl_class'            => 'long clr',
			),
			'sql'                     => "char(5) NOT NULL default ''"
		), 
		// Staffel veröffentlicht
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_staffeln']['published'],
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
 * Class tl_leaguemanager_staffeln
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_leaguemanager_staffeln extends Backend
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
		echo "leaguemanager_saisonrechte\n"; print_r($this->User->leaguemanager_saisonrechte);
		echo "leaguemanager_ligen\n"; print_r($this->User->leaguemanager_ligen);
		echo "leaguemanager_ligenrechte\n"; print_r($this->User->leaguemanager_ligenrechte);
		echo "</pre>";

		if(!$this->User->hasAccess('create', 'leaguemanager_ligenrechte'))
		{
			// Hinzufügen-Button entfernen
			$GLOBALS['TL_DCA']['tl_leaguemanager_staffeln']['config']['closed'] = true;
		}

		// Alle nicht zugewiesenen Datensätze entfernen
		if(!is_array($this->User->leaguemanager_ligen) || empty($this->User->leaguemanager_ligen))
		{
			$root = array(0); // Erlaubte Datensätze: keine
		}
		else
		{
			$root = $this->User->leaguemanager_ligen; // Erlaubte Ligen-ID's übernehmen
		}
		$GLOBALS['TL_DCA']['tl_leaguemanager_staffeln']['list']['sorting']['root'] = $root;

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
 		return ($this->User->isAdmin || count(preg_grep('/^tl_leaguemanager_staffeln::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
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
		return ($this->User->isAdmin || $this->User->hasAccess('copy', 'leaguemanager_ligenrechte')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
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
	public function generateCutButton($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || $this->User->hasAccess('cut', 'leaguemanager_ligenrechte')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
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
		return ($this->User->isAdmin || $this->User->hasAccess('delete', 'leaguemanager_ligenrechte')) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
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
		return ($this->User->isAdmin || $this->User->hasAccess('show', 'leaguemanager_ligenrechte')) ? '<a onclick="Backend.openModalIframe({\'width\':768,\'title\':\'Details anzeigen\',\'url\':this.href});return false" href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'&amp;popup=1" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml('system/modules/leaguemanager/assets/images/show_.gif').' ';
	}

	/**
	 * Return the link picker wizard
	 * @param \DataContainer
	 * @return string
	 */
	public function pagePicker(DataContainer $dc)
	{
		return ' <a href="contao/page.php?do=' . Input::get('do') . '&amp;table=' . $dc->table . '&amp;field=' . $dc->field . '&amp;value=' . str_replace(array('{{link_url::', '}}'), '', $dc->value) . '" title="' . specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']) . '" onclick="Backend.getScrollOffset();Backend.openModalSelector({\'width\':765,\'title\':\'' . specialchars(str_replace("'", "\\'", $GLOBALS['TL_LANG']['MOD']['page'][0])) . '\',\'url\':this.href,\'id\':\'' . $dc->field . '\',\'tag\':\'ctrl_'. $dc->field . ((Input::get('act') == 'editAll') ? '_' . $dc->id : '') . '\',\'self\':this});return false">' . Image::getHtml('pickpage.gif', $GLOBALS['TL_LANG']['MSC']['pagepicker'], 'style="vertical-align:top;cursor:pointer"') . '</a>';
	}

	public function listStaffeln($arrRow)
	{
		$temp = '<div class="tl_content_left">'.$arrRow['title'];
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
	 * Label in Liste formatieren
	 * @param mixed
	 * @return mixed
	 */
	public function groupFormat($group, $sortingMode, $firstOrderBy, $row, $dc)
	{
		return $group . '. Liga';
	}  
}
