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
 * Table tl_leaguemanager_mannschaften
 */
$GLOBALS['TL_DCA']['tl_leaguemanager_mannschaften'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'ptable'                      => 'tl_leaguemanager_staffeln',
		'ctable'                      => 'tl_leaguemanager_spieler',
		'switchToEdit'                => true,
		'notSortable'                 => false, // ggfs. einschalten, wenn Sortieren nicht erlaubt sein soll
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
			'child_record_callback'   => array('tl_leaguemanager_mannschaften', 'listTeams'), 
		), 
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s',
			//'group_callback'          => array('tl_leaguemanager_mannschaften', 'groupFormat')
		), 
		'global_operations' => array
		(
			'results' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['results'],
				'href'                => 'table=tl_leaguemanager_paarungen',
				'icon'                => 'system/modules/leaguemanager/assets/images/result.png',
			),  
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['edit'],
				'href'                => 'table=tl_leaguemanager_spieler',
				'icon'                => 'edit.gif'
			),
			'editHeader' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['editHeader'],
				'href'                => 'act=edit',
				'icon'                => 'header.gif',
				'button_callback'     => array('tl_leaguemanager_mannschaften', 'editHeader')
			), 
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'                => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['toggle'],
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
				'label'               => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,alias,number;{settings_legend},upAllowed,downAllowed;{image_legend},singleSRC;{publish_legend},published'
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
		'sorting' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),  
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['title'],
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
		'alias' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['alias'],
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
				array('tl_leaguemanager_mannschaften', 'generateAlias')
			),
			'sql'                     => "varbinary(128) NOT NULL default ''"
		), 
		// Aufstieg erlaubt
		'upAllowed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['upAllowed'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'default'                 => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'doNotCopy'           => false,
				'tl_class'            => 'w50'
			),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
		// Abstieg erlaubt
		'downAllowed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['downAllowed'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'default'                 => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array
			(
				'doNotCopy'           => false,
				'tl_class'            => 'w50'
			),
			'sql'                     => "char(1) NOT NULL default ''"
		), 
		'singleSRC' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['singleSRC'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
			'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
			'sql'                     => "binary(16) NULL",
		), 
		// Mannschaft veröffentlicht
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_leaguemanager_mannschaften']['published'],
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
 * Class tl_leaguemanager_mannschaften
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    News
 */
class tl_leaguemanager_mannschaften extends Backend
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
	 * Return the edit header button
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function editHeader($row, $href, $label, $title, $icon, $attributes)
	{
		return ($this->User->isAdmin || count(preg_grep('/^tl_leaguemanager_mannschaften::/', $this->User->alexf)) > 0) ? '<a href="'.$this->addToUrl($href.'&amp;id='.$row['id']).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ' : Image::getHtml(preg_replace('/\.gif$/i', '_.gif', $icon)).' ';
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

	/**
	 * Add the type of input field
	 * @param array
	 * @return string
	 */
	public function listTeams($arrRow)
	{
		$this->nummer++;
		
		$temp = '<div class="tl_content_left">['.$this->nummer.'] '.$arrRow['title'];
		return $temp.'</div>';
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
			$varValue = standardize(String::restoreBasicEntities($dc->activeRecord->title));
		}

		$objAlias = $this->Database->prepare("SELECT id FROM tl_leaguemanager_mannschaften WHERE alias=?")
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
