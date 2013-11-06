<?php

namespace Galvani\NewLogic\Snapshoter;

use Galvani\NewLogic\Config\Configuration;
use Knp\Snappy\Pdf;

/**
 * Class Snapshoter
 *
 * Creates PDF of given location
 *
 * @package Galvani\NewLogic\Snapshoter
 * @author jan kozak <jan@galvani.cz>
 */
class Snapshoter {
	/**
	 * @var \Knp\Snappy\Pdf
	 */
	private $processor;
	/**
	 * @var \Galvani\NewLogic\Config\Configuration
	 */
	private $configuration;

	/**
	 * @param Pdf $pdf
	 * @param Configuration $configuration
	 */
	public function __construct(Pdf $pdf, Configuration $configuration) {
		$this->configuration = $configuration;
		$this->processor = $pdf;

		if (substr($binary = $configuration->get('app.wkhtmltopdf.binary'),0,1)!=='/') {
			$binary = APP_DIR . '/' . $binary;
		}

		$this->processor->setBinary($binary);
	}

	/**
	 * Saves location given by configuration to a file specified by configuration
	 *
	 * @param $destination
	 * @return void
	 */
	public function saveSnapshot($destination) {
		$this->processor->generate($this->configuration->get('app.newLogicUrl'),$destination, array(), true);
	}


}