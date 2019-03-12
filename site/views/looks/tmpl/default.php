<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Greenkey 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.2
	@build			12th марта, 2019
	@created		12th марта, 2019
	@package		Greencart
	@subpackage		default.php
	@author			Matvey <https://greenkey.ru>	
	@copyright		Copyright (C) 2019. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<form action="<?php echo JRoute::_('index.php?option=com_greencart'); ?>" method="post" name="adminForm" id="adminForm">
<table class="uk-table uk-table-hover">
    <caption><?php echo JText::_('COM_GREENCART_LIST_OF_ALL_LOOKS'); ?></caption>
    <thead>
        <tr>
            <th><?php echo JText::_('COM_GREENCART_NAME'); ?></th>
            <th><?php echo JText::_('COM_GREENCART_DESCRIPTION'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->items as $item): ?>
        <tr>
            <td><a href="<?php echo  GreencartHelperRoute::getLookingRoute($item->slug); ?>" ><?php echo $item->name; ?></a></td>
            <td><?php echo $this->escape($item->description, true, 120); ?><?php echo $item->editLink; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<?php endif; ?>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>