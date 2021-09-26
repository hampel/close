<?php namespace Close\Types\Contact;

use Close\Arrayable;
use Close\Exception\InvalidArgumentException;
use Close\Types\AbstractType;

abstract class AbstractContactMethod extends AbstractType implements Arrayable
{
	private static $types = ['office', 'mobile', 'home', 'direct', 'fax', 'url', 'other'];

	/** @var mixed */
	private $detail;

	/** @var string */
	private $type;

    /**
     * AbstractContactMethod constructor.
     *
     * @param mixed $detail
     * @param string $type
     */
	public function __construct($detail, $type = "office")
	{
        $this->setDetail($detail);
        $this->setType($type);
	}

	/**
	 * @return mixed
	 */
	protected function getDetail()
	{
		return $this->detail;
	}

    /**
     * @param mixed $detail
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
    }

    /**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

    /**
     * @param string $type
     *
     * @throws InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, self::$types))
        {
            throw new InvalidArgumentException("Invalid type [{$type}]");
        }

        $this->type = $type;
    }

//	public function equals(ContactMethod $other)
//	{
//		return (($this->type === $other->type) && ($this->detail === $other->detail));
//	}

	abstract public function toArray();
}
