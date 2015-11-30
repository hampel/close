<?php namespace CloseIo;

use CloseIo\Types\Lead;

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
}
