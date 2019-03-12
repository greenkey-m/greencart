<?php
/**
 * @package    greencart
 *
 * @author     matt <info@greenkey.ru>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://greenkey.ru
 */

use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

/**
 * Greencart view.
 *
 * @package  greencart
 * @since    1.0
 */
class GreencartViewGreencart extends HtmlView
{
	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		$this->user = JFactory::getUser();

		// Check for errors
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar() {
		JToolBarHelper::custom('greencart.foryml', 'download.png', 'download_f2.png', 'JGREENCART_YML');
	}


}
