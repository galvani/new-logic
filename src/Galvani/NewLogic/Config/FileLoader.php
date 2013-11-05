<?php
namespace Galvani\NewLogic\Config;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class FileLoader extends \Symfony\Component\Config\Loader\FileLoader
{

	protected $configValues;

	public function __construct($resource) {
		parent::__construct(new FileLocator(array($resource)));
	}

	public function load($resource, $type = null)
	{
		$this->configValues = Yaml::parse(
			$this->getLocator()->locate($resource)
		);
	}

	public function getConfigurationArray() {
		return $this->configValues;
	}

	public function supports($resource, $type = null)
	{
		return is_string($resource) && 'yml' === pathinfo(
			$resource,
			PATHINFO_EXTENSION
		);
	}
}

