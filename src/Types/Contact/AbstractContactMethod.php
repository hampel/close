<?php namespace Close\Types\Contact;

use Close\Arrayable;
use Close\Exception\InvalidArgumentException;
use Close\Types\AbstractType;

abstract class AbstractContactMethod extends AbstractType implements Arrayable
{
	private static $types = ['office', 'mobile', 'home', 'direct', 'fax', 'url', 'other'];

	/** @var string */
	private $detail;

	/** @var string */
	private $type;

    /**
     * AbstractContactMethod constructor.
     *
     * @param string $detail
     * @param string $type
     */
	public function __construct(string $detail, string $type = "office")
	{
        $this->setDetail($detail);
        $this->setType($type);
	}

	/**
	 * @return string
	 */
	protected function getDetail() : string
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
	public function getType() : string
	{
		return $this->type;
	}

    /**
     * @param string $type
     *
     * @throws InvalidArgumentException
     */
    public function setType(string $type) : void
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
