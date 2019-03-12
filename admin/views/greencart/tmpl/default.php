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

JHtml::_('behavior.tooltip');

?>
<div id="j-main-container">
	<div class="form-horizontal">
	<?php echo JHtml::_('bootstrap.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'cpanel', JText::_('cPanel', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_left', array('active' => 'main')); ?>
					<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', 'Control Panel', 'main'); ?>
						<?php echo $this->loadTemplate('main');?>
					<?php echo JHtml::_('bootstrap.endSlide'); ?>
				<?php echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
			<div class="span3">
				<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_right', array('active' => 'vdm')); ?>
					<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_right', 'Greenkey', 'vdm'); ?>
						<?php echo $this->loadTemplate('vdm');?>
					<?php echo JHtml::_('bootstrap.endSlide'); ?>
				<?php echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'yandex_xml', JText::_('Yandex XML', true)); ?>
		<div class="row-fluid">
			<div class="span12">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'yandex_xml_accordian', array('active' => 'yandex_xml_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'yandex_xml_accordian', 'YML', 'yandex_xml_one'); ?>
						<?php echo $this->loadTemplate('yandex_xml_yml');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
</div>