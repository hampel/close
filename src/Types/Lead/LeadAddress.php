<?php namespace Close\Types\Lead;

use Close\Arrayable;
use Close\Exception\LengthException;
use Close\Exception\UnknownLabelException;

class LeadAddress implements Arrayable
{
	static $labels = ['business', 'mailing', 'other'];

	private $label;

	private $address_1;

	private $address_2;

	private $city;

	private $state;

	private $zipcode;

	private $country;

	function __construct($label, $address_1, $address_2, $city, $state, $zipcode, $country)
	{
		if (!in_array($label, self::$labels))
		{
			throw new UnknownLabelException("Unknown label [{$label}]");
		}

		if (strlen($country) > 2)
		{
			throw new LengthException("Country code should only be 2 characters [{$country}]");
		}

		$this->label = $label;
		$this->address_1 = $address_1;
		$this->address_2 = $address_2;
		$this->city = $city;
		$this->state = $state;
		$this->zipcode = $zipcode;
		$this->country = strtoupper($country);
	}

	/**
	 * @return array
	 */
	public static function getLabels()
	{
		return self::$labels;
	}

	/**
	 * @return mixed
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * @return mixed
	 */
	public function getAddress1()
	{
		return $this->address_1;
	}

	/**
	 * @return mixed
	 */
	public function getAddress2()
	{
		return $this->address_2;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @return mixed
	 */
	public function getZipcode()
	{
		return $this->zipcode;
	}

	/**
	 * @return mixed
	 */
	public function getCountry()
	{
		return $this->country;
	}

	public function toArray()
	{
		return [
			'label' => $this->getLabel(),
			'address_1' => $this->getAddress1(),
			'address_2' => $this->getAddress2(),
			'city' => $this->getCity(),
			'state' => $this->getState(),
			'zipcode' => $this->getZipcode(),
			'country' => $this->getCountry(),
		];
	}
}
