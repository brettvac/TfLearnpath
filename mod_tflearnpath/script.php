<?php
/*
* @package		TF Learnpath Module
* @license		GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\LibraryHelper;
use Joomla\CMS\Installer\InstallerScriptInterface;
use TechFry\Library\TfInstall;
use Joomla\CMS\Language\Text;

return new class () implements InstallerScriptInterface
{
  
    public function install(InstallerAdapter $adapter): bool {
        echo Text::_('MOD_TFLEARNPATH_INSTALL') . "<br>";
        return true;
    }

    public function update(InstallerAdapter $adapter): bool{
        echo Text::_('MOD_TFLEARNPATH_UPDATE') . "<br>";
        return true;
    }

    public function uninstall(InstallerAdapter $adapter): bool {
        echo Text::_('MOD_TFLEARNPATH_UNINSTALL') . "<br>";
        return true;
    }
    
    public function preflight(string $type, InstallerAdapter $adapter): bool
    {
        if (!LibraryHelper::isEnabled('techfry')) {
            $message = '<strong><p>Please download and install TF Library before installing ' . $adapter->element . '</p></strong>';
            $message .= '<a class="btn btn-success" href="https://labs.joomlafry.com/downloads/techfry.zip" download>';
            $message .= '<i class="fas fa-download"></i> Download TF Library!</a>';
            Factory::getApplication()->enqueueMessage($message);
            return false;
        }

        if ($type == 'update') {
            if (class_exists('TfInstall') && method_exists('TfInstall', 'remove_module_files')) {
                TfInstall::remove_module_files($adapter->element);
            }
        }

        return true;
    }

    public function postflight(string $type, InstallerAdapter $adapter): bool
    {
        TfInstall::install_languages($adapter->element);

        if ($type == 'install') {
            $adapter->parent->message = '';
        }

        if ($type == 'update') {
            TfInstall::remove_duplicate_update_sites($adapter->element);
        }
        
        return true;
    }
};