<?php namespace Close\Types\Activity;

use Close\Arrayable;
use Close\Exception\InvalidArgumentException;

class Note implements Arrayable
{
    /** @var string */
    private $lead_id;

    /** @var string */
    private $note;

    /**
     * Note constructor.
     *
     * @param string $lead_id
     * @param string $note
     *
     * @throws InvalidArgumentException
     */
    public function __construct($lead_id, $note)
    {
        if (empty($lead_id))
        {
            throw new InvalidArgumentException("lead_id is required");
        }

        if (empty($note))
        {
            throw new InvalidArgumentException("note is required");
        }

        $this->setLeadId($lead_id);
        $this->setNote($note);
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
     */
    public function setLeadId($lead_id)
    {
        if (!empty($lead_id) AND substr($lead_id, 0, 5) !== 'lead_')
        {
            throw new InvalidArgumentException("Invalid lead_id [{$lead_id}]");
        }

        $this->lead_id = $lead_id;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

	/**
	 * @return array
	 */
	public function toArray()
	{
		return [
            'lead_id' => $this->getLeadId(),
            'note' => $this->getNote(),
		];
	}
}
