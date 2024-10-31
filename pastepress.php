<?php

/*
Plugin Name: PastePress
Plugin URI: http://pastepress.blogspot.com
Description: The plugin will allow users to embed a pastebin form into a wordpress page or post.
Version: 0.1_pre-alpha2
Author: Mirko Grewing
Author URI: http://www.hairiavviato.it
License: GPL2
*/

define('PASTEPRESS_VERSION', '0.1_pre-alpha2');

/*  Copyright 2010  Mirko Grewing  (email : mirko.grewing@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

////////////////////////////////////////////////////////////////////////////////
// Version History
//
// See readme.txt
//
// v0.1_pre-alpha2
// - Added internationalization and some other stuffs...
//
////////////////////////////////////////////////////////////////////////////////

// Some check on PHP configuration
error_reporting(E_ALL);
$ver = (int)implode('',explode('.', PHP_VERSION ));
if ( $ver < 520 )
{
	die('You need PHP >= 5.2 to have this script correctly working.');
}
/* if ( get_magic_quotes_gpc() == 1 )
{
	die('Magic quotes are on. Please add \'php_flag magic_quotes_gpc off\' to your .htaccess configuration or update your php.ini.');
} */
if ( ini_get("register_globals") )
{
	die('register_globals is on. Please add \'php_flag register_globals off\' to your .htaccess configuration or update your php.ini.');
}

ini_set('display_errors','On');
error_reporting(E_ALL);

ini_set('display_errors','Off');
error_reporting(E_NONE);

// These variables will be set by an option page in future release.

$config = array();
$config['idlen'] = 13;	// Length of the IDs 
$config['showen'] = 15;	// How many will be shown on the index page - 0 to show none
$config['keepen'] = 20; // How many entries are kept after an update - 0 to keep every entry (not recommended for large sites)
$config['age'] = 0; // And for how long; but ignored if the above is used - 0 to keep forever; otherwise in seconds

/* LANGUAGE */
load_plugin_textdomain('pastepress',PLUGINDIR.DIRECTORY_SEPARATOR.PASTEPRESS_FOLDER);

function modReader($text) {
	$caller = "<!-PASTEPRESS->";
	$htmlcode = "<form id='new' method='post' enctype='multipart/form-data' action='pastepress.php'>
                    <ul id='fields'>
                        <li><label>".__('Title').":<input type='text' name='subject' value=''></label></li>
                        <li><label>".__('Content').":<textarea name='content' rows='30' cols='50'></textarea></label></li>
                        <li><input id='ms2' type='submit' value=".__('Post')." name='xsubmit'></li>
                    </ul>
                 </form>";
	$text = str_replace($caller,$htmlcode,$text);
	return $text;
}

add_filter('the_content',modReader,1);

?>