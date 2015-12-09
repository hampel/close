<?php namespace CloseIo\Types\Lead;

use CloseIo\Arrayable;
use CloseIo\ArrayableArray;
use CloseIo\Types\Contact\Contact;
use CloseIo\Exception\InvalidArgumentException;

class Lead implements Arrayable
{
	use ArrayableArray;

	private $name;

	private $url;

	private $description;

	private $status_id;

	/** @var array Contact */
	private $contacts = [];

	private $custom = [];

	/** @var array Address */
	private $addresses = [];

	function __construct($name, $url, $description, $status_id, array $contacts, array $custom, array $addresses)
	{
		if (!empty($url))
		{
			$filtered = filter_var($url, FILTER_VALIDATE_URL);
			if ($filtered === false)
			{
				throw new InvalidArgumentException("Invalid url [{$url}]");
			}
		}

		if (!empty($status_id) AND substr($status_id, 0, 5 !== 'stat_'))
		{
			throw new InvalidArgumentException("Invalid status_id passed to Lead constructor: [{$status_id}]");
		}

		foreach ($contacts as $contact)
		{
			if (!is_object($contact) OR get_class($contact) != Contact::class)
			{
				throw new InvalidArgumentException("Invalid Contact object passed to Lead constructor: " . gettype($contact));
			}
		}

		foreach ($addresses as $address)
		{
			if (!is_object($address) OR get_class($address) != LeadAddress::class)
			{
				throw new InvalidArgumentException("Invalid Address object passed to Lead constructor: " . gettype($address));
			}
		}

		$this->name = $name;
		$this->url = $url;
		$this->description = $description;
		$this->status_id = $status_id;
		$this->contacts = $contacts;
		$this->custom = $custom;
		$this->addresses = $addresses;
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
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getStatusId()
	{
		return $this->status_id;
	}

	/**
	 * @return array
	 */
	public function getContacts()
	{
		return $this->contacts;
	}

	/**
	 * @return array
	 */
	public function getCustom()
	{
		return $this->custom;
	}

	/**
	 * @return array
	 */
	public function getAddresses()
	{
		return $this->addresses;
	}

	public function toArray()
	{
		$contacts = $this->getContacts();
		$custom = $this->getCustom();
		$addresses = $this->getAddresses();

		return [
			'name' => $this->getName(),
			'url' => $this->getUrl() ?: null,
			'description' => $this->getDescription() ?: null,
			'status_id' => $this->getStatusId() ?: null,
			'contacts' => !empty($contacts) ? $this->arrayToArray($contacts) : null,
			'custom' => !empty($custom) ? $this->getCustom() : null,
			'addresses' => !empty($addresses) ? $this->arrayToArray($this->getAddresses()): null,
		];
	}
}
