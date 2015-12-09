<?php namespace CloseIo\Types\Activity;

class Note implements Arrayable
{
	private $note;

	private $lead_id;

	function __construct($note, $lead_id)
	{
		$this->note = $note;
		$this->lead_id = $lead_id;
	}

	/**
	 * @return mixed
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * @return mixed
	 */
	public function getLeadId()
	{
		return $this->lead_id;
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
			'note' => $this->getNote(),
			'lead_id' => $this->getLeadId(),
		];
	}
}
