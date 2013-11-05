<?php

namespace Galvani\NewLogic\Snapshoter;

use Galvani\NewLogic\Config\Configuration;
use Knp\Snappy\Pdf;

class Snapshoter {
	/**
	 * @var \Knp\Snappy\Pdf
	 */
	private $processor;
	/**
	 * @var \Galvani\NewLogic\Config\Configuration
	 */
	private $configuration;

	public function __construct(Pdf $pdf, Configuration $configuration) {
		$this->configuration = $configuration;
		$this->processor = $pdf;

		if (substr($binary = $configuration->get('app.wkhtmltopdf.binary'),0,1)!=='/') {
			$binary = APP_DIR . '/' . $binary;
		}

		$this->processor->setBinary($binary);
	}

	public function saveSnapshot($destination) {
		return $this->processor->generate($this->configuration->get('app.newLogicUrl'),$destination, array(), true);
	}


}