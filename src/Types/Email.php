<?php  namespace CloseIo\Types; 

use CloseIo\Exception\InvalidArgumentException;

class Email extends ContactMethod
{
	function __construct($email, $type = "office")
	{
		$filtered = filter_var($email, FILTER_VALIDATE_EMAIL);
		if ($filtered === false)
		{
			throw new InvalidArgumentException("Invalid email address [{$email}]");
		}

		parent::__construct($email, $type);
	}

	public function getEmail()
	{
		return $this->getDetail();
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'email' => $this->getEmail(),
			'type' => $this->getType(),
		];
	}
}
