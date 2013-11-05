<?php
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require_once dirname(__FILE__).'/../autoload.php';

//  Initiate dependency injection
$sc = new ContainerBuilder();
$loader = new YamlFileLoader($sc, new FileLocator(__DIR__));
$loader->load(APP_DIR.'/app/etc/services.yml');

$sc->get('application')->run();



