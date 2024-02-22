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

    function __construct(string $lead_id, string $text)
	{
		$this->setLeadId($lead_id);
		$this->setText($text);
	}

    /**
     * @return string|null
     */
    public function getType() : ?string
    {
        return $this->_type;
    }

    /**
     * @return mixed
     */
    public function getLeadId() : string
    {
        return $this->lead_id;
    }

    /**
     * @param string $lead_id
     */
    public function setLeadId(string $lead_id) : void
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
	public function getAssignedTo() : ?string
	{
		return $this->assigned_to;
	}

    /**
     * @param string $assigned_to
     */
    public function setAssignedTo(string $assigned_to) : void
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
	public function getText() : string
	{
		return $this->text;
	}

    /**
     * @param string $text
     */
    public function setText(string $text) : void
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
	public function getDate() : Carbon
	{
		return $this->date;
	}

    public function getDateString() : ?string
    {
        return $this->date ? $this->date->toDateString() : null;
    }

    /**
     * @param Carbon $date
     */
    public function setDate(Carbon $date) : void
    {
        $this->date = $date;
    }

    /**
	 * @return boolean|null
	 */
	public function isComplete() : ?bool
	{
		return $this->is_complete;
	}

    /**
     * @param boolean $is_complete
     */
    public function setComplete(bool $is_complete = true) : void
    {
        $this->is_complete = $is_complete;
    }

    /**
	 * @return array
	 */
	public function toArray() : array
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
