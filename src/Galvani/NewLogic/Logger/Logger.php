<?php
namespace Galvani\NewLogic\Logger;
use Galvani\NewLogic\Config\Configuration;

/**
 * Class Logger
 *
 * Internal file logger
 *
 * @package Galvani\NewLogic\Logger
 * @author jan kozak <jan@galvani.cz>
 */
class Logger extends \Monolog\Logger {
	/**
	 * @param Configuration $configuration
	 */
	public function __construct(Configuration $configuration) {
		parent::__construct('new-logic');

		$logFile = $configuration->get('app.log.filename');

		$this->pushHandler(new \Monolog\Handler\StreamHandler(APP_DIR.'/'.$logFile, $configuration->get('app.log.verbosity')));
	}
}


