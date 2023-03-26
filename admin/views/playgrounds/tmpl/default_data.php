<?php
/**
 * SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage playgrounds
 * @file       default_data.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013-2023 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;

$this->saveOrder = $this->sortColumn == 'v.ordering';
if ($this->saveOrder && !empty($this->items))
{
$saveOrderingUrl = 'index.php?option=com_sportsmanagement&task='.$this->view.'.saveOrderAjax&tmpl=component&' . Session::getFormToken() . '=1';
if (version_compare(substr(JVERSION, 0, 3), '4.0', 'ge'))
{    
HTMLHelper::_('draggablelist.draggable');
}
else
{
HTMLHelper::_('sortablelist.sortable', $this->view.'list', 'adminForm', strtolower($this->sortDirection), $saveOrderingUrl,$this->saveOrderButton);    
}
}

?>
<div class="table-responsive" id="editcell_playgrounds">
    <table class="<?php echo $this->table_data_class; ?>">
        <thead>
        <tr>
            <th width="1%"
                class="nowrap center hidden-phone"><?php echo Text::_('COM_SPORTSMANAGEMENT_GLOBAL_NUM'); ?></th>
            <th width="1%" class="nowrap center">
                <?php echo HTMLHelper::_('grid.checkall'); ?>
            </th>
            <th width="10%" class="nowrap">
				<?php
				echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_NAME', 'v.name', $this->sortDirection, $this->sortColumn);
				?>
            </th>
            <th width="1%" class="hidden-phone">
				<?php
				echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_S_NAME', 'v.short_name', $this->sortDirection, $this->sortColumn);
				?>
            </th>
            <th width="1%" class="hidden-phone">
				<?php
				echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_CLUBNAME', 'club', $this->sortDirection, $this->sortColumn);
				?>
            </th>
            <th width="1%" class="center hidden-phone">
				<?php
				echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_CAPACITY', 'v.max_visitors', $this->sortDirection, $this->sortColumn);
				?>
            </th>
            <th width="1%" class="hidden-phone">
				<?php
				echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_IMAGE', 'v.picture', $this->sortDirection, $this->sortColumn);
				?>
            </th>
            <th width="1%" class="nowrap hidden-phone">
				<?php echo Text::_('COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_CITY'); ?>
            </th>
            <!-- <th width="1%" class="hidden-phone">
                    <?php //echo Text::_('COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_LATITUDE'); ?>
                </th>
                <th width="1%" class="hidden-phone">
                    <?php //echo Text::_('COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_LONGITUDE'); ?>
                </th>-->
            <th width="1%" class="hidden-phone">
				<?php echo HTMLHelper::_('grid.sort', 'COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_COUNTRY', 'v.country', $this->sortDirection, $this->sortColumn); ?>
            </th>
            <th width="5%" class="nowrap center hidden-phone">
				<?php
				echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ORDERING', 'v.ordering', $this->sortDirection, $this->sortColumn);
				echo HTMLHelper::_('grid.order', $this->items, 'filesave.png', 'playgrounds.saveorder');
				?>
            </th>
            <th width="1%" class="nowrap center hidden-phone">
				<?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'v.id', $this->sortDirection, $this->sortColumn); ?>
            </th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <td colspan="11" class="center">
				<?php echo $this->pagination->getListFooter(); ?>
				<?php echo $this->pagination->getResultsCounter(); ?>
            </td>
        </tr>
        </tfoot>
        <tbody <?php if ( $this->saveOrder && version_compare(substr(JVERSION, 0, 3), '4.0', 'ge') ) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($this->sortDirection); ?>" <?php endif; ?>>
		<?php
		
			foreach ($this->items as $this->count_i => $this->item) 
			{
if (version_compare(substr(JVERSION, 0, 3), '4.0', 'ge'))
{
$this->dragable_group = 'data-dragable-group="none"';
}       
			
			$link       = Route::_('index.php?option=com_sportsmanagement&task=playground.edit&id=' . $this->item->id);
			$canEdit    = $this->user->authorise('core.edit', 'com_sportsmanagement');
			$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $this->item->checked_out == $this->user->get('id') || $this->item->checked_out == 0;
			$checked    = HTMLHelper::_('jgrid.checkedout', $this->count_i, $this->user->get('id'), $this->item->checked_out_time, 'playgrounds.', $canCheckin);
			?>
            <tr class="row<?php echo $this->count_i % 2; ?>" <?php echo $this->dragable_group; ?>>
                <td class="center hidden-phone">
					<?php
					echo $this->pagination->getRowOffset($this->count_i);
					?>
                </td>
                <td class="center">
					<?php
					echo HTMLHelper::_('grid.id', $this->count_i, $this->item->id);
					?>
                </td>
				<?php
				$inputappend = '';
				?>
                <td class="">
					<?php if ($this->item->checked_out) : ?>
						<?php echo HTMLHelper::_('jgrid.checkedout', $this->count_i, $this->item->editor, $this->item->checked_out_time, 'playgrounds.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit) : ?>
                        <a href="<?php echo Route::_('index.php?option=com_sportsmanagement&task=playground.edit&id=' . (int) $this->item->id); ?>">
							<?php echo $this->escape($this->item->name); ?></a>
					<?php else : ?>
						<?php echo $this->escape($this->item->name); ?>
					<?php endif; ?>
					<?php //echo $checked;  ?>
					<?php //echo $this->item->name;  ?>
                    <div class="small">
						<?php echo Text::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($this->item->alias)); ?></div>
                </td>
                <td class="center hidden-phone"><?php echo $this->item->short_name; ?></td>
                <td class="hidden-phone"><?php echo $this->item->club; ?></td>
                <td class="center hidden-phone">
                    <div class="badge"><?php echo $this->item->max_visitors; ?></div>
                </td>
                <td width="5%" class="center hidden-phone">
					<?php
					if ($this->item->picture == '')
					{
						$imageTitle = Text::_('COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_NO_IMAGE');
                        $image_attributes['title'] = $imageTitle;
						echo HTMLHelper::_('image', Uri::base() . '/components/com_sportsmanagement/assets/images/delete.png', $imageTitle, $image_attributes);
					}
                    elseif ($this->item->picture == sportsmanagementHelper::getDefaultPlaceholder("team"))
					{
						$imageTitle = Text::_('COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_DEFAULT_IMAGE');
                        $image_attributes['title'] = $imageTitle;
						echo HTMLHelper::_('image', Uri::base() . '/components/com_sportsmanagement/assets/images/information.png', $imageTitle, $image_attributes);
						?>
                        <a href="<?php echo Uri::root() . $this->item->picture; ?>" title="<?php echo $imageTitle; ?>"
                           class="modal">
                            <img src="<?php echo Uri::root() . $this->item->picture; ?>" alt="<?php echo $imageTitle; ?>"
                                 width="20"/>
                        </a>
						<?PHP
					}
                    elseif ($this->item->picture !== '')
					{
						$imageTitle = Text::_('COM_SPORTSMANAGEMENT_ADMIN_PLAYGROUNDS_CUSTOM_IMAGE');
                        $image_attributes['title'] = $imageTitle;
						echo HTMLHelper::_('image', Uri::base() . '/components/com_sportsmanagement/assets/images/ok.png', $imageTitle, $image_attributes);
						?>
                        <a href="<?php echo Uri::root() . $this->item->picture; ?>" title="<?php echo $imageTitle; ?>"
                           class="modal">
                            <img src="<?php echo Uri::root() . $this->item->picture; ?>" alt="<?php echo $imageTitle; ?>"
                                 width="20"/>
                        </a>
						<?PHP
					}
					?>
                </td>
                <td class="hidden-phone"><?php echo $this->item->city; ?></td>
                
                <td class="center hidden-phone"><?php echo JSMCountries::getCountryFlag($this->item->country); ?></td>
                
<td class="order" id="defaultdataorder">
<?php
echo $this->loadTemplate('data_order');
?>
</td> 
                
                <td class="center hidden-phone"><?php echo $this->item->id; ?></td>
            </tr>
			<?php
			
		}
		?>
        </tbody>
    </table>
</div>

