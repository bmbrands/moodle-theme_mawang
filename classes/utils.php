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

namespace theme_mawang;
use completion_info;
use core_block\output\block_contents;
use core_block\output\block_move_target;
use core\exception\coding_exception;

/**
 * Class mawang
 *
 * @package    theme_mawang
 * @copyright  2025 Bas Brands <bas@sonsbeekmedia.nl>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class utils {
    /**
     * Caluclate the section progress
     * @param int $courseid
     * @return int progress percentage
     */
    public static function calculate_section_stats($courseid): int {
        $course = get_course($courseid);
        $format = course_get_format($course);
        $sectionnum = $format->get_sectionnum();
        if (!$sectionnum) {
            return 0;
        }
        $section = $format->get_section($sectionnum);
        $modinfo = $format->get_modinfo();
        $completioninfo = new completion_info($course);

        $mods = [];
        $total = 0;
        $complete = 0;

        $cmids = $modinfo->sections[$section->section] ?? [];

        $cancomplete = isloggedin() && !isguestuser();
        $showcompletion = false;
        foreach ($cmids as $cmid) {
            $thismod = $modinfo->cms[$cmid];

            if ($thismod->uservisible) {
                if (isset($mods[$thismod->modname])) {
                    $mods[$thismod->modname]['name'] = $thismod->modplural;
                    $mods[$thismod->modname]['count']++;
                } else {
                    $mods[$thismod->modname]['name'] = $thismod->modfullname;
                    $mods[$thismod->modname]['count'] = 1;
                }
                if ($cancomplete && $completioninfo->is_enabled($thismod) != COMPLETION_TRACKING_NONE) {
                    $showcompletion = true;
                    $total++;
                    $completiondata = $completioninfo->get_data($thismod, true);
                    if ($completiondata->completionstate == COMPLETION_COMPLETE ||
                            $completiondata->completionstate == COMPLETION_COMPLETE_PASS) {
                        $complete++;
                    }
                }
            }
        }

        $percentage = 0;
        if ($total > 0) {
            $percentage = round($complete / $total * 100);
        }
        self::render_section_progress($section->id, $courseid, $percentage);
        return $percentage;
    }

    /**
     * Render the section progress as a header actions
     * @param int $sectionid
     * @param int $courseid
     * @param int $progress
     */
    private static function render_section_progress($sectionid, $courseid, $progress) {
        global $PAGE, $OUTPUT;
        if ($PAGE->user_is_editing()) {
            // Do not show progress bar in editing mode.
            return;
        }

        $progressbar = $OUTPUT->render_from_template('format_mawang/local/content/progress', [
            'sectionid' => $sectionid,
            'courseid' => $courseid,
            'progress' => $progress,
        ]);

        $PAGE->add_header_action($progressbar);
    }

    /**
     * Calculate the course progress
     * @param int $courseid
     * @return int progress percentage
     */
    public static function calculate_course_stats($courseid): int {
        $course = get_course($courseid);
        $format = course_get_format($course);
        $modinfo = $format->get_modinfo();
        $completioninfo = new completion_info($course);

        $mods = [];
        $total = 0;
        $complete = 0;

        $cancomplete = isloggedin() && !isguestuser();
        $showcompletion = false;
        foreach ($modinfo->get_cms() as $cmid => $thismod) {
            if ($thismod->uservisible) {
                if (isset($mods[$thismod->modname])) {
                    $mods[$thismod->modname]['name'] = $thismod->modplural;
                    $mods[$thismod->modname]['count']++;
                } else {
                    $mods[$thismod->modname]['name'] = $thismod->modfullname;
                    $mods[$thismod->modname]['count'] = 1;
                }
                if ($cancomplete && $completioninfo->is_enabled($thismod) != COMPLETION_TRACKING_NONE) {
                    $showcompletion = true;
                    $total++;
                    $completiondata = $completioninfo->get_data($thismod, true);
                    if ($completiondata->completionstate == COMPLETION_COMPLETE ||
                            $completiondata->completionstate == COMPLETION_COMPLETE_PASS) {
                        $complete++;
                    }
                }
            }
        }

        $percentage = 0;
        if ($total > 0) {
            $percentage = round($complete / $total * 100);
        }
        return $percentage;
    }

    /**
     * Check if the current page uses fake blocks only.
     * This is used to determine if we should show the block drawer
     * @return bool
     */
    public static function is_fake_blocks_only(): bool {
        global $PAGE, $OUTPUT;

        if ($PAGE->user_is_editing()) {
            return false;
        }

        // If the page has no blocks, we assume it uses fake blocks only.
        if (!$PAGE->blocks->get_regions()) {
            return false;
        }

        $blockcontents = $PAGE->blocks->get_content_for_region('side-pre', $OUTPUT);
        $numfake = 0;
        $numreal = 0;
        foreach ($blockcontents as $bc) {
            if ($bc instanceof block_contents) {
                if ($bc->is_fake()) {
                    $numfake++;
                } else {
                    $numreal++;
                }
            }
        }
        return $numfake > 0 && $numreal == 0;
    }

}
