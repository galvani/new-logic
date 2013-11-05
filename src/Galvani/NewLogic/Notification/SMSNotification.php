<?php

namespace Galvani\NewLogic\Notification;

use Galvani\NewLogic\Notification\Notification as BaseNotification;
use Knp\Snappy\Image;
use mjohnson\utility\TypeConverter;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

class SMSNotification extends BaseNotification {
	public function notify($message, $recipient = null) {
		$messageStructure = array(
			'recipients'    => $this->getRecipients($recipient),
			'message'       => $message,
			'username'      => $this->configuration->get('app.notification.sms-notification.credentials.username'),
			'password'      => $this->configuration->get('app.notification.sms-notification.credentials.password')
		);

		$xml = TypeConverter::toXml($messageStructure);

		$message = "The message would have been sent, but there is no gateway configured\n";
		$this->logger->addAlert($message);
		$this->logger->addDebug($xml);

		return true;
	}

	protected function getRecipients($recipients = null) {
		if (is_null($recipients)) {
			$recipients = parent::getRecipients();
		}

		if (is_null($recipients)) {
			throw new ParameterNotFoundException('There are no recipients configured for notification.');
		}

		return $recipients;
	}

	public function getAlias() { return 'sms-notification'; }
}