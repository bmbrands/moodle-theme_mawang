<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * The configuration for Mawang theme is defined here.
 *
 * For full list of the configurable properties refer to {@see theme_config::__construct()} function
 *
 * Documentation: {@link https://docs.moodle.org/dev/Themes}
 *
 * @package    theme_mawang
 * @copyright  2025 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Variable $THEME is defined before this page is included and we can define settings by adding properties to this global object.

// The first setting we need is the name of the theme. This should be the last part of the component name, and the same
// as the directory name for our theme.
$THEME->name = 'mawang';

// This is a critical setting. We want to inherit from theme_boost because it provides a great starting point for SCSS bootstrap
// themes. We could add more than one parent here to inherit from multiple parents, and if we did they would be processed in
// order of importance (later themes overriding earlier ones). Things we will inherit from the parent theme include
// styles and mustache templates and some (not all) settings.
$THEME->parents = ['boost'];

// This setting list the style sheets we want to include in our theme. Because we want to use SCSS instead of CSS - we won't
// list any style sheets. If we did we would list the name of a file in the /style/ folder for our theme without any css file
// extensions.
$THEME->sheets = [];

$THEME->layouts = [

    // Main course page.
    'course' => array(
        'file' => 'course.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu' => true),
    ),
    'incourse' => array(
        'file' => 'course.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
    ),
];

// This is a setting that can be used to provide some styling to the content in the TinyMCE text editor. This is no longer the
// default text editor and "Atto" does not need this setting so we won't provide anything. If we did it would work the same
// as the previous setting - listing a file in the /styles/ folder.
$THEME->editor_sheets = [];

// Whether a fallback version of the stylesheet will be used whilst the final version is generated.
$THEME->usefallback = true;

// This setting defines the main scss file for our theme to be compiled. We could set it to a static file in the scss folder
// or to a function which returns the SCSS based on theme settings.
$THEME->scss = function($theme) {
    return theme_mawang_get_main_scss_content($theme);
};

// A dock is a way to take blocks out of the page and put them in a persistent floating area on the side of the page. Boost
// does not support a dock so we won't either - but look at bootstrapbase for an example of a theme with a dock.
$THEME->enable_dock = false;

// Name of the function in lib.php file that returns SCSS that can be dynamically added after the main SCSS contents.
// It is usually built based on the settings values.
$THEME->extrascsscallback = 'theme_mawang_get_extra_scss';

// Name of the function in lib.php file that returns SCSS that can be dynamically added before the main SCSS contents.
// It is usually built based on the settings values.
$THEME->prescsscallback = 'theme_mawang_get_pre_scss';

// Name of the funciton in lib.php file that return the precompiled CSS.
$THEME->precompiledcsscallback = 'theme_mawang_get_precompiled_css';

// This is an old setting used to load specific CSS for some YUI JS. We don't need it in Boost based themes because Boost
// provides default styling for the YUI modules that we use. It is not recommended to use this setting anymore.
$THEME->yuicssmodules = [];

// Most themes will use this rendererfactory as this is the one that allows the theme to override any other renderer.
$THEME->rendererfactory = theme_overridden_renderer_factory::class;

// This is a list of blocks that are required to exist on all pages for this theme to function correctly. For example
// bootstrap base requires the settings and navigation blocks because otherwise there would be no way to navigate to all the
// pages in Moodle. Boost does not require these blocks because it provides other ways to navigate built into the theme.
$THEME->requiredblocks = '';

// This is a feature that tells the blocks library not to use the "Add a block" block. We don't want this in boost based themes
// because it forces a block region into the page when editing is enabled and it takes up too much room.
$THEME->addblockposition = BLOCK_ADDBLOCK_POSITION_FLATNAV;

// Whether theme supports course index (area on the left of the course index page that has a list of all activities).
$THEME->usescourseindex = true;

// Name of the class extending \core\output\icon_system that is used for rendering icons.
$THEME->iconsystem = \core\output\icon_system::FONTAWESOME;

// Whether theme provides a Edit on/off switch. If disabled, a button "Turn editing on/off" will be added to the pages.
$THEME->haseditswitch = true;

// List of items from the primary navigation that theme wants to remove.
$THEME->removedprimarynavitems = [];

// By default, all boost theme do not need their titles displayed.
$THEME->activityheaderconfig = [
    'notitle' => true,
];

$THEME->larrow = '<span class="icon fa fa-angle-left" aria-hidden="true"></span>';
$THEME->rarrow = '<span class="icon fa fa-angle-right" aria-hidden="true"></span>';

// We do not override $THEME->layouts here, they are taken from parent theme Boost.
// If you need to define your own layouts start by copying them from the parent theme.
