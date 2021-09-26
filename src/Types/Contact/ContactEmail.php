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
	public function __construct(EmailAddress $email, $type = "office")
	{
		$this->setEmail($email);
		$this->setType($type);
	}

    /**
     * @return EmailAddress
     */
	public function getEmail()
	{
		return $this->getDetail();
	}

    /**
     * @param EmailAddress $email
     */
    public function setEmail(EmailAddress $email)
    {
        $this->setDetail($email->getEmail());
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
