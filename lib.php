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
 * Callback implementations for Mawang theme
 *
 * Documentation: {@link https://docs.moodle.org/dev/Themes}
 *
 * @package    theme_mawang
 * @copyright  2025 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Returns the main SCSS content.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_mawang_get_main_scss_content($theme) {
    global $CFG;

    $scss = '';

    $scss .= file_get_contents($CFG->dirroot . '/theme/mawang/scss/main.scss');

    return $scss;
}

/**
 * Inject additional SCSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string
 */
function theme_mawang_get_extra_scss($theme) {
    return !empty($theme->settings->scss) ? $theme->settings->scss : '';
}

/**
 * Get SCSS to prepend.
 *
 * @param theme_config $theme The theme config object.
 * @return array
 */
function theme_mawang_get_pre_scss($theme) {
    return !empty($theme->settings->scsspre) ? $theme->settings->scsspre : '';
}

/**
 * Get compiled CSS.
 *
 * @param theme_config $theme The theme config object.
 * @return string compiled CSS
 */
function theme_mawang_get_precompiled_css($theme) {
    global $CFG;
    // By default fallback to Boost CSS.
    return file_get_contents($CFG->dirroot . '/theme/boost/style/moodle.css');
}
