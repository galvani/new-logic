<?php

namespace Galvani\NewLogic;

use Galvani\NewLogic\Config\Configuration;
use Galvani\NewLogic\Exception\HTMLParseException;
use Galvani\NewLogic\Logger\Logger;
use Galvani\NewLogic\Notification\Notification;
use Galvani\NewLogic\Storage\StorageInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GalvaniNewLogic
 *
 * @package Galvani\NewLogic
 * @author jan kozak <jan@galvani.cz>
 */
class GalvaniNewLogic
{
	/**
	 * @var Config\Configuration
	 */
	private $config;
	/**
	 * @var Logger\Logger
	 */
	private $logger;
	/**
	 * @var [Notification\Notification]
	 */
	private $notificationProviders;
	/**
	 * @var Storage\StorageInterface
	 */
	private $storage;

	/**
	 * @param Configuration $config
	 * @param Logger $logger
	 * @param $notificationProviders
	 * @param StorageInterface $storage
	 */
	public function __construct(Configuration $config, Logger $logger, $notificationProviders, StorageInterface $storage)
	{
		$this->config = $config;
		$this->logger = $logger;
		$this->notificationProviders = $notificationProviders;
		$this->storage = $storage;
	}

	/**
	 * Runs the application
	 */
	public function run()
	{
		$this->logger->info('application started');
		try {
			$crawler = new Crawler(file_get_contents($this->config->get('app.newLogicUrl')));

			$crawler = $crawler->filter('body div#headPhone');
			if (!preg_match('/[$\+]+(.*)/', trim($crawler->text()), $matches)) {
				throw new HTMLParseException('Cannot get phone number');
			}
			$phoneMatch = array_shift($matches);

			//  Check the last run timestamp
			$lastPhoneNumber = $this->storage->get('last_value');

			$notify = $this->storage->get('last_run') === false || $lastPhoneNumber != $phoneMatch;

			if ($notify) {
				//$this->storage->set('last_value', $phoneMatch);
				$this->logger->addNotice('Phone number modification detected, saving snapshot...');

				foreach ($this->notificationProviders as $notificationProvider) {
					/** @var Notification $notificationProvider */
					$this->logger->addNotice('Sending notification using: ' . $notificationProvider->getAlias());
					$notificationProvider->notify(
					                     sprintf(
						                     'Phone number has changed from %s to %s.',
						                     empty($lastPhoneNumber) ? 'none' : $lastPhoneNumber,
						                     $phoneMatch
					                     ),
						                     null
					);
				}

			} else {

			}

			$this->storage->set('last_run', time());
		} catch (\Exception $e) {
			$this->logger->addError($e->getMessage() . "\n" . $e->getTraceAsString());
		}

	}
}