<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * HelloWorlds Controller
 */
class sportsmanagementControllerpersons extends JControllerAdmin
{
 
    
    function saveshort()
	{
	   $model = $this->getModel();
       $model->saveshort();
    } 
    
      
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Person', $prefix = 'sportsmanagementModel') 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}