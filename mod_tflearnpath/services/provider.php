<?php
/*
* @package		TF Learnpath Module
* @license		GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die;

use Joomla\CMS\Extension\Service\Provider\Module as ModuleServiceProvider;
use Joomla\CMS\Extension\Service\Provider\ModuleDispatcherFactory as ModuleDispatcherFactoryServiceProvider;
use Joomla\CMS\Extension\Service\Provider\HelperFactory as HelperFactoryServiceProvider;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->registerServiceProvider(new ModuleDispatcherFactoryServiceProvider('\\TfLearn\\Module\\TfLearnPath'));
        $container->registerServiceProvider(new HelperFactoryServiceProvider('\\TfLearn\\Module\\TfLearnPath\\Site\\Helper'));
        $container->registerServiceProvider(new ModuleServiceProvider());
    }
};