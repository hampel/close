<?php namespace Close;

use Close\Types\Lead\Lead;
use Close\Types\Task\Task;
use Close\Types\Activity\Note;
use Close\Types\Activity\Email;
use Psr\Log\LoggerInterface;

class CloseLogger extends Close
{
    protected $logger;

	function __construct(CloseClient $client, LoggerInterface $logger = null)
	{
		parent::__construct($client);
		$this->logger = $logger;
	}

	protected function log($message, array $context = [])
    {
        if ($this->logger)
        {
            $this->logger->debug($message, $context);
        }
    }

	/**
	 * Fetch details about a single lead
	 *
	 * @param string $id	lead ID
     * @param array $fields fields to retrieve
	 *
	 * @return array
	 */
	public function getLead($id, array $fields = [])
	{
        $this->log("getLead", compact('id', 'fields'));

        $result = parent::getLead($id, $fields);

        $this->log("getLead result", compact('result'));

        return $result;
	}

	/**
	 * Search for leads based on query criteria
	 *
	 * @param null $query	optional query (if not specified, all leads will be returned)
	 * @param null $_limit	limit the number of leads to be returned (default: 100)
	 * @param null $_skip	skip leads for paging
	 * @param array $fields	which fields to be returned in the results - helps with performance
	 *
	 * @return array
	 */
	public function queryLeads($query = null, $_limit = null, $_skip = null, array $fields = [])
	{
        $this->log("queryLeads", compact('query', '_limit', '_skip', 'fields'));

        $result = parent::queryLeads($query, $_limit, $_skip, $fields);

        $this->log("queryLeads result", compact('result'));

        return $result;
	}

	/**
	 * Create a new lead
	 *
	 * @param Lead $lead the lead to be created
	 *
	 * @return array
	 */
	public function createLead(Lead $lead)
	{
        $this->log("createLead", ['lead' => $lead->toArray()]);

        $result = parent::createLead($lead);

        $this->log("createLead result", compact('result'));

        return $result;
	}

    /**
     * Update a lead
     *
     * @param string $id the lead to be updated
     * @param array $data fields to update
     *
     * @return array
     */
    public function updateLead($id, array $data)
    {
        $this->log("updateLead", compact('id', 'data'));

        $result = parent::updateLead($id, $data);

        $this->log("updateLead result", compact('result'));

        return $result;
    }

    /**
     * Fetch details about a single contact
     *
     * @param string $id	lead ID
     *
     * @return array
     */
	public function getContact($id)
    {
        $this->log("getContact", compact('id'));

        $result = parent::getContact($id);

        $this->log("getContact result", compact('result'));

        return $result;
    }

    /**
     * Update a contact
     *
     * @param string $id contact id to update
     * @param array $data fields to update
     *
     * @return array
     */
    public function updateContact($id, array $data)
    {
        $this->log("updateContact", compact('id', 'data'));

        $result = parent::updateContact($id, $data);

        $this->log("updateContact result", compact('result'));

        return $result;
    }

	/**
	 * Retrieve details of all custom fields defined in the system
     *
     * @param string $type the type of custom field ('lead', 'contact', 'opportunity', 'activity', 'shared')
	 *
	 * @return array
	 */
	public function getCustomFields($type = 'lead')
	{
        $this->log("getCustomFields", compact('type'));

        $result = parent::getCustomFields($type);

        $this->log("getCustomFields result", compact('result'));

        return $result;
	}

	/**
	 * Retrieve details of a specific custom field
	 *
     * @param string id id of the field to retrieve
     * @param string $type the type of custom field ('lead', 'contact', 'opportunity', 'activity', 'shared')
     *
	 * @return array
	 */
	public function getCustomField($id, $type = 'lead')
	{
        $this->log("getCustomField", compact('id', 'type'));

        $result = parent::getCustomField($id, $type);

        $this->log("getCustomField result", compact('result'));

        return $result;
	}

	public function queryEmails($lead_id = null, $user_id = null, $date_created__gt = null, $date_created__lt = null)
	{
        $this->log("queryEmails", compact('lead_id', 'user_id', 'date_created__gt', 'date_created__lt'));

        $result = parent::queryEmails($lead_id, $user_id, $date_created__gt, $date_created__lt);

        $this->log("queryEmails result", compact('result'));

        return $result;
	}

	public function queryEmailThreads($lead_id = null, $user_id = null, $date_created__gt = null, $date_created__lt = null)
	{
        $this->log("queryEmailThreads", compact('lead_id', 'user_id', 'date_created__gt', 'date_created__lt'));

        $result = parent::queryEmailThreads($lead_id, $user_id, $date_created__gt, $date_created__lt);

        $this->log("queryEmailThreads result", compact('result'));

        return $result;
	}

	public function addNote(Note $note)
	{
        $this->log("addNote", ['note' => $note->toArray()]);

        $result = parent::addNote($note);

        $this->log("addNote result", compact('result'));

        return $result;
	}

	public function addEmail(Email $email)
	{
        $this->log("addEmail", ['email' => $email->toArray()]);

        $result = parent::addEmail($email);

        $this->log("addEmail result", compact('result'));

        return $result;
	}

	public function addTask(Task $task)
	{
        $this->log("addTask", ['task' => $task->toArray()]);

        $result = parent::addTask($task);

        $this->log("addTask result", compact('result'));

        return $result;
	}

	public function getMe()
	{
        $this->log("getMe");

        $result = parent::getMe();

        $this->log("getMe result", compact('result'));

        return $result;
	}

	public function getUser($id)
	{
        $this->log("getUser", compact('id'));

        $result = parent::getUser($id);

        $this->log("getUser result", compact('result'));

        return $result;
	}
}
