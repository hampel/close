<?php  namespace CloseIo\Types\Contact;

class ContactPhone extends ContactMethod
{
	function __construct($phone, $type = "office")
	{
		$phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

		parent::__construct($phone, $type);
	}

	public function getPhone()
	{
		return $this->getDetail();
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
