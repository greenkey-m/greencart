<?php
/**
 * @package    greencart
 *
 * @author     matt <info@greenkey.ru>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://greenkey.ru
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_greencart'))
{
	throw new InvalidArgumentException(Text::_('JERROR_ALERTNOAUTHOR'), 404);
}

// Require the helper
require_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/greencart.php';

// Execute the task
$controller = BaseController::getInstance('greencart');
$controller->execute(Factory::getApplication()->input->get('task'));
$controller->redirect();
