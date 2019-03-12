<?php
/**
 * @package    greencart
 *
 * @author     matt <info@greenkey.ru>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://greenkey.ru
 */

use Joomla\CMS\MVC\Controller\BaseController;

defined('_JEXEC') or die;

/**
 * Greencart controller.
 *
 * @package  greencart
 * @since    1.0
 */
class GreencartControllerGreencart extends BaseController
{
	public function formyml() {
		// Get the model of Get Contacts
		//$model = $this->getModel('geocontacts', 'GeocontactModel');

		// Create new items in DB
		//$model->newItems();

		echo "forming!";
	}

}
