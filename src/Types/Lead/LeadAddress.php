<?php namespace Close\Types\Lead;

use Close\Arrayable;
use Close\Exception\InvalidArgumentException;
use Close\Types\AbstractType;

class LeadAddress extends AbstractType implements Arrayable
{
	private static $labels = ['business', 'mailing', 'other'];

	/** @var string */
	private $label;

	/** @var string */
	private $address_1;

	/** @var string */
	private $address_2;

	/** @var string */
	private $city;

	/** @var string */
	private $state;

	/** @var string */
	private $zipcode;

	/** @var string string */
	private $country;

    /**
     * LeadAddress constructor.
     *
     * @param string $address_1
     * @param string $address_2
     * @param string $city
     * @param string $state
     * @param string $zipcode
     * @param string|null $country - 2 character country iso code
     * @param string $label
     */
	function __construct($address_1, $address_2, $city, $state, $zipcode, $country = null, $label = null)
	{
        $this->setAddress1($address_1);
        $this->setAddress2($address_2);
        $this->setCity($city);
        $this->setState($state);
        $this->setZipcode($zipcode);
        if ($country)
        {
            $this->setCountry($country);
        }
        if ($label)
        {
            $this->setLabel($label);
        }
	}

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        if (!in_array($label, self::$labels))
        {
            throw new InvalidArgumentException("Invalid label [{$label}]");
        }

        $this->label = $label;
    }

    /**
	 * @return mixed
	 */
	public function getLabel()
	{
		return $this->label;
	}

    /**
	 * @return string
	 */
	public function getAddress1()
	{
		return $this->address_1;
	}

    /**
     * @param string $address_1
     *
     * @throws InvalidArgumentException
     */
    public function setAddress1($address_1)
    {
        if (empty($address_1))
        {
            throw new InvalidArgumentException("address1 is required");
        }

        $this->address_1 = $address_1;
    }

    /**
	 * @return string
	 */
	public function getAddress2()
	{
		return $this->address_2;
	}

    /**
     * @param string $address_2
     */
    public function setAddress2($address_2)
    {
        $this->address_2 = $address_2;
    }

    /**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
	 * @return string
	 */
	public function getState()
	{
		return $this->state;
	}

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
	 * @return string
	 */
	public function getZipcode()
	{
		return $this->zipcode;
	}

    /**
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        if (preg_match('/^[A-Z]{2}$/i', $country) === 0)
        {
            throw new InvalidArgumentException("Invalid country code [{$country}]");
        }

        $this->country = strtoupper($country);
    }

    public function toArray()
	{
		$address = [
			'label' => $this->getLabel(),
			'address_1' => $this->getAddress1(),
			'address_2' => $this->getAddress2(),
			'city' => $this->getCity(),
			'state' => $this->getState(),
			'zipcode' => $this->getZipcode(),
			'country' => $this->getCountry(),
		];

		return $this->filterNullValues($address);
	}
}
