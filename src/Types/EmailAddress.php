<?php namespace Close\Types;

use Close\Exception\InvalidArgumentException;

class EmailAddress
{
	private $email;

	private $name;

	function __construct($email, $name = '')
	{
		if (preg_match('/^(?:(.*?)\s<?)?([A-Z0-9._%+-]+@[A-Z0-9.-]+)>?$/im', $email, $matches)) {
			$name = $matches[1] ? $matches[1] : $name;
			$email = $matches[2];
		} else {
			throw new InvalidArgumentException("Invalid email address [{$email}]");
		}

		$filtered = filter_var($email, FILTER_VALIDATE_EMAIL);
		if ($filtered === false)
		{
			throw new InvalidArgumentException("Invalid email address [{$email}]");
		}

		$this->email = $email;
		$this->name = $name;
	}

	public static function createEmailAddress($email, $name = '')
	{
		return new self($email, $name);
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getFull()
	{
		$name = $this->getName();
		$email = $this->getEmail();

		return empty($name) ? $email : "{$name} <{$email}>";
	}
}
