<?php

namespace Galvani\NewLogic\Notification;

use Galvani\NewLogic\Notification\Notification as BaseNotification;

class ConsoleNotification extends BaseNotification {
	public function __construct() {}

	public function notify($message, $recipient = null) {
		print $message."\n";

		return true;
	}

	public function getAlias() { return 'console-notification'; }
}