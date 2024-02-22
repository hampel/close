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
	function __construct(string $address_1, ?string $address_2 = null, ?string $city = null, ?string $state = null, ?string $zipcode = null, ?string $country = null, ?string $label = null)
	{
        $this->setAddress1($address_1);
        if ($address_2)
        {
            $this->setAddress2($address_2);
        }

        if ($city)
        {
            $this->setCity($city);
        }

        if ($state)
        {
            $this->setState($state);
        }

        if ($zipcode)
        {
            $this->setZipcode($zipcode);
        }

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
    public function setLabel(string $label) : void
    {
        if (!in_array($label, self::$labels))
        {
            throw new InvalidArgumentException("Invalid label [{$label}]");
        }

        $this->label = $label;
    }

    /**
	 * @return string|null
	 */
	public function getLabel() : ?string
	{
		return $this->label;
	}

    /**
	 * @return string
	 */
	public function getAddress1() : string
	{
		return $this->address_1;
	}

    /**
     * @param string $address_1
     *
     * @throws InvalidArgumentException
     */
    public function setAddress1(string $address_1) : void
    {
        if (empty($address_1))
        {
            throw new InvalidArgumentException("address1 is required");
        }

        $this->address_1 = $address_1;
    }

    /**
	 * @return string|null
	 */
	public function getAddress2() : ?string
	{
		return $this->address_2;
	}

    /**
     * @param string $address_2
     */
    public function setAddress2(string $address_2) : void
    {
        $this->address_2 = $address_2;
    }

    /**
	 * @return string|null
	 */
	public function getCity() : ?string
	{
		return $this->city;
	}

    /**
     * @param string $city
     */
    public function setCity(string $city) : void
    {
        $this->city = $city;
    }

    /**
	 * @return string|null
	 */
	public function getState() : ?string
	{
		return $this->state;
	}

    /**
     * @param string $state
     */
    public function setState(string $state) : void
    {
        $this->state = $state;
    }

    /**
	 * @return string|null
	 */
	public function getZipcode() : ?string
	{
		return $this->zipcode;
	}

    /**
     * @param string $zipcode
     */
    public function setZipcode(string $zipcode) : void
    {
        $this->zipcode = $zipcode;
    }

    /**
	 * @return string|null
	 */
	public function getCountry() : ?string
	{
		return $this->country;
	}

    /**
     * @param string $country   2 character ISO country code
     */
    public function setCountry(string $country) : void
    {
        // TODO: consider implementing league/iso3166 or similar to validate that the country code is valid
        if (preg_match('/^[A-Z]{2}$/i', $country) === 0)
        {
            throw new InvalidArgumentException("Invalid country code [{$country}]");
        }

        $this->country = strtoupper($country);
    }

    public function toArray() : array
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
