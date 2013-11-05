<?php

namespace Galvani\NewLogic\Config;

class Configuration  {
	protected $configLoader;

	public function __construct($configLoader) {
		$this->configValues = $configLoader->getConfigurationArray();
	}

	public function get($path) {
		$traversable = $this->configValues;

		foreach (explode('.',$path) as $segment) {
			if (!isset($traversable[$segment])) return null;
			$traversable = $traversable[$segment];
		}

		return $traversable;
	}
}