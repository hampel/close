<?php namespace CloseIo\Types\Task;

use Carbon\Carbon;
use CloseIo\Arrayable;
use CloseIo\Exception\InvalidArgumentException;

class Task implements Arrayable
{
	private $_type = 'lead';

	private $lead_id;

	private $assigned_to;

	private $text;

	private $date;

	private $is_complete;

	function __construct($lead_id, $assigned_to, $text, Carbon $date, $is_complete = false)
	{
		if (!empty($lead_id) AND substr($lead_id, 0, 5) !== 'lead_')
		{
			throw new InvalidArgumentException("Invalid lead_id passed to Email activity constructor: [{$lead_id}]");
		}

		if (!empty($assigned_to) AND substr($assigned_to, 0, 5) !== 'user_')
		{
			throw new InvalidArgumentException("Invalid user_id passed to Lead task activity constructor: [{$assigned_to}]");
		}

		$this->lead_id = $lead_id;
		$this->assigned_to = $assigned_to;
		$this->text = $text;
		$this->date = $date;
		$this->is_complete = $is_complete;
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
	 * @return mixed
	 */
	public function getAssignedTo()
	{
		return $this->assigned_to;
	}

	/**
	 * @return mixed
	 */
	public function getText()
	{
		return $this->text;
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
		return $this->date->toDateString();
	}

	/**
	 * @return boolean
	 */
	public function isComplete()
	{
		return $this->is_complete;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'_type' => $this->getType(),
			'lead_id' => $this->getLeadId(),
			'assigned_to' => $this->getAssignedTo(),
			'text' => $this->getText(),
			'date' => $this->getDateString(),
			'is_complete' => $this->isComplete(),
		];
	}
}
