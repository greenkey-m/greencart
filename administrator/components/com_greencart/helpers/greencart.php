<?php
/**
 * @package    greencart
 *
 * @author     matt <info@greenkey.ru>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://greenkey.ru
 */

use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

/**
 * Greencart helper.
 *
 * @package     A package name
 * @since       1.0
 */
class GreencartHelper
{
	/**
	 * Render submenu.
	 *
	 * @param   string  $vName  The name of the current view.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	public function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(Text::_('COM_GREENCART'), 'index.php?option=com_greencart&view=greencart', $vName == 'greencart');
	}
}
