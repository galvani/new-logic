<?php

namespace Galvani\NewLogic\Notification;

use Galvani\NewLogic\Notification\Notification as BaseNotification;

/**
 * Class ConsoleNotification
 *
 * Outputs notifications into console
 *
 * @package Galvani\NewLogic\Notification
 */
class ConsoleNotification extends BaseNotification {
	/**
	 * We don't need no arguments
	 */
	public function __construct() {}

	/**
	 * @param $message
	 * @param null $recipient
	 * @return bool
	 */
	public function notify($message, $recipient = null) {
		print $message."\n";

		return true;
	}

	public function getAlias() { return 'console-notification'; }
}