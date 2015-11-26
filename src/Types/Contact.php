<?php namespace CloseIo\Types;

use CloseIo\Arrayable;
use CloseIo\ArrayableArray;
use CloseIo\Exception\InvalidArgumentException;

class Contact implements Arrayable
{
	use ArrayableArray;

	private $lead_id;

	private $name;

	private $title;

	/** @var array Phone */
	private $phones = [];

	/** @var array Email */
	private $emails = [];

	/** @var array Url */
	private $urls = [];

	function __construct($lead_id, $name, $title, array $phones, array $emails, array $urls)
	{
		foreach ($phones as $phone)
		{
			if (!is_object($phone) OR get_class($phone) != Phone::class)
			{
				throw new InvalidArgumentException("Invalid Phone object passed to Contact constructor: " . gettype($phone));
			}
		}

		foreach ($emails as $email)
		{
			if (!is_object($email) OR get_class($email) != Email::class)
			{
				throw new InvalidArgumentException("Invalid Email object passed to Contact constructor: " . gettype($email));
			}
		}

		foreach ($urls as $url)
		{
			if (!is_object($url) OR get_class($url) != Url::class)
			{
				throw new InvalidArgumentException("Invalid Url object passed to Contact constructor: " . gettype($url));
			}
		}

		$this->lead_id = $lead_id;
		$this->name = $name;
		$this->title = $title;
		$this->phones = $phones;
		$this->emails = $emails;
		$this->urls = $urls;
	}

	/**
	 * @return mixed
	 */
	public function getLeadId()
	{
		return $this->lead_id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return array
	 */
	public function getPhones()
	{
		return $this->phones;
	}

	/**
	 * @return array
	 */
	public function getEmails()
	{
		return $this->emails;
	}

	/**
	 * @return array
	 */
	public function getUrls()
	{
		return $this->urls;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		$phones = $this->getPhones();
		$emails = $this->getEmails();
		$urls = $this->getUrls();

		return [
			'lead_id' => $this->getLeadId() ?: null,
			'name' => $this->getName(),
			'title' => $this->getTitle(),
			'phones' => !empty($phones) ? $this->arrayToArray($phones) : null,
			'emails' => !empty($emails) ? $this->arrayToArray($emails) : null,
			'urls' => !empty($urls) ? $this->arrayToArray($urls) : null,
		];
	}
}
