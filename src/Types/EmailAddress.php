<?php namespace Close\Types;

use Close\Exception\InvalidArgumentException;

class EmailAddress
{
    /** @var string  */
	private $email;

	/** @var string  */
	private $name;

    /**
     * EmailAddress constructor.
     *
     * @param string $email
     * @param string $name
     */
	function __construct($email, $name = '')
	{
        if (empty($email))
        {
            throw new InvalidArgumentException("email is required");
        }

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

    /**
     * @param string $email
     * @param string $name
     *
     * @return EmailAddress
     */
	public static function createEmailAddress($email, $name = '')
	{
		return new self($email, $name);
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

    /**
     * @return string
     */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @return string
     */
	public function getFull()
	{
		$name = $this->getName();
		$email = $this->getEmail();

		return empty($name) ? $email : "{$name} <{$email}>";
	}

    /**
     * @param EmailAddress $email
     *
     * @return string
     */
    public static function fullEmail(EmailAddress $email)
    {
        return $email->getFull();
    }
}
