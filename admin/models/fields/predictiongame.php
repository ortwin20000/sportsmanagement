<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      predictiongame.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage fields
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Form\FormField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;

if (! defined('DS'))
{
	define('DS', DIRECTORY_SEPARATOR);
}

if ( !defined('JSM_PATH') )
{
DEFINE( 'JSM_PATH','components/com_sportsmanagement' );
}

// prüft vor Benutzung ob die gewünschte Klasse definiert ist
if ( !class_exists('sportsmanagementHelper') ) 
{
//add the classes for handling
$classpath = JPATH_ADMINISTRATOR.DS.JSM_PATH.DS.'helpers'.DS.'sportsmanagement.php';
JLoader::register('sportsmanagementHelper', $classpath);
BaseDatabaseModel::getInstance("sportsmanagementHelper", "sportsmanagementModel");
}

/**
 * FormFieldPredictiongame
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class JFormFieldPredictiongame extends FormField
{

	protected $type = 'predictiongame';
	
	/**
	 * FormFieldPredictiongame::getInput()
	 * 
	 * @return
	 */
	function getInput() 
    {
		$db = sportsmanagementHelper::getDBConnection();
		$lang = Factory::getLanguage();
        // welche tabelle soll genutzt werden
        $params = ComponentHelper::getParams( 'com_sportsmanagement' );
		$query = $db->getQuery(true);
			
            $query->select('CONCAT_WS( \':\', pg.id, pg.name ) AS id');
			//$query->select('pg.id');
            $query->select('pg.name');

            $query->from('#__sportsmanagement_prediction_game pg');    
            
			$query->where('pg.published = 1');
			$query->order('pg.name');
            
			$db->setQuery($query);
			$options = $db->loadObjectList();
        
		$mitems = array(HTMLHelper::_('select.option', '', Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT')));

		foreach ( $options as $option ) {
			$mitems[] = HTMLHelper::_('select.option',  $option->id, '&nbsp;'.$option->name. ' ('.$option->id.')' );
		}
		
		$output = HTMLHelper::_('select.genericlist',  $mitems, $this->name, 'class="inputbox" multiple="multiple" size="10"', 'value', 'text', $this->value, $this->id );
		return $output;
	}
}
 
