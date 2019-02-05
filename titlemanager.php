<?php
/**
 * @copyright	(C) 2016 Lyquix. All rights reserved.
 * @license     GNU GPL <http://www.gnu.org/licenses/gpl.html>
 * @author		Lyquix <info@lyquix.com>
 * @link        http://www.lyquix.com
 */

defined('_JEXEC') or die ;

jimport('joomla.plugin.plugin');

class plgSystemTitlemanager extends JPlugin {

	public function onAfterInitialise() {

		$config = JFactory::getConfig();
		if ($config -> get('sitename_pagetitles')) $config -> set('sitename_pagetitles', 0);

	}

	public function onAfterDispatch() {

		$app = JFactory::getApplication();

		if (!$app -> isSite()) return;

		$params = $this -> params;
		$document = JFactory::getDocument();
		$menu = $app -> getMenu();
		$is_homepage = ($menu -> getActive() == $menu -> getDefault());

		// Set the site name (global config or override)
		$sitename = $params -> get('sitename_mode', 0) ? $params -> get('sitename_override') : $app -> getCfg('sitename');

		if ($is_homepage && $params -> get('homepage_mode', 'sitename') != 'default') {

			switch($params -> get('homepage_mode', 'sitename')) {

				case 'sitename':

					$document -> setTitle($sitename);
					break;

				case 'override':

					$document -> setTitle($params -> get('homepage_override'));
					break;

			}

		}

		else {

			if ($params -> get('ordering', '') == 'after') $title = $document -> getTitle() . $params -> get('separator') . $sitename;
			else $title = $sitename . $params -> get('separator') . $document -> getTitle();

			$document -> setTitle($title);

		}

		return;

	}

}
