<?php
/**
 * SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage models
 * @file       club.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Filter\OutputFilter;

/**
 * sportsmanagementModelclub
 *
 * @package
 * @author
 * @copyright diddi
 * @version   2014
 * @access    public
 */
class sportsmanagementModelclub extends JSMModelAdmin
{

	/**
	 * Override parent constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see   BaseDatabaseModel
	 * @since 3.2
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

	}

	/**
	 * Method to update checked clubs
	 *
	 * @access public
	 * @return boolean    True on success
	 */
	function saveshort()
	{
		$app    = Factory::getApplication();
		$option = Factory::getApplication()->input->getCmd('option');

		// Get the input
		$pks  = Factory::getApplication()->input->getVar('cid', null, 'post', 'array');
		$post = Factory::getApplication()->input->post->getArray(array());

		$result = true;

		for ($x = 0; $x < count($pks); $x++)
		{
			$address_parts  = array();
			$address_parts2 = array();
			$tblClub        = &$this->getTable();

			$tblClub->id       = $pks[$x];
			$tblClub->zipcode  = $post['zipcode' . $pks[$x]];
			$tblClub->location = $post['location' . $pks[$x]];
			$tblClub->address  = $post['address' . $pks[$x]];
			$tblClub->country  = $post['country' . $pks[$x]];
            $tblClub->founded_year  = $post['founded_year' . $pks[$x]];

			$tblClub->unique_id   = $post['unique_id' . $pks[$x]];
			$tblClub->new_club_id = $post['new_club_id' . $pks[$x]];
			$tblClub->name = $post['club_name' . $pks[$x]];
			$tblClub->alias = OutputFilter::stringURLSafe($tblClub->name);

			if (!empty($tblClub->address))
			{
				$address_parts[] = $tblClub->address;
			}

			if (!empty($tblClub->location))
			{
				if (!empty($tblClub->zipcode))
				{
					$address_parts[]  = $tblClub->zipcode . ' ' . $tblClub->location;
					$address_parts2[] = $tblClub->zipcode . ' ' . $tblClub->location;
				}
				else
				{
					$address_parts[]  = $tblClub->location;
					$address_parts2[] = $tblClub->location;
				}
			}

			if (!empty($tblClub->country))
			{
				$address_parts[]  = JSMCountries::getShortCountryName($tblClub->country);
				$address_parts2[] = JSMCountries::getShortCountryName($tblClub->country);
			}

			$address = implode(', ', $address_parts);
			$coords  = sportsmanagementHelper::resolveLocation($address);

			if ($coords)
			{
				$tblClub->latitude  = $coords['latitude'];
				$tblClub->longitude = $coords['longitude'];
			}
			else
			{
			}

			if (!$tblClub->store())
			{
				$result = false;
			}
		}

		return $result;
	}


	/**
	 * sportsmanagementModelclub::teamsofclub()
	 *
	 * @param   mixed  $club_id
	 *
	 * @return void
	 */
	function teamsofclub($club_id)
	{
		$this->jsmquery->clear();
		$this->jsmquery->select('t.id,t.name,t.club_id');
		$this->jsmquery->from('#__sportsmanagement_team AS t');
		$this->jsmquery->where('t.club_id = ' . $club_id);
		$this->jsmdb->setQuery($this->jsmquery);
        try{
		$teamsofclub = $this->jsmdb->loadObjectList();
        return $teamsofclub;
        }
		catch (Exception $e)
		{
        $this->jsmapp->enqueueMessage(Text::sprintf('COM_SPORTSMANAGEMENT_DATABASE_ERROR_FUNCTION_FAILED', $e->getCode(), $e->getMessage()), 'notice');
        $this->jsmapp->enqueueMessage(Text::sprintf('COM_SPORTSMANAGEMENT_FILE_ERROR_FUNCTION_FAILED', __FILE__, __LINE__), 'notice');
        return false;
		}

	}


}
