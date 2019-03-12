<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Greenkey 
/-------------------------------------------------------------------------------------------------------/

	@version		0.0.2
	@build			12th марта, 2019
	@created		12th марта, 2019
	@package		Greencart
	@subpackage		greencart.php
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
JHtml::_('behavior.tabstate');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_greencart'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
};

// Add CSS file for all pages
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_greencart/assets/css/admin.css');
$document->addScript('components/com_greencart/assets/js/admin.js');

// require helper files
JLoader::register('GreencartHelper', __DIR__ . '/helpers/greencart.php'); 
JLoader::register('JHtmlBatch_', __DIR__ . '/helpers/html/batch_.php'); 

// Get an instance of the controller prefixed by Greencart
$controller = JControllerLegacy::getInstance('Greencart');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
