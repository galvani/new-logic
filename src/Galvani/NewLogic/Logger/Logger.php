<?php
namespace Galvani\NewLogic\Logger;

class Logger extends \Monolog\Logger {
	public function __construct($configuration) {
		parent::__construct('new-logic');

		$logFile = $configuration->get('app.log.filename');

		$this->pushHandler(new \Monolog\Handler\StreamHandler(APP_DIR.'/'.$logFile, $configuration->get('app.log.verbosity')));
		$this->addInfo('Log initialized');
	}
}


