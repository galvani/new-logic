<?php

namespace Galvani\NewLogic\Config;

/**
 * Class Configuration
 *
 * Configuration instance gives access to config values
 *
 * @package Galvani\NewLogic\Config
 * @author jan kozak <jan@galvani.cz>
 */
class Configuration  {
	/**
	 * Config loader
	 */
	protected $configLoader;

	/**
	 * @param $configLoader
	 */
	public function __construct($configLoader) {
		$this->configValues = $configLoader->getConfigurationArray();
	}

	/**
	 * return given value at the configuration values
	 *
	 * @param string
	 * @return null|mixed
	 */
	public function get($path) {
		$traversable = $this->configValues;

		foreach (explode('.',$path) as $segment) {
			if (!isset($traversable[$segment])) return null;
			$traversable = $traversable[$segment];
		}

		return $traversable;
	}
}