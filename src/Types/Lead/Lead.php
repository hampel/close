<?php namespace Close\Types\Lead;

use Close\Arrayable;
use Close\ArrayableArray;
use Close\Types\AbstractType;
use Close\Types\Contact\Contact;
use Close\Exception\InvalidArgumentException;

class Lead extends AbstractType implements Arrayable
{
	use ArrayableArray;

	/** @var string */
	private $name;

	/** @var string */
	private $url;

	/** @var string */
    private $description;

    /** @var string */
    private $status_id;

    /** @var Contact[] */
	private $contacts = [];

	/** @var array */
    private $customFields = [];

    /** @var LeadAddress[] */
	private $addresses = [];

    /**
     * Lead constructor.
     *
     * @param string|null $name lead name (optional)
     */
	public function __construct(?string $name = null)
    {
        if ($name)
        {
            $this->setName($name);
        }
    }

    /**
	 * @return string
	 */
	public function getName() : ?string
	{
		return $this->name;
	}

    /**
     * @param string $name lead name
     */
    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    /**
	 * @return string
	 */
	public function getUrl() : ?string
	{
		return $this->url;
	}

    /**
     * @param string $url
     *
     * @throws InvalidArgumentException
     */
    public function setUrl(string $url) : void
    {
        if (!empty($url))
        {
            $filtered = filter_var($url, FILTER_VALIDATE_URL);
            if ($filtered === false)
            {
                throw new InvalidArgumentException("Invalid url [{$url}]");
            }
        }

        $this->url = $url;
    }

    /**
	 * @return string
	 */
	public function getDescription() : ?string
	{
		return $this->description;
	}

    /**
     * @param string $description
     */
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }


    /**
	 * @return string
	 */
	public function getStatusId() : ?string
	{
		return $this->status_id;
	}

    /**
     * @param string $status_id
     *
     * @throws InvalidArgumentException
     */
    public function setStatusId(string $status_id) : void
    {
        if (!empty($status_id) AND substr($status_id, 0, 5) !== 'stat_')
        {
            throw new InvalidArgumentException("Invalid status_id [{$status_id}]");
        }

        $this->status_id = $status_id;
    }

    /**
	 * @return array
	 */
	public function getContacts() : array
	{
		return $this->contacts;
	}

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact) : void
    {
        $this->contacts[] = $contact;
    }

    /**
	 * @return array
	 */
	public function getCustomFields() : array
	{
		return $this->customFields;
	}

    public function setCustomField(string $field_id, string $value) : void
    {
        $id = $this->stripCustomPrefix($field_id);

        $this->customFields[$id] = $value;
    }

    /**
	 * @return array
	 */
	public function getAddresses() : array
	{
		return $this->addresses;
	}

    /**
     * @param LeadAddress $address
     */
    public function addAddress(LeadAddress $address) : void
    {
        $this->addresses[] = $address;
    }

    /**
     * @return array
     */
    public function toArray() : array
	{
		$contacts = $this->getContacts();
		$addresses = $this->getAddresses();

		$lead = [
			'name' => $this->getName(),
			'url' => $this->getUrl(),
			'description' => $this->getDescription(),
			'status_id' => $this->getStatusId(),
			'contacts' => !empty($contacts) ? $this->arrayToArray($contacts) : null,
			'addresses' => !empty($addresses) ? $this->arrayToArray($this->getAddresses()): null,
		];

		foreach ($this->getCustomFields() as $field_id => $value)
        {
            $lead["custom.{$field_id}"] = $value;
        }

		return $this->filterNullValues($lead);
	}
}
