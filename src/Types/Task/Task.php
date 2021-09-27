<?php namespace Close\Types\Task;

use Carbon\Carbon;
use Close\Arrayable;
use Close\Exception\InvalidArgumentException;
use Close\Types\AbstractType;

class Task extends AbstractType implements Arrayable
{
    /** @var string  */
	private $_type = 'lead';

	/** @var string */
	private $lead_id;

	/** @var string */
	private $assigned_to;

	/** @var string */
	private $text;

	/** @var Carbon  */
	private $date;

	/** @var boolean */
	private $is_complete;

    function __construct($lead_id, $text)
	{
		$this->setLeadId($lead_id);
		$this->setText($text);
	}

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getLeadId()
    {
        return $this->lead_id;
    }

    /**
     * @param string $lead_id
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
	public function getAssignedTo()
	{
		return $this->assigned_to;
	}

    /**
     * @param string $assigned_to
     */
    public function setAssignedTo($assigned_to)
    {
        if (substr($assigned_to, 0, 5) !== 'user_')
        {
            throw new InvalidArgumentException("Invalid user_id [{$assigned_to}]");
        }

        $this->assigned_to = $assigned_to;
    }

    /**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

    /**
     * @param string $text
     */
    public function setText($text)
    {
        if (empty($text))
        {
            throw new InvalidArgumentException("text is required");
        }

        $this->text = $text;
    }

    /**
	 * @return Carbon
	 */
	public function getDate()
	{
		return $this->date;
	}

    public function getDateString()
    {
        return $this->date ? $this->date->toDateString() : null;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date)
    {
        $this->date = $date;
    }

    /**
	 * @return boolean
	 */
	public function isComplete()
	{
		return $this->is_complete;
	}

    /**
     * @param boolean $is_complete
     */
    public function setComplete($is_complete = true)
    {
        $this->is_complete = $is_complete;
    }

    /**
	 * @return array
	 */
	public function toArray()
	{
		$task = [
//			'_type' => $this->getType(),
			'lead_id' => $this->getLeadId(),
			'assigned_to' => $this->getAssignedTo(),
			'text' => $this->getText(),
			'date' => $this->getDateString(),
			'is_complete' => $this->isComplete(),
		];

		return $this->filterNullValues($task);
	}
}
