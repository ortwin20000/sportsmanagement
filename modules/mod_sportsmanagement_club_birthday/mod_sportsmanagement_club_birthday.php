<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

defined('_JEXEC') or die('Restricted access');
//require_once(JPATH_SITE.DS.'components'.DS.'com_sportsmanagement'.DS.'sportsmanagement.php');
if (! defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}
if ( !defined('JSM_PATH') )
{
DEFINE( 'JSM_PATH','components/com_sportsmanagement' );
}

require_once(JPATH_ADMINISTRATOR.DS.JSM_PATH.DS.'helpers'.DS.'sportsmanagement.php');  
require_once(JPATH_SITE.DS.JSM_PATH.DS.'helpers'.DS.'route.php');  
require_once(JPATH_SITE.DS.JSM_PATH.DS.'helpers'.DS.'countries.php');

require_once(dirname(__FILE__).DS.'helper.php');

// Reference global application object
$app = JFactory::getApplication();
$document = JFactory::getDocument();
$show_debug_info = JComponentHelper::getParams('com_sportsmanagement')->get('show_debug_info',0) ;

if (! defined('COM_SPORTSMANAGEMENT_CFG_WHICH_DATABASE'))
{
DEFINE( 'COM_SPORTSMANAGEMENT_CFG_WHICH_DATABASE',JComponentHelper::getParams('com_sportsmanagement')->get( 'cfg_which_database' ) );
}
if ( COM_SPORTSMANAGEMENT_CFG_WHICH_DATABASE || JRequest::getInt( 'cfg_which_database', 0 ) )
{
if (! defined('COM_SPORTSMANAGEMENT_PICTURE_SERVER'))
{    
DEFINE( 'COM_SPORTSMANAGEMENT_PICTURE_SERVER',JComponentHelper::getParams('com_sportsmanagement')->get( 'cfg_which_database_server' ) );
}    
}
else
{
if (! defined('COM_SPORTSMANAGEMENT_PICTURE_SERVER'))
{        
DEFINE( 'COM_SPORTSMANAGEMENT_PICTURE_SERVER',JURI::root() );
}    
}


//add css file
$document->addStyleSheet(JURI::base().'modules/mod_sportsmanagement_club_birthday/css/mod_sportsmanagement_club_birthday.css');

$mode = $params->def("mode");
$results = $params->get('limit');
$limit = $params->get('limit');
$refresh = $params->def("refresh");
$minute = $params->def("minute");
$height = $params->def("height");
$width  = $params->def("width");
// Prevent that result is null when either $players or $crew is null by casting each to an array.
//$persons = array_merge((array)$players, (array)$crew);
$clubs = modSportsmanagementClubBirthdayHelper::getClubs($limit);
if(count($clubs)>1)   $clubs = modSportsmanagementClubBirthdayHelper::jl_birthday_sort($clubs,$params->def("sort_order"));

if ( $show_debug_info )
{
$app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' clubs<br><pre>'.print_r($clubs,true).'</pre>'),'Notice');
$app->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' params<br><pre>'.print_r($params,true).'</pre>'),'Notice');
}




$k=0;
$counter=0;

//echo 'mode -> '.$mode.'<br>';
//echo 'refresh -> '.$refresh.'<br>';
//echo 'minute -> '.$minute.'<br>';


if(count($clubs) > 0) 
{

if (count($clubs)<$results)
{
$results=count($clubs);
}
        
$tickerpause = $params->def("tickerpause");
$scrollspeed = $params->def("scrollspeed");
$scrollpause = $params->def("scrollpause");

/*
$javascript = "\n";
$javascript .= "	window.addEvent('domready', function() {"."\n";
$javascript .= "	var opt".$params->get( 'moduleclass_sfx' )." = {"."\n";
$javascript .= "	  duration: 3000,"."\n";
$javascript .= "	  delay:".$tickerpause."000,"."\n";
$javascript .= "	  auto:true,"."\n";
$javascript .= "	  direction: 'v',"."\n";
$javascript .= "	  onMouseEnter: function(){this.stop();},"."\n";
$javascript .= "	  onMouseLeave: function(){this.play();}"."\n";
$javascript .= "	};"."\n";
$javascript .= "	var scroller".$params->get( 'moduleclass_sfx' )." = new QScroller('qscroller".$params->get( 'moduleclass_sfx' )."',opt".$params->get( 'moduleclass_sfx' ).");"."\n";
$javascript .= "	scroller".$params->get( 'moduleclass_sfx' ).".load();"."\n";
$javascript .= "	});"."\n";
$javascript .= "\n";
$document->addScriptDeclaration( $javascript );
*/    
    
	switch ($mode)
	{
		case 'T':
			include(dirname(__FILE__).DS.'js'.DS.'ticker.js');
			break;
		case 'V':

        //$wowslider_style = "basic_linear";
        //$wowslider_style = "squares";
        //$wowslider_style = "fade";
        $wowslider_style = $params->def("wowsliderstyle");
        
			//include(dirname(__FILE__).DS.'js'.DS.'qscrollerv.js');
            //$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/qscrollerv.js');
			//$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/qscroller.js');
            //$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/jquery.simplyscroll.js');
            $document->addStyleSheet(JURI::base().'modules/mod_sportsmanagement_club_birthday/css/'.$wowslider_style.'.css');
            
            //$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/wowslider.js');
            //$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/'.$wowslider_style.'.js');
            
            
//$javascript = '
//// init main object
//// jQuery(document).ready - conflicted with some scripts
//// Transition time = 2.4s = 20/10
//// SlideShow delay = 6.5s = 23/10
//jQuery(\'#wowslider-container\').wowSlider({
//	effect:"carousel_basic", 
//	prev:"", 
//	next:"", 
//	duration: 23*100, 
//	delay:20*100, 
//	width:830,
//	height:360,
//	autoPlay:true,
//	autoPlayVideo:false,
//	playPause:false,
//	stopOnHover:false,
//	loop:false,
//	bullets:1,
//	caption: true, 
//	captionEffect:"fade",
//	controls:true,
//	responsive:1,
//	fullScreen:false,
//	gestures: 2,
//	onBeforeStep:0,
//	images:0
//});
//';
//$javascript .= "\n";
//$document->addScriptDeclaration( $javascript );




			break;
		case 'H':
			//include(dirname(__FILE__).DS.'js'.DS.'qscrollerh.js');
            //$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/qscrollerh.js');
			//$document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/qscroller.js');
            $document->addScript(JURI::base().'modules/mod_sportsmanagement_club_birthday/js/wowslider.js');
			break;
	}
    
}




require(JModuleHelper::getLayoutPath('mod_'.$module->name));
?>
