<?php
defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/externallib.php");

class local_api_course_service extends external_api {

    public static function get_course_categories_courses_parameters() {
        return new external_function_parameters([]);
    }

    public static function get_course_categories_courses() {
        global $DB, $USER;
    
        $systemcontext = context_system::instance();
        $categories = $DB->get_records('course_categories', array('visible'=>1));
    
        $filteredcategories = array();
        foreach ($categories as $category) {
            $categorycontext = context_coursecat::instance($category->id);
            if (has_capability('moodle/category:viewcourselist', $categorycontext)) {
                $filteredcategories[$category->id] = $category;
            }
        }

        return $filteredcategories;
    }

    public static function get_course_categories_courses_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                    'id' => new external_value(PARAM_INT, 'Category ID'),
                    'name' => new external_value(PARAM_TEXT, 'Category Name'),
                    'idnumber' => new external_value(PARAM_RAW, 'Category ID number', VALUE_OPTIONAL),
                    'description' => new external_value(PARAM_RAW, 'Category description', VALUE_OPTIONAL),
                    'descriptionformat' => new external_value(PARAM_INT, 'Description format', VALUE_OPTIONAL),
                    'parent' => new external_value(PARAM_INT, 'Parent category ID', VALUE_OPTIONAL),
                    'sortorder' => new external_value(PARAM_INT, 'Sort order', VALUE_OPTIONAL),
                    'coursecount' => new external_value(PARAM_INT, 'Course count', VALUE_OPTIONAL),
                    'visible' => new external_value(PARAM_INT, 'Visibility', VALUE_OPTIONAL),
                    'timemodified' => new external_value(PARAM_INT, 'Time modified', VALUE_OPTIONAL),
                    'depth' => new external_value(PARAM_INT, 'Depth', VALUE_OPTIONAL),
                    'path' => new external_value(PARAM_TEXT, 'Path', VALUE_OPTIONAL),
                    'theme' => new external_value(PARAM_TEXT, 'Theme', VALUE_OPTIONAL)
                )
            )
        );
    }
}