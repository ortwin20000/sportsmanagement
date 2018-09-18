<?php
/** SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version   1.0.05
 * @file      season.php
 * @author    diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license   This file is part of SportsManagement.
 * @package   sportsmanagement
 * @subpackage season
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;

/**
 * sportsmanagementModelseason
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModelseason extends JSMModelAdmin
{

	/**
	 * Override parent constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JModelLegacy
	 * @since   3.2
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
	
//    $this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' config<br><pre>'.print_r($config,true).'</pre>'),'');
//    $this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' getName<br><pre>'.print_r($this->getName(),true).'</pre>'),'');
    
	}	
    
    /**
     * sportsmanagementModelseason::saveshortpersons()
     * 
     * @return void
     */
    function saveshortpersons()
    {
        // Reference global application object
        //$app = JFactory::getApplication();
        // JInput object
        //$jinput = $app->input;
        //$option = $jinput->getCmd('option');
        //$db = sportsmanagementHelper::getDBConnection();
        
        //$date = JFactory::getDate();
//	   $user = JFactory::getUser();
       $modified = $this->jsmdate->toSql();
	   $modified_by = $this->jsmuser->get('id');
       
        //$post = JFactory::getApplication()->input->post->getArray(array());
        //$post = $jinput->post;
        $pks = $this->jsmjinput->getVar('cid', null, 'post', 'array');
        $teams = $this->jsmjinput->getVar('team_id', null, 'post', 'array');
        $season_id = $this->jsmjinput->getVar('season_id', 0, 'post', 'array');
        $persontype = $this->jsmjinput->getVar('persontype', 0, 'post', 'array');
        
        //$app->enqueueMessage(__METHOD__.' '.__LINE__.' pks<br><pre>'.print_r($pks, true).'</pre><br>','');
        //$app->enqueueMessage(__METHOD__.' '.__LINE__.' teams<br><pre>'.print_r($teams, true).'</pre><br>','');
        
        foreach ( $pks as $key => $value )
        {
        // Create a new query object.
        //$query = $db->getQuery(true);
	$this->jsmquery->clear();	
        // Insert columns.
        $columns = array('person_id','season_id','modified','modified_by');
        // Insert values.
        $values = array($value,$season_id,$db->Quote(''.$modified.''),$modified_by);
        // Prepare the insert query.
        $this->jsmquery
            ->insert($this->jsmdb->quoteName('#__sportsmanagement_season_person_id'))
            ->columns($this->jsmdb->quoteName($columns))
            ->values(implode(',', $values));
            try{
        // Set the query using our newly populated query object and execute it.
        $this->jsmdb->setQuery($this->jsmquery);
	$this->jsmdb->execute();
        }
catch (Exception $e) {
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getMessage()),'Error');
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getCode()),'Error');  
}

        if ( isset($teams) && $persontype != 3 )
        {
        $this->jsmquery->clear();
        // Insert columns.
        $columns = array('person_id','season_id','team_id','published','persontype','modified','modified_by'   );
        // Insert values.
        $values = array($value,$season_id,$teams,'1',$persontype,$db->Quote(''.$modified.''),$modified_by);
        // Prepare the insert query.
        $this->jsmquery
            ->insert($this->jsmdb->quoteName('#__sportsmanagement_season_team_person_id'))
            ->columns($this->jsmdb->quoteName($columns))
            ->values(implode(',', $values));
            try{
        // Set the query using our newly populated query object and execute it.
        $this->jsmdb->setQuery($this->jsmquery);
$this->jsmdb->execute();
        }
catch (Exception $e) {
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getMessage()),'Error');
$this->jsmapp->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getCode()),'Error');  
}
		
        
        }
             
        }
        
    }
    
    /**
     * sportsmanagementModelseason::saveshortteams()
     * 
     * @return void
     */
    function saveshortteams()
    {
        // Reference global application object
        $app = JFactory::getApplication();
        // JInput object
        $jinput = $app->input;
        $option = $jinput->getCmd('option');
        $db = sportsmanagementHelper::getDBConnection();
        //$post = JFactory::getApplication()->input->post->getArray(array());
        //$post = $jinput->post;
        $pks = $jinput->getVar('cid', null, 'post', 'array');
        $season_id = $jinput->getVar('season_id', 0, 'post', 'array');
        
//        $app->enqueueMessage(__METHOD__.' '.__LINE__.' season_id<br><pre>'.print_r($season_id, true).'</pre><br>','');
//        $app->enqueueMessage(__METHOD__.' '.__LINE__.' pks<br><pre>'.print_r($pks, true).'</pre><br>','');
//        $app->enqueueMessage(__METHOD__.' '.__LINE__.' post<br><pre>'.print_r($post, true).'</pre><br>','');
        
        foreach ( $pks as $key => $value )
        {
            // Create a new query object.
        $query = $db->getQuery(true);
        // Insert columns.
        $columns = array('team_id','season_id');
        // Insert values.
        $values = array($value,$season_id);
        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__sportsmanagement_season_team_id'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
        try{
        // Set the query using our newly populated query object and execute it.
        $db->setQuery($query);
	$db->execute();
        }
catch (Exception $e) {
$app->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getMessage()),'Error');
$app->enqueueMessage(__METHOD__.' '.__LINE__.' '. Text::_($e->getCode()),'Error');  
} 
        
        }
        
    }
	
}
