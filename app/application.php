<?php
/**
 * @author jan kozak <galvani78@gmail.com>
 */

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

//  autoload
require_once dirname(__FILE__).'/../autoload.php';

//  Initiate dependency injection
$sc = new ContainerBuilder();
$loader = new YamlFileLoader($sc, new FileLocator(__DIR__));
$loader->load(APP_DIR.'/app/etc/services.yml');

//  run the application
$sc->get('application')->run();



