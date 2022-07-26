<?php
/**
 * SportsManagement ein Programm zur Verwaltung für Sportarten
 * @version    1.0.05
 * @package    Sportsmanagement
 * @subpackage uefawertung
 * @file       default.php
 * @author     diddipoeler, stony, svdoldie und donclumsy (diddipoeler@gmx.de)
 * @copyright  Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$templatesToLoad = array('globalviews');
sportsmanagementHelper::addTemplatePaths($templatesToLoad, $this);

?>
<div class="<?php echo $this->divclasscontainer; ?>" id="uefawertung">
<form name="adminForm" id="adminForm" action="<?php echo htmlspecialchars($this->uri->toString()); ?>" method="post">
    <div class="<?php echo $this->divclassrow; ?> table-responsive" id="uefawertunganzeige">
		<?php
		if ($this->config['show_sectionheader'] == 1)
		{
			echo $this->loadTemplate('sectionheader');
		}
        ?>
        
        
        
<?php

echo $this->lists['coefficientyears'];
?>

 <table class="table">
        <thead>
  <tr>
  <td>
  </td>
<?php
  foreach( $this->seasonnames as $key => $value )
{
    ?>
    <td>
<?php
echo $value;
?>
</td>  
      
      <?php
  }
  
  ?>
     <td>
  </td>
    </tr>  
        </thead>
		<?php
foreach( $this->uefapoints as $key => $value )
{
?>    
<tr>
<td>
<?php
echo JSMCountries::getCountryFlag(substr($value->team, 1, 3));
echo $value->team;
?>
</td>

  
 <?php
  foreach( $this->seasonnames as $key1 => $value1 )
{
    ?>
    <td>
<?php
echo $value->$value1;
?>
</td>  
      
      <?php
  }
  
  ?> 
  
  
  
  
  
<td>
<?php
echo $value->total;
?>
</td>
</tr>  
  
<?php    
}

		?>
    </table>




<?php
		echo $this->loadTemplate('jsminfo');
		?>
    </div>
    </form>
</div>