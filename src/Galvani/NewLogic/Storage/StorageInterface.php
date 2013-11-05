<?php
namespace Galvani\NewLogic\Storage;

interface StorageInterface {
	public function get($key);
	public function set($key, $value, $ttl=null);
	public function expire($key, $ttl=null);
	public function remove($key);
	public function exists($key);
}