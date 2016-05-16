<?php  namespace CloseIo\Types\Contact;

use CloseIo\Exception\InvalidArgumentException;

class ContactUrl extends ContactMethod
{
	function __construct($url)
	{
		$filtered = filter_var($url, FILTER_VALIDATE_URL);
		if ($filtered === false)
		{
			throw new InvalidArgumentException("Invalid url [{$url}]");
		}

		parent::__construct($url, 'url');
	}

	public function getUrl()
	{
		return $this->getDetail();
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'url' => $this->getUrl(),
			'type' => $this->getType(),
		];
	}
}