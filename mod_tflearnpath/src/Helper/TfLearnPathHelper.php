<?php
/*
* @package		TFLearnpath Module
* @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

namespace TfLearn\Module\TfLearnPath\Site\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use TechFry\Library\TfDb;
use TechFry\Component\TfLearn\Administrator\Helper\LessonHelper;
use TechFry\Component\TfLearn\Administrator\Helper\CourseHelper;

class TfLearnPathHelper
{
    public static function getCoursePath($courseId, $params)
    {
        $user = Factory::getApplication()->getIdentity();
        $course = TfDb::get_item('tfl_courses', $courseId);
        
        // Check for access using CourseHelper::is_enrolled
        if (!$course || !CourseHelper::is_enrolled($courseId, $user->id)) {
            return null;
        }

        $modules = json_decode($course->modules, true) ?: [];  //Extract the modules from JSON data
        $path = [];
        $i = 0;

        foreach ($modules as $module) {
            $moduleId = $module['module_id']; //Extract the module ID from the $module array
            
            // Fetch module details from the database using the module ID
            $mod = TfDb::get_item('tfl_modules', $moduleId); 
            if ($mod && $mod->published) {
                $mod->title = $module['module_name'] ?: $mod->title;

                $lessons = LessonHelper::get_lessons($moduleId, 1);

                if ($lessons) {
                    //Get the sort method
                    $orderCol = $params->get('lessons_order_col', 'ordering');
                    // Get the sort direction
                    $orderDirn = $params->get('lessons_order_dirn', 'ASC');

                    usort($lessons, function ($a, $b) use ($orderCol, $orderDirn) {
                        $valA = $a->$orderCol ?? 0;
                        $valB = $b->$orderCol ?? 0;

                        if ($valA == $valB) {
                            return 0;
                        }

                        if ($orderDirn === 'ASC') {
                            return ($valA < $valB) ? -1 : 1;
                        } else {
                            return ($valA > $valB) ? -1 : 1;
                        }
                    });
                }

                $path[$i] = [ //Build an array entry for each module’s title and lessons
                    '<div>' . htmlspecialchars($mod->title) . '</div>',
                    $lessons ?: [] // Use lessons if available, otherwise an empty array
                ];
                $i++;
            }
        }

        return [
            'course' => $course,
            'tabs' => $path
        ];
    }
}