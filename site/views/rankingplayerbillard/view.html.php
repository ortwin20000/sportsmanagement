<?php
/**
 * SportsManagement ein Programm zur Verwaltung für alle Sportarten
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage rankingplayerbillard
 * @file       view.html.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013-2023 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Form\Form;

/**
 * sportsmanagementViewMatchReport
 *
 * @package
 * @author
 * @copyright diddi
 * @version   2014
 * @access    public
 */
class sportsmanagementViewrankingplayerbillard extends sportsmanagementView
{

	
	public function init()
	{
// echo '<pre>'.print_r($this->jinput->getInt('p', 0),true).'</pre>';
$this->ranking = array();
      
$this->matchsingle = sportsmanagementModelMatch::getMatchAllSingleData($this->jinput->getInt("p", 0));
 echo '<pre>'.print_r($this->matchsingle,true).'</pre>';

$this->rounds = sportsmanagementModelProject::getRounds($ordering = 'ASC',0, false);
 echo '<pre>'.print_r($this->rounds,true).'</pre>';


foreach ( $this->matchsingle as $key => $value )
  {
    $this->ranking[$value->teamplayer1_id]['teamplayerid'] = $value->teamplayer1_id;
    $this->ranking[$value->teamplayer1_id]['projectteamid'] = $value->projectteam1_id;
$this->ranking[$value->teamplayer1_id][$value->roundcode] = $value->team1_result;
$this->ranking[$value->teamplayer1_id]['total'] += $value->team1_result;
    
    $this->ranking[$value->teamplayer2_id]['teamplayerid'] = $value->teamplayer2_id;
    $this->ranking[$value->teamplayer2_id]['projectteamid'] = $value->projectteam2_id;
$this->ranking[$value->teamplayer2_id][$value->roundcode] = $value->team2_result;
$this->ranking[$value->teamplayer2_id]['total'] += $value->team2_result;    
    
    
  }

$volume  = array_column($this->ranking, 'total');
// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
array_multisort($volume, SORT_DESC,  $this->ranking);
      
echo '<pre>'.print_r($this->ranking,true).'</pre>';

		
  }

}
