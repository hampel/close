<?php namespace CloseIo;

use CloseIo\Types\Lead\Lead;
use CloseIo\Types\Activity\Email;

class CloseIo
{
	/** @var CloseIoClient our client implementation */
	protected $client;

	function __construct(CloseIoClient $client)
	{
		$this->client = $client;
	}

	/**
	 * Fetch details about a single lead
	 *
	 * @param $id	lead ID
	 *
	 * @return array
	 */
	public function getLead($id)
	{
		return $this->client->get("lead/{$id}/");
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
		$_fields = empty($fields) ? null : implode(',', $fields);

		$querystring = http_build_query(compact('query', '_limit', '_skip', '_fields'));

		return $this->client->get("lead/" . (empty($querystring) ? "" : "?{$querystring}"));
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
		return $this->client->post("lead/", $lead->toArray());
	}

	/**
	 * Retrieve details of all custom fields defined in the system
	 *
	 * @return array
	 */
	public function getCustomFields()
	{
		return $this->client->get("custom_fields/lead/");
	}

	/**
	 * Retrieve details of a specific custom field
	 *
	 * @return array
	 */
	public function getCustomField($id)
	{
		return $this->client->get("custom_fields/lead/{$id}");
	}

	public function queryEmails($lead_id = null, $user_id = null, $date_created__gt = null, $date_created__lt = null)
	{
		$querystring = http_build_query(compact('lead_id', 'user_id', 'date_created__gt', 'date_created__lt'));

		return $this->client->get("activity/email/" . (empty($querystring) ? "" : "?{$querystring}"));
	}

	public function queryEmailThreads($lead_id = null, $user_id = null, $date_created__gt = null, $date_created__lt = null)
	{
		$querystring = http_build_query(compact('lead_id', 'user_id', 'date_created__gt', 'date_created__lt'));

		return $this->client->get("activity/emailthread/" . (empty($querystring) ? "" : "?{$querystring}"));
	}

	/**
	 * Add a note to a lead
	 *
	 * @param $note		string - content for the note (no HTML)
	 * @param $lead_id	the ID of the lead to add the note to
	 *
	 * @return array
	 */
	public function addNote($note, $lead_id)
	{
		return $this->client->post("activity/note/", compact('note', 'lead_id'));
	}

	public function addEmail(Email $email)
	{
		return $this->client->post("activity/email/", $email->toArray());
	}

	public function getMe()
	{
		return $this->client->get("me/");
	}

	public function getUser($id)
	{
		return $this->client->get("user/{$id}/");
	}
}
