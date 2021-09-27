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
     * @param string $name lead name
     */
	public function __construct($name)
    {
        $this->setName($name);
    }

    /**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @param string $name lead name
     */
    public function setName($name)
    {
        if (empty($name))
        {
            throw new InvalidArgumentException("name is required");
        }

        $this->name = $name;
    }

    /**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

    /**
     * @param string $url
     *
     * @throws InvalidArgumentException
     */
    public function setUrl($url)
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
	public function getDescription()
	{
		return $this->description;
	}

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    /**
	 * @return string
	 */
	public function getStatusId()
	{
		return $this->status_id;
	}

    /**
     * @param string $status_id
     *
     * @throws InvalidArgumentException
     */
    public function setStatusId($status_id)
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
	public function getContacts()
	{
		return $this->contacts;
	}

    /**
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
	 * @return array
	 */
	public function getCustomFields()
	{
		return $this->customFields;
	}

    public function setCustomField($field_id, $value)
    {
        $id = $this->stripCustomPrefix($field_id);

        $this->customFields[$id] = $value;
    }

    /**
	 * @return array
	 */
	public function getAddresses()
	{
		return $this->addresses;
	}

    /**
     * @param LeadAddress $address
     */
    public function addAddress(LeadAddress $address)
    {
        $this->addresses[] = $address;
    }

    public function toArray()
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
