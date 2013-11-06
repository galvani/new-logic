<?php

namespace Galvani\NewLogic\Storage;

use Galvani\NewLogic\Config\Configuration;
use Galvani\NewLogic\Storage\StorageInterface;

/**
 * Class RedisStorage
 *
 * Stores and retrieves values in/from redis database
 *
 * @package Galvani\NewLogic\Storage
 * @author jan kozak <jan@galvani.cz>
 */
class RedisStorage implements StorageInterface {
	private $redis;
	private $config;

	/**
	 * @param Configuration $config
	 * @param \Redis $redisInstance
	 */
	public function __construct(Configuration $config, \Redis $redisInstance) {
		$this->redis = $redisInstance;
		$this->config = $config;
		$this->redis->connect($this->config->get('app.redis.host'));
		$this->redis->setOption($redisInstance::OPT_PREFIX, $this->config->get('app.redis.prefix'));
	}

	/**
	 * @inheritdoc
	 */
	public function get($key) {
		return $this->redis->get($key);
	}

	/**
	 * @inheritdoc
	 */
	public function set($key, $value, $ttl=null) {
		return $this->redis->set($key,$value, $ttl);
	}

	/**
	 * @inheritdoc
	 */
	public function expire($key, $ttl=null) {
		return $this->redis->expire($key, $ttl);
	}

	/**
	 * @inheritdoc
	 */
	public function remove($key) {
		return $this->redis->delete($key);
	}

	/**
	 * @inheritdoc
	 */
	public function exists($key) {
		return $this->redis->exists($key);
	}

}