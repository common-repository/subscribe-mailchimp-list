<?php
/*
* Plugin Name: Subscribe MailChimp List
* Description: The plugin allows you to add an Email collection form using the MailChimp API using AJAX. Using this plugin there are several ways-widget, shortcode, hook
* Author: Petrozavodsky, vovasik
* Author URI: https://alkoweb.ru
* Plugin URI: https://alkoweb.ru/subscribe-mail-chimp-list/
* License: GPLv3
* Text Domain: SubscribeMailChimpList
* Domain Path: /languages
* Requires PHP: 5.6
* Version: 1.1.2
*/

if (!defined('ABSPATH')) {
    exit;
}

require_once(plugin_dir_path(__FILE__) . "includes/Autoloader.php");

use SubscribeMailChimpList\Autoloader;

new Autoloader(__FILE__, 'SubscribeMailChimpList');


use SubscribeMailChimpList\Base\Wrap;
use SubscribeMailChimpList\Classes\Admin;
use SubscribeMailChimpList\Classes\AjaxHandle;
use SubscribeMailChimpList\Classes\Form;
use SubscribeMailChimpList\Classes\MailChimpAjax;
use SubscribeMailChimpList\Classes\Shortcode;
use SubscribeMailChimpList\Utils\ActivateWidgets;

class SubscribeMailChimpList extends Wrap
{
    public $version = '1.1.2';
    public static $textdomine;

    function __construct()
    {
        self::$textdomine = $this->setTextdomain();

        new Admin();

        new AjaxHandle();

        new MailChimpAjax();

        new Form();

        new Shortcode(
            'SubscribeMailChimpList',
            [
                'title' => __('Subscribe to our newsletter', 'SubscribeMailChimpList'),
            ]
        );

        new ActivateWidgets(
            __FILE__,
            'Widgets',
            'SubscribeMailChimpList'
        );

    }

}

function SubscribeMailChimpList__init()
{
    new SubscribeMailChimpList();
}

add_action('plugins_loaded', 'SubscribeMailChimpList__init', 30);
