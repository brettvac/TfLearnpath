# TF Learnpath Module for Joomla

![TF Learnpath logo](Tf-Learnpath.jpg)

The **TF Learnpath** module (`mod_tflearnpath`) is a Joomla module designed to display a structured learning path for courses managed by the **TF Learn** component (`com_tflearn`). It provides a visual representation of course modules and lessons, with support for multiple layouts (block, accordion, or tabs) and user access restrictions. Perfect for e-learning websites, this module helps users navigate their learning journey with ease.

## Features

- **Dynamic Learning Path Display:** Shows course modules and lessons in a clean, organized format.
- **Multiple Layout Options:** Choose between block, accordion, or tabs layouts to match your site’s design.
- **Access Control:** Integrates with `com_tflearn` to check user enrollment, displaying restricted lessons with lock icons.
- **Customizable Styling:** Add custom CSS classes for the module title and icons for completed/incomplete lessons.
- **Lightweight and Efficient:** Built to work seamlessly with `com_tflearn`, with minimal overhead.

## Requirements

- **Joomla Version:** Joomla 4.x or 5.x (for the most recent version of TF Learn)
- **TF Learn Component:** You should have already installed [TF Learn](https://joomlafry.com/joomla-extensions/learn-joomla-extension) and added some courses, modules and lessons.
- **TF Library:** Requires the [Tech Fry Library](https://labs.joomlafry.com/downloads/techfry.zip) to work.
- **PHP Version:** PHP 7.4 or higher.

## Installation

1. **Download or install the Module with this URL**
   - Install via Joomla’s Extension Manager (`Extensions > Manage > Install`) the latest release [from this link](https://github.com/brettvac/TFLearnpath/releases/download/1.0/tflearnpath.zip).
   - The module will check for the TechFry Library during installation and prompt you if it’s missing.

2. **Enable the Module:**
   - Go to `Extensions > Modules`.
   - Search for "TF Learnpath" and click to edit.
   - Set the status to "Published" and assign it to the desired position and menu items.

## Module Parameters

- **Course ID (`course_id`):** Specify the ID of the `com_tflearn` course to display (e.g., `2`). Required.
- **Layout (`path_layout`):** Choose the display style:
  - `block`: Simple stacked layout.
  - `accordion`: Collapsible sections (defaults to all closed).
  - `tabs`: Tabbed navigation.
- **Lesson Order (`lessons_order_col`, `lessons_order_dirn`):** Sort lessons by a field (e.g., `ordering`, `title`) in ascending (`ASC`) or descending (`DESC`) order.
- **Module Title Class (`module_title_class`):** Add a CSS class for the course title (e.g., `text-center`).
- **Icons (`path_incomplete_icon`, `path_complete_icon`, `path_lock_icon`):** Customize Font Awesome icons for lesson states (e.g., `fa-regular fa-square` for incomplete).

### Example Setup
1. Create a course in `com_tflearn` with modules and lessons.
2. In the module settings:
   - Set `Course ID` to your course’s ID.
   - Choose `accordion` layout.
   - Assign the module to a position (e.g., `sidebar-right`) and a menu item.
3. Save and view the frontend—your learning path will display with collapsible sections.

## Usage

- **Frontend Display:** The module shows the course title, followed by sections (modules) and their lessons. Lessons are linked to their respective pages in `com_tflearn` if accessible.
- **Access Restrictions:** If a user isn’t enrolled, restricted lessons show a lock icon and message.
- **Customization:** Add custom CSS to style the `.tflearn-path` container, icons, or layout elements.

## File Structure
