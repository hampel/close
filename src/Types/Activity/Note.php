<?php namespace Close\Types\Activity;

use Close\Arrayable;
use Close\Exception\InvalidArgumentException;
use Close\Types\AbstractType;

class Note extends AbstractType implements Arrayable
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
    public function __construct(string $lead_id, string $note)
    {
        $this->setLeadId($lead_id);
        $this->setNote($note);
    }

    /**
     * @return string
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
    public function getNote() : string
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote(string $note) : void
    {
        if (empty($note))
        {
            throw new InvalidArgumentException("note is required");
        }

        $this->note = $note;
    }

	/**
	 * @return array
	 */
	public function toArray() : array
	{
		return [
            'lead_id' => $this->getLeadId(),
            'note' => $this->getNote(),
		];
	}
}
