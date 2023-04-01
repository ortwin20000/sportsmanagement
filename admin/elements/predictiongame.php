<?php
/**
 * SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage elements
 * @file       predictiongame.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013-2023 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Component\ComponentHelper;

/**
 * JFormFieldPredictiongame
 *
 * @package
 * @author
 * @copyright diddi
 * @version   2014
 * @access    public
 */
class JFormFieldPredictiongame extends JFormField
{
	protected $type = 'predictiongame';

	/**
	 * JFormFieldPredictiongame::getInput()
	 *
	 * @return
	 */
	function getInput()
	{
		$db   = sportsmanagementHelper::getDBConnection();
		$lang = Factory::getLanguage();

		// Welche tabelle soll genutzt werden
		$params         = ComponentHelper::getParams('com_sportsmanagement');
		$database_table = $params->get('cfg_which_database_table');

		$extension = "com_sportsmanagement";

		// 		$source = JPATH_ADMINISTRATOR . '/components/' . $extension;
		// 		$lang->load("$extension", JPATH_ADMINISTRATOR, null, false, false)
		// 		||	$lang->load($extension, $source, null, false, false)
		// 		||	$lang->load($extension, JPATH_ADMINISTRATOR, $lang->getDefault(), false, false)
		// 		||	$lang->load($extension, $source, $lang->getDefault(), false, false);

		$query = 'SELECT pg.id, pg.name FROM #__' . $database_table . '_prediction_game pg WHERE pg.published=1 ORDER BY pg.name';
		$db->setQuery($query);
		$clubs  = $db->loadObjectList();
		$mitems = array(HTMLHelper::_('select.option', '', Text::_('COM_SPORTSMANAGEMENT_GLOBAL_SELECT')));

		foreach ($clubs as $club)
		{
			$mitems[] = HTMLHelper::_('select.option', $club->id, '&nbsp;' . $club->name . ' (' . $club->id . ')');
		}

		$output = HTMLHelper::_('select.genericlist', $mitems, $this->name, 'class="inputbox" multiple="multiple" size="10"', 'value', 'text', $this->value, $this->id);

		return $output;
	}
}

