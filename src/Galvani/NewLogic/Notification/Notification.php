<?php
namespace Galvani\NewLogic\Notification;

use Galvani\NewLogic\Config\Configuration;
use Galvani\NewLogic\Logger\Logger;

/**
 * Base Notification
 * @package Galvani\NewLogic\Notification
 * @author jan kozak <jan@galvani.cz>
 */
abstract class Notification {
	/**
	 * @param Configuration $configuration
	 * @param Logger $logger
	 */
	public function __construct(Configuration $configuration, Logger $logger) {
		$this->configuration = $configuration;
		$this->logger = $logger;
	}

	/**
	 * Send the notification to the provider
	 *
	 * @param $message
	 * @param null $recipient
	 * @return mixed
	 */
	abstract public function notify($message, $recipient = null);

	/**
	 * Returns recicipent's array
	 *
	 * @return array|null
	 */
	protected function getRecipients() {
		return $this->configuration->get('app.notification.'.$this->getAlias().'.recipients');
	}

	/**
	 * Each provider must provide an unique alias
	 *
	 * @return string
	 */
	abstract public function getAlias();
}