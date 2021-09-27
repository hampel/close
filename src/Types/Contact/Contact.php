<?php namespace Close\Types\Contact;

use Close\Arrayable;
use Close\ArrayableArray;
use Close\Exception\InvalidArgumentException;
use Close\Types\AbstractType;

class Contact extends AbstractType implements Arrayable
{
	use ArrayableArray;

	/** @var string */
	private $lead_id;

	/** @var string */
	private $name;

	/** @var string */
	private $title;

	/** @var ContactPhone[] */
	private $phones = [];

	/** @var ContactEmail */
	private $emails = [];

	/** @var ContactUrl */
	private $urls = [];

    /** @var array */
    private $customFields = [];

    /**
     * Contact constructor.
     *
     * @param string $lead_id
     * @param string $name
     */
	public function __construct($name, $lead_id = null)
	{
		$this->setName($name);
		if ($lead_id)
        {
            $this->setLeadId($lead_id);
        }
	}

	/**
	 * @return string
	 */
	public function getLeadId()
	{
		return $this->lead_id;
	}

    /**
     * @param string $lead_id
     *
     * @throws InvalidArgumentException
     */
    public function setLeadId($lead_id)
    {
        if (substr($lead_id, 0, 5) !== 'lead_')
        {
            throw new InvalidArgumentException("Invalid lead_id [{$lead_id}]");
        }

        $this->lead_id = $lead_id;
    }

    /**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
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
	public function getTitle()
	{
		return $this->title;
	}

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
	 * @return ContactPhone[]
	 */
	public function getPhones()
	{
		return $this->phones;
	}

    /**
     * @param ContactPhone $phone
     */
    public function addPhone(ContactPhone $phone)
    {
        $this->phones[] = $phone;
    }

    /**
	 * @return ContactEmail[]
	 */
	public function getEmails()
	{
		return $this->emails;
	}

    /**
     * @param ContactEmail $email
     */
    public function addEmail(ContactEmail $email)
    {
        $this->emails[] = $email;
    }

    /**
	 * @return ContactUrl[]
	 */
	public function getUrls()
	{
		return $this->urls;
	}

    /**
     * @param ContactUrl $url
     */
    public function addUrl(ContactUrl $url)
    {
        $this->urls[] = $url;
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
	public function toArray()
	{
		$phones = $this->getPhones();
		$emails = $this->getEmails();
		$urls = $this->getUrls();

		$contact = [
			'lead_id' => $this->getLeadId(),
			'name' => $this->getName(),
			'title' => $this->getTitle(),
			'phones' => !empty($phones) ? $this->arrayToArray($phones) : null,
			'emails' => !empty($emails) ? $this->arrayToArray($emails) : null,
			'urls' => !empty($urls) ? $this->arrayToArray($urls) : null,
		];

        foreach ($this->getCustomFields() as $field_id => $value)
        {
            $contact["custom.{$field_id}"] = $value;
        }

		return $this->filterNullValues($contact);
	}
}
