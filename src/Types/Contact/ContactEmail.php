<?php  namespace Close\Types\Contact;

use Close\Types\EmailAddress;

class ContactEmail extends AbstractContactMethod
{
    /**
     * ContactEmail constructor.
     *
     * @param EmailAddress $email
     * @param string $type
     */
	public function __construct(EmailAddress $email, string $type = "office")
	{
		$this->setEmail($email);
		$this->setType($type);
	}

    /**
     * @return string
     */
	public function getEmail() : string
	{
		return $this->getDetail();
	}

    /**
     * @param EmailAddress $email
     */
    public function setEmail(EmailAddress $email) : void
    {
        $this->setDetail($email->getEmail());
    }

	/**
	 * @return array
	 */
	public function toArray() : array
	{
		return [
			'email' => $this->getEmail(),
			'type' => $this->getType(),
		];
	}
}
