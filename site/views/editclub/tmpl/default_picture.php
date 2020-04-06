<?php
/**
*
 * SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
 *
 * @version    1.0.05
 * @file       default_picture.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @package    sportsmanagement
 * @subpackage editclub
 */

defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Language\Text;

?>

        <fieldset class="adminform">
            <legend><?php echo Text::_('COM_SPORTSMANAGEMENT_ADMIN_CLUB_LOGO');?>
            </legend>
            <table class="admintable" border='0'>
        <?php foreach ($this->form->getFieldset('picture') as $field): ?>
                    <tr>
                        <td class="key"><?php echo $field->label; ?></td>
                        <td><?php echo $field->input; ?></td>
                    </tr>                  
        <?php endforeach; ?>
            </table>
        </fieldset>
      
