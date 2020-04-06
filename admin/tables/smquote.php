<?php
/**
*
 * SportsManagement ein Programm zur Verwaltung für alle Sportarten
 *
 * @version    1.0.05
 * @file       smquote.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @package    sportsmanagement
 * @subpackage tables
 */


defined('_JEXEC') or die('Restricted access');

/**
 * sportsmanagementTablesmquote
 *
 * @package 
 * @author
 * @copyright diddi
 * @version   2014
 * @access    public
 */
class sportsmanagementTablesmquote extends JSMTable
{
    /**
     * Constructor
     *
     * @param object Database connector object
     * @since 1.0
     */
    function __construct(& $db)
    {
          $db = sportsmanagementHelper::getDBConnection();
        parent :: __construct('#__sportsmanagement_rquote', 'id', $db);
    }
  
}
?>
