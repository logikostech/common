<?php
namespace Logikos;

/**
 * This is a php version of \Phalcon\Registry
 * NOTICE: \Phalcon\Registry will be much faster than this class and you are encouraged to use it
 * 
 *<code>
 * 	$registry = new \Phalcon\Registry();
 *
 * 	// Set value
 * 	$registry->something = 'something';
 * 	// or
 * 	$registry['something'] = 'something';
 *
 * 	// Get value
 * 	$value = $registry->something;
 * 	// or
 * 	$value = $registry['something'];
 *
 * 	// Check if the key exists
 * 	$exists = isset($registry->something);
 * 	// or
 * 	$exists = isset($registry['something']);
 *
 * 	// Unset
 * 	unset($registry->something);
 * 	// or
 * 	unset($registry['something']);
 *</code>
 */
trait ArrayAccessTrait {

	private $_arrayAccessContainer = [];

	public final function offsetImport(array $array) {
	  foreach($array as $k=>$v)
	    $this->offsetSet($k,$v);
	}
	
	/**
	 * Checks if the element is present in the registry
	 */
	public final function offsetExists($offset)
	{
		return isset($this->_arrayAccessContainer[$offset]);
	}

	/**
	 * Returns an index in the registry
	 */
	public final function offsetGet($offset)
	{
		return $this->_arrayAccessContainer[$offset];
	}

	/**
	 * Sets an element in the registry
	 */
	public final function offsetSet($offset, $value)
	{
		$this->_arrayAccessContainer[$offset] = $value;
	}

	/**
	 * Unsets an element in the registry
	 */
	public final function offsetUnset($offset)
	{
		unset($this->_arrayAccessContainer[$offset]);
	}

	/**
	 * Checks how many elements are in the register
	 */
	public final function count()
	{
		return count($this->_arrayAccessContainer);
	}

	/**
	 * Moves cursor to next row in the registry
	 */
	public final function next()
	{
		next($this->_arrayAccessContainer);
	}

	/**
	 * Gets pointer number of active row in the registry
	 */
	public final function key()
	{
		return key($this->_arrayAccessContainer);
	}

	/**
	 * Rewinds the registry cursor to its beginning
	 */
	public final function rewind()
	{
		reset($this->_arrayAccessContainer);
	}

	/**
	 * Checks if the iterator is valid
	 */
	public function valid()
	{
		return key($this->_arrayAccessContainer) !== null;
	}

	/**
	 * Obtains the current value in the internal iterator
	 */
	public function current()
	{
		return current($this->_arrayAccessContainer);
	}

	/**
	 * Sets an element in the registry
	 */
	public final function __set($key, $value)
	{
		$this->offsetSet($key, $value);
	}

	/**
	 * Returns an index in the registry
	 */
	public final function __get($key)
	{
		return $this->offsetGet($key);
	}

	public final function __isset($key)
	{
		return $this->offsetExists($key);
	}

	public final function __unset($key)
	{
		$this->offsetUnset($key);
	}
}