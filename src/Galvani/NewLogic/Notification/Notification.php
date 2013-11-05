<?php
namespace Galvani\NewLogic\Notification;

use Galvani\NewLogic\Config\Configuration;
use Galvani\NewLogic\Logger\Logger;

abstract class Notification {
	public function __construct(Configuration $configuration, Logger $logger) {
		$this->configuration = $configuration;
		$this->logger = $logger;
	}
	abstract public function notify($message, $recipient = null);

	protected function getRecipients() {
		return $this->configuration->get('app.notification.'.$this->getAlias().'.recipients');
	}
	abstract public function getAlias();
}