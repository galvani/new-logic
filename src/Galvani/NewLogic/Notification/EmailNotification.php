<?php

namespace Galvani\NewLogic\Notification;

use Galvani\NewLogic\Config\Configuration;
use Galvani\NewLogic\Logger\Logger;
use Galvani\NewLogic\Notification\Notification as BaseNotification;
use Galvani\NewLogic\Snapshoter\Snapshoter;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Class EmailNotification
 *
 * provides notification to email target, creates and attaches snapshot of the tested page
 *
 * @package Galvani\NewLogic\Notification
 * @author jan kozak <jan@galvani.cz>
 */
class EmailNotification extends BaseNotification
{
	/**
	 * @var null|mixed
	 */
	private $attachments;

	/**
	 * @param Configuration $configuration
	 * @param Logger $logger
	 * @param Snapshoter $snapshoter
	 */
	public function __construct(Configuration $configuration, Logger $logger, Snapshoter $snapshoter)
	{
		$this->snapshoter = $snapshoter;
		parent::__construct($configuration, $logger);
	}

	/**
	 * @param $message
	 * @param null $recipient
	 * @return bool|mixed
	 */
	public function notify($message, $recipient = null)
	{
		$this->logger->addDebug('Generating screenshot file');
		$this->snapshoter->saveSnapshot('/tmp/snapshot.pdf');

		$recipients = is_null($recipient) ? $this->getRecipients($recipient) : array($recipient);
		$this->logger->addDebug('Sending email to '.join(', ',$recipients));

		// Create the Transport Mail
		$transport = \Swift_MailTransport::newInstance();

		// Create the Mailer using your created Transport
		$mailer = \Swift_Mailer::newInstance($transport);

		//  Create the message
		$message = \Swift_Message::newInstance()
			->setSubject($this->configuration->get('app.notification.email-notification.parameters.subject'))
			->setFrom($this->configuration->get('app.notification.email-notification.parameters.sender'))
			->setTo($recipients)
			->setBody($message)
            ->addPart('<q>'.$message.'</q>', 'text/html')
            ->attach(\Swift_Attachment::fromPath('/tmp/snapshot.pdf'));

		// Send the message
		$result = $mailer->send($message);

		return true;
	}

	/**
	 * Return the recipients for our message
	 *
	 * @param array|null $recipients
	 * @return array|null
	 * @throws \Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException
	 */
	protected function getRecipients($recipients = null)
	{
		$recipients = is_null($recipients) ? parent::getRecipients() : $recipients;

		if (is_null($recipients)) {
			throw new ParameterNotFoundException('There are no recipients configured for notification.');
		}

		return $recipients;
	}

	/**
	 * @inheritdoc
	 */
	public function getAlias() { return 'email-notification'; }
}