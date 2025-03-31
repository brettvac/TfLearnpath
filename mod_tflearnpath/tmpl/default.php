<?php
/*
* @package		TF Learnpath Module
* @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use TechFry\Library\View\Sky\Block;
use TechFry\Library\View\Sky\Accordion;
use TechFry\Library\View\Sky\Tabs;
use TechFry\Component\TfLearn\Administrator\Helper\CompletionHelper;
use TechFry\Component\TfLearn\Administrator\Helper\CourseHelper;
use TechFry\Component\TfLearn\Administrator\Helper\LessonHelper;
?>

<div class="tflearn-path">
    <?php if ($path && $path['course']) : ?>
        <?php 
        // Set the CSS class for the course title from params, or empty string if not specified
        $titleClass = $params->get('module_title_class') ? ' class="' . $params->get('module_title_class') . '"' : '';
        echo '<h2' . $titleClass . '>' . htmlspecialchars($path['course']->title) . '</h2>';
        ?>

        <?php if ($path['tabs']) : ?>
            <?php
            $tabsContent = []; // Initialize an array to hold content for the layout (module titles and lesson HTML)
            $incompleteIcon = $params->get('path_incomplete_icon', 'fa-regular fa-square');
            $completeIcon = $params->get('path_complete_icon', 'fa-solid fa-square-check');
            $lockIcon = $params->get('path_lock_icon', 'fa-solid fa-lock');

            foreach ($path['tabs'] as $tab) {
                $moduleTitle = $tab[0];
                $lessons = $tab[1];
                $lessonOutput = '';

                foreach ($lessons as $lesson) {
                    $restrict = CourseHelper::check_restrict($lesson->id, $user->id, $course_id);
                    $url = Route::_('index.php?option=com_tflearn&view=page&course=' . $course_id . '&id=' . $lesson->id . ($lesson->lesson_type == 'multi' ? '&section=1' : ''));
                    $contents = LessonHelper::get_content($lesson->id);
                    
                    $totalPages = count($contents);  // Count the number of content pages for the lesson
                    // Create a clickable link to the lesson page if it has content pages or a description, otherwise use just the title
                    $link = ($totalPages || $lesson->description) ? '<a href="' . $url . '">' . htmlspecialchars($lesson->title) . '</a>' : htmlspecialchars($lesson->title);

                    $lessonOutput .= '<div class="mb-1">';
                    // Check if the lesson is restricted (i.e. user hasn't completed previous lesson)
                    if ($restrict) {
                      // Display a lock icon, bold title, and restriction message for inaccessible lessons
                        $lessonOutput .= '<i class="' . $lockIcon . '"></i> ';
                        $lessonOutput .= '<strong>' . $lesson->title . '</strong>';
                        $lessonOutput .= '<br><small>' . $restrict . '</small>';
                    } else {
                        // Get completion status if user is logged in, null if not
                        $completion = $user->id ? CompletionHelper::get_completion($user->id, $lesson->id) : null;
                        
                        // Choose icon based on completion status
                        $lessonIcon = $completion ? $completeIcon : $incompleteIcon;
                        
                        // Display completion icon and linked title for accessible lessons
                        $lessonOutput .= '<i class="' . $lessonIcon . '"></i> ';
                        $lessonOutput .= '<strong>' . ($params->get('path_show_ref', 0) && $lesson->ref ? $lesson->ref . '. ' : '') . $link . '</strong>';
                    }
                    $lessonOutput .= '</div>';
                }

                $tabsContent[] = [$moduleTitle, $lessonOutput];
            }

            $layout = $params->get('path_layout', 'block');
            switch ($layout) {
                case 'accordion':
                    $display = new Accordion($tabsContent, ['first_open' => 0]);  //Sections closed by default
                    break;
                case 'tabs':
                    $display = new Tabs($tabsContent, ['type' => 'tabs']);
                    break;
                case 'block':
                default:
                    $display = new Block($tabsContent, ['show_heading' => 1]);  //All headings visible
                    break;
            }
            echo $display->display(); // Render and output the layout
            ?>
        <?php endif; ?>
    <?php endif; ?>
</div>