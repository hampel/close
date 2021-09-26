<?php  namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;

class ContactUrl extends AbstractContactMethod
{
    /**
     * ContactUrl constructor.
     *
     * @param string $url
     */
	public function __construct($url)
	{
        $this->setUrl($url);
        $this->setType('url');
	}

    /**
     * @return string
     */
	public function getUrl()
	{
		return $this->getDetail();
	}

    /**
     * @param string $url
     *
     * @throws InvalidArgumentException
     */
	public function setUrl($url)
    {
        $filtered = filter_var($url, FILTER_VALIDATE_URL);
        if ($filtered === false)
        {
            throw new InvalidArgumentException("Invalid url [{$url}]");
        }

        $this->setDetail($url);
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
