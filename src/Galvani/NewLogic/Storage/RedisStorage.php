<?php

namespace Galvani\NewLogic\Storage;

use Galvani\NewLogic\Config\Configuration;
use Galvani\NewLogic\Storage\StorageInterface;

class RedisStorage implements StorageInterface {
	private $redis;
	private $config;

	public function __construct(Configuration $config, \Redis $redisInstance) {
		$this->redis = $redisInstance;
		$this->config = $config;
		$this->redis->connect($this->config->get('app.redis.host'));
		$this->redis->setOption($redisInstance::OPT_PREFIX, $this->config->get('app.redis.prefix'));
	}

	public function get($key) {
		return $this->redis->get($key);
	}

	public function set($key, $value, $ttl=null) {
		return $this->redis->set($key,$value, $ttl);
	}

	public function expire($key, $ttl=null) {
		return $this->redis->expire($key, $ttl);
	}

	public function remove($key) {
		return $this->redis->delete($key);
	}

	public function exists($key) {
		return $this->redis->exists($key);
	}

}