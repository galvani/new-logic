<?php
namespace Galvani\NewLogic\Config;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

/**
 * Class YamlConfigLoader
 *
 * Responsible for loading yml extension files
 *
 * @package Galvani\NewLogic\Config
 * @author jan kozak <jan@galvani.cz>
 */
class YamlConfigLoader extends \Symfony\Component\Config\Loader\FileLoader
{
	/**
	 * @var array
	 */
	protected $configValues;

	/**
	 * @param \Symfony\Component\Config\FileLocatorInterface $resource
	 */
	public function __construct($resource) {
		parent::__construct(new FileLocator(array($resource)));
	}

	/**
	 * @param mixed $resource
	 * @param null $type
	 */
	public function load($resource, $type = null)
	{
		$this->configValues = Yaml::parse(
			$this->getLocator()->locate($resource)
		);
	}

	/**
	 * @return array
	 */
	public function getConfigurationArray() {
		return $this->configValues;
	}

	/**
	 * @inheritdoc
	 */
	public function supports($resource, $type = null)
	{
		return is_string($resource) && 'yml' === pathinfo(
			$resource,
			PATHINFO_EXTENSION
		);
	}
}

