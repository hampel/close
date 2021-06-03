<?php namespace Close\Types\Contact;

use Close\Arrayable;
use Close\Exception\UnknownTypeException;

abstract class ContactMethod implements Arrayable
{
	static $types = ['office', 'mobile', 'home', 'direct', 'fax', 'url', 'other'];

	private $detail;

	private $type;

	function __construct($method, $type = "office")
	{
		if (!in_array($type, $this->getTypes()))
		{
			throw new UnknownTypeException("Unknown type [{$type}]");
		}

		$this->detail = $method;
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	protected function getDetail()
	{
		return $this->detail;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return array
	 */
	public static function getTypes()
	{
		return self::$types;
	}

	public function equals(ContactMethod $other)
	{
		return (($this->type === $other->type) && ($this->detail === $other->detail));
	}

	abstract public function toArray();
}
