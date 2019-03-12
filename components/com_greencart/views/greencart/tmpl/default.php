<?php
/**
 * @package    greencart
 *
 * @author     matt <info@greenkey.ru>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://greenkey.ru
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;

defined('_JEXEC') or die;

HTMLHelper::_('script', 'com_greencart/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_greencart/style.css', array('version' => 'auto', 'relative' => true));

$layout = new FileLayout('greencart.page');
$data = array();
$data['text'] = 'Hello Joomla!';
echo $layout->render($data);
