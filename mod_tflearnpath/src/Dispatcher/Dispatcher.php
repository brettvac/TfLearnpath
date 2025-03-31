<?php
/*
* @package		TFLearn Dashboard Module
* @license		GNU General Public License version 2 or later; see LICENSE.txt
*/
namespace TfLearn\Module\TfLearnPath\Site\Dispatcher;

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\DispatcherInterface;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\Input\Input;
use Joomla\Registry\Registry;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;
use TfLearn\Module\TfLearnPath\Site\Helper\TfLearnPathHelper;

class Dispatcher implements DispatcherInterface, HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    protected $module;

    protected $app;

    protected $input;

    public function __construct(\stdClass $module, CMSApplicationInterface $app, Input $input)
    {
        $this->module = $module;
        $this->app = $app;
        $this->input = $input;
    }

    public function dispatch()
    {       
        // Load com_tflearn site language
        Factory::getLanguage()->load('com_tflearn', JPATH_SITE);
        // Load com_tflearn admin language
        Factory::getLanguage()->load('com_tflearn', JPATH_ADMINISTRATOR);

        // Get module params
        $params = new Registry($this->module->params);
        $courseId = (int) $params->get('course_id', 0);
        
        //Get user id
        $user = Factory::getApplication()->getIdentity();

        // Fetch path data using helper
        if ($courseId) {
            $path = $this->getHelperFactory()->getHelper('TfLearnPathHelper')->getCoursePath($courseId, $params);
            $course_id = $courseId;
        } else {
            $path = null;
            $this->app->enqueueMessage(Text::_('COM_TFLEARN_NO_COURSE'));
        }

        // Render the layout
        require ModuleHelper::getLayoutPath('mod_tflearnpath');
    }
}