<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   fh-counter
 * @author    Frank Hoppe
 * @license   GNU/LGPL
 * @copyright Frank Hoppe 2014
 */

/**
 * Class CounterRegister
 *
 * @copyright  Frank Hoppe 2014
 * @author     Frank Hoppe
 *
 * Basisklasse vom FH-Counter
 * Erledigt die Zählung der jeweiligen Contenttypen und schreibt die Zählerwerte in $GLOBALS
 */
namespace Schachbulle\ContaoLeaguemanagerBundle\Classes;

class SaisonView extends \Module
{

	var $saison; 
	var $staffel;
	var $runde;
	var $option;
	var $mannschaft;
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_ergebnisdienst');

			$objTemplate->wildcard = '### ERGEBNISDIENST ###';
			$objTemplate->title = $this->name;
			$objTemplate->id = $this->id;

			return $objTemplate->parse();
		}
		else
		{
			// FE-Modus: URL mit allen möglichen Parametern auflösen
			\Input::setGet('season', \Input::get('season')); // Saison
			\Input::setGet('relay', \Input::get('relay')); // Staffel
			\Input::setGet('team', \Input::get('team')); // Mannschaft
			\Input::setGet('round', \Input::get('round')); // Runde
			\Input::setGet('option', \Input::get('option')); // Option
			$saison = \Input::get('season');
			$staffel = \Input::get('relay');
			$mannschaft = \Input::get('team');
			$runde = \Input::get('round');
			$option = \Input::get('option');
		}
		
		return parent::generate(); // Weitermachen mit dem Modul
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$this->import('Database');
		global $objPage;

		// Template-Objekt anlegen
		$this->Template = new \FrontendTemplate('ergebnisdienst_view');

		// Saisondaten laden
		$objSaison = $this->Database->prepare("SELECT * FROM tl_leaguemanager WHERE id=?")
									->execute($this->ergebnisdienst_saison);
		$param = '/season/' . $this->ergebnisdienst_saison;
		$this->Template->Saison = $this->ergebnisdienst_saison;
		$this->Template->Saisonname = $objSaison->title;

		// Staffeldaten laden, wenn vorhanden
		if($this->ergebnisdienst_staffel)
		{
			$objStaffel = $this->Database->prepare("SELECT * FROM tl_leaguemanager_staffeln WHERE id=?")
										 ->execute($this->ergebnisdienst_staffel);
			$param .= '/relay/' . $this->ergebnisdienst_staffel;
			$this->Template->Staffel = $this->ergebnisdienst_staffel;
			$this->Template->Staffelname = $objStaffel->title;
			
			// Mannschaften laden und Kreuztabelle anzeigen
			$nr = 0;
			$TeamID = array();
			$Mannschaft = array();
			$Kreuztabelle = array();
			$objTeams = $this->Database->prepare("SELECT * FROM tl_leaguemanager_mannschaften WHERE pid=? ORDER BY sorting ASC")
											  ->execute($this->ergebnisdienst_staffel);
			while($objTeams->next())
			{
				$nr++;
				$TeamID[$objTeams->id] = $nr; // Zuordnung der Startnummer zur Mannschafts-ID
				$Mannschaft['ID'][$nr-1] = $objTeams->id;
				$Mannschaft['NAME'][$nr-1] = $objTeams->title;
				$Mannschaft['SPIELE'][$nr-1] = 0;
				$Mannschaft['MP'][$nr-1] = 0;
				$Mannschaft['BP'][$nr-1] = 0;
				$Mannschaft['BW'][$nr-1] = 0;
				$Mannschaft['NUMMER'][$nr-1] = $nr;
			}			
			// Leere Kreuztabelle anlegen
			for($x=1;$x<=$nr;$x++)
			{
				for($y=1;$y<=$nr;$y++)
				{
					if($x == $y) $Kreuztabelle[$x][$y] = 'x';
					else $Kreuztabelle[$x][$y] = '';
				}
			}
			
			// Plan der Runden anlegen
			$Rundenplan = array();
			for($x=1;$x<100;$x++) 
			{
				$Rundenplan['SPIEL'][$x] = 0; // Zählt gespielte Paarungen
				$Rundenplan['TERMIN'][$x] = 0; // Zählt alle Paarungen
				$Rundenplan['TITEL'][$x] = ''; // Für separate Rundenbezeichnungen
			}
			
			// Paarungen laden und Einzelergebnisse auswerten
			$objPairs = $this->Database->prepare("SELECT * FROM tl_leaguemanager_paarungen WHERE pid=?")
									   ->execute($this->ergebnisdienst_staffel);
			while($objPairs->next())
			{
				$gespielt = false;
				// Nur veröffentlichte Paarungen berücksichtigen
				if($objPairs->published)
				{
					// Schiedsrichter-Ergebnis bevorzugen
					if($objPairs->referee_result)
					{
						list($heim_bp,$gast_bp) = explode(':',$objPairs->referee_result);
						$heim_bp = str_replace(',','.',$heim_bp);
						$gast_bp = str_replace(',','.',$gast_bp);
						$gespielt = true;
					}
					// andernfalls erspielte Ergebnisse addieren
					else
					{
						$ergebnis = unserialize($objPairs->boardresults);
						$heim_bp = 0;
						$gast_bp = 0;
						if($ergebnis)
						{
							foreach($ergebnis as $item)
							{
								switch($item['result'])
								{
									case '1:0':	
									case '+:-':	
										$heim_bp += 1; break;
									case '½:½': 
									case '=:=': 
										$heim_bp += .5; $gast_bp += .5; break;
									case '0:1':	
									case '-:+':	
										$gast_bp += 1; break;
								}
							}
						}
						if($heim_bp > 0 || $gast_bp > 0) $gespielt = true;
					}

					// Mannschaftsergebnis eintragen
					if($gespielt)
					{
						// Rundenplan ergänzen
						$Rundenplan['SPIEL'][$objPairs->round]++;
						
						// Ergebnisse in Kreuztabelle übertragen
						$heim_nr = $TeamID[$objPairs->homeTeam];
						$gast_nr = $TeamID[$objPairs->guestTeam];
						$Kreuztabelle[$heim_nr][$gast_nr] = str_replace('.', ',', sprintf("%0.1f", $heim_bp));
						$Kreuztabelle[$gast_nr][$heim_nr] = str_replace('.', ',', sprintf("%0.1f", $gast_bp));
						// Mannschafts- und Brettpunkte addieren
						if($heim_bp > $gast_bp)
						{
							$Mannschaft['MP'][$heim_nr-1] += 2;
						}
						elseif($heim_bp < $gast_bp)
						{
							$Mannschaft['MP'][$gast_nr-1] += 2;
						}
						else
						{
							$Mannschaft['MP'][$heim_nr-1] += 1;
							$Mannschaft['MP'][$gast_nr-1] += 1;
						}
						$Mannschaft['BP'][$heim_nr-1] += $heim_bp;
						$Mannschaft['BP'][$gast_nr-1] += $gast_bp;
						$Mannschaft['SPIELE'][$heim_nr-1] += 1;
						$Mannschaft['SPIELE'][$gast_nr-1] += 1;
					}
					// Rundenplan weiter ergänzen
					$Rundenplan['TERMIN'][$objPairs->round]++;
					if($objPairs->roundname) $Rundenplan['TITEL'][$objPairs->round] = $objPairs->roundname;
				}
			}
			
			// Rundenlinks erstellen
			$Rundenlinks = '<ul class="rundenlinks">';
			for($x=1;$x<100;$x++) 
			{
				// Nur vorhandene Runden berücksichtigen
				if($Rundenplan['TERMIN'][$x])
				{
					// CSS-Klasse danach setzen, ob Spiele oder nur Termine aktiv sind
					if($Rundenplan['SPIEL'][$x]) $Rundenlinks .= '<li class="spiel">';
					else $Rundenlinks .= '<li class="termin">';
					// Linkname generieren
					($Rundenplan['TITEL'][$x]) ? $titel = $Rundenplan['TITEL'][$x] : $titel = "$x. Runde";
					// Rundenlink generieren
					$link = $this->generateFrontendUrl($objPage->row(), $param . '/round/' . $x);
					// Linkeintrag abschließen
					$Rundenlinks .= '<a href="'.$link.'">'.$titel.'</a></li>';
				}
			}
			$Rundenlinks .= '</ul>';
			

			// Sortierung nach MP, BP usw.
			array_multisort($Mannschaft["MP"],SORT_DESC,$Mannschaft["BP"],SORT_DESC,$Mannschaft["SPIELE"],SORT_ASC,$Mannschaft["BW"],SORT_DESC,$Mannschaft["NAME"],SORT_ASC,$Mannschaft["NUMMER"],SORT_ASC,$Mannschaft["ID"],SORT_ASC);

			// Anhand der sortierten Mannschaftsnummer jetzt die Kreuztabelle anpassen
			for($x=0;$x<count($Mannschaft['NUMMER']);$x++)
			{
				$alteNr = $x+1;
				$neueNr = $Mannschaft['NUMMER'][$x];
				// Nur tauschen wenn nötig
				if($alteNr < $neueNr)
				{
					// Zuerst die Zeilen tauschen
					for($y=1;$y<=$nr;$y++)
					{
						$temp = $Kreuztabelle[$alteNr][$y];
						$Kreuztabelle[$alteNr][$y] = $Kreuztabelle[$neueNr][$y];
						$Kreuztabelle[$neueNr][$y] = $temp;
					}
					// Jetzt die Spalten tauschen
					for($y=1;$y<=$nr;$y++)
					{
						$temp = $Kreuztabelle[$y][$alteNr];
						$Kreuztabelle[$y][$alteNr] = $Kreuztabelle[$y][$neueNr];
						$Kreuztabelle[$y][$neueNr] = $temp;
					}
				}
			}
			
			// Kreuztabelle ausgeben
			$KreuztabelleHTML = '<table class="ergebnisdienst_kreuztabelle">';
			// Kopfzeile
			$KreuztabelleHTML .= '<tr>';
			$KreuztabelleHTML .= '<th>Pl.</th>';
			$KreuztabelleHTML .= '<th>Mannschaft</th>';
			$KreuztabelleHTML .= '<th>Sp.</th>';
			$KreuztabelleHTML .= '<th>MP</th>';
			$KreuztabelleHTML .= '<th>BP</th>';
			for($x=1;$x<=$nr;$x++)
			{
				$KreuztabelleHTML .= '<th>'.$x.'</th>';
			}
			$KreuztabelleHTML .= '</tr>';
			// Restliche Zeilen
			for($x=0;$x<$nr;$x++)
			{
				$platz = $x+1;
				
				//Auf- und Absteiger markieren
				($platz <= $objStaffel->up) ? $class = 'auf' : $class = '';
				if($platz >= ($nr - $objStaffel->down + 1) && $class != 'auf') $class = 'ab';
				
				// Mannschaftslink generieren
				$link = $this->generateFrontendUrl($objPage->row(), $param . '/team/' . $Mannschaft['ID'][$x]);
				
				$KreuztabelleHTML .= '<tr class="'.$class.'">';
				$KreuztabelleHTML .= '<td class="platz">'.$platz.'.</td>';
				$KreuztabelleHTML .= '<td class="name"><a href="'.$link.'">'.$Mannschaft['NAME'][$x].'</a></td>';
				$KreuztabelleHTML .= '<td class="spiele">'.$Mannschaft['SPIELE'][$x].'</td>';
				$KreuztabelleHTML .= '<td class="mp">'.$Mannschaft['MP'][$x].'</td>';
				$KreuztabelleHTML .= '<td class="bp">'.str_replace('.', ',', sprintf("%0.1f", $Mannschaft['BP'][$x])).'</td>';
				// Ergebnisse
				for($y=1;$y<=$nr;$y++)
				{
					if($Kreuztabelle[$x+1][$y] == 'x') $KreuztabelleHTML .= '<td class="blindfeld">'.$Kreuztabelle[$x+1][$y].'</td>';
					else $KreuztabelleHTML .= '<td class="ergebnis">'.$Kreuztabelle[$x+1][$y].'</td>';
				}
				$KreuztabelleHTML .= '</tr>';
			}
			$KreuztabelleHTML .= '</table>';
			
			//$this->Template->Bretter = $bretter;
			//$this->Template->MannschaftSortiert = $Mannschaft;
			$this->Template->Rundenlinks = $Rundenlinks;
			$this->Template->Kreuztabelle = $KreuztabelleHTML;

		}

		// URL generieren
		$this->Template->Url = $this->generateFrontendUrl($objPage->row(), $param);

	}

}
