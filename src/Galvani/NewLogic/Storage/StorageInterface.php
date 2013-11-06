<?php
namespace Galvani\NewLogic\Storage;

/**
 * Interface StorageInterface
 *
 * @package Galvani\NewLogic\Storage
 * @author jan kozak <galvani.cz>
 */
interface StorageInterface {
	/**
	 * returns value specified by key
	 *
	 * @param string $key
	 * @return mixed|null
	 */
	public function get($key);

	/**
	 * sets value by given key and ttl (time to live)
	 *
	 * @param string $key
	 * @param mixed $value
	 * @param null|integer $ttl
	 * @return mixed
	 */
	public function set($key, $value, $ttl=null);

	/**
	 * sets new expiry for element
	 *
	 * @param string $key
	 * @param null|integer $ttl
	 * @return mixed
	 */
	public function expire($key, $ttl=null);

	/**
	 * deletes given key
	 *
	 * @param $key
	 * @return mixed
	 */
	public function remove($key);

	/**
	 * teste whether value specified by given key is available
	 *
	 * @param $key
	 * @return mixed
	 */
	public function exists($key);
}