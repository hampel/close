<?php  namespace CloseIo\Types\Contact;

use CloseIo\Types\EmailAddress;
use CloseIo\Exception\InvalidArgumentException;

class ContactEmail extends ContactMethod
{
	function __construct(EmailAddress $email, $type = "office")
	{
		parent::__construct($email->getEmail(), $type);
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