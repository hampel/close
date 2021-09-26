<?php  namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;

class ContactPhone extends AbstractContactMethod
{
    /**
     * ContactPhone constructor.
     *
     * @param string $phone
     * @param string $type
     */
	public function __construct($phone, $type = "office")
	{
	    $this->setPhone($phone);
	    $this->setType($type);
	}

    /**
     * @return string
     */
	public function getPhone()
	{
		return $this->getDetail();
	}

    /**
     * @param string $phone
     *
     * @throws InvalidArgumentException
     */
	public function setPhone($phone)
    {
        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

        if (empty($phone))
        {
            throw new InvalidArgumentException("phone number is required");
        }

        $this->setDetail($phone);
    }

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'phone' => $this->getPhone(),
			'type' => $this->getType(),
		];
	}
}
