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

	public function getLead($id)
	{
		return $this->client->get("lead/{$id}/");
	}

	public function getLeads($query = null, $_limit = null, $_skip = null, array $fields = [])
	{
		$_fields = empty($fields) ? null : implode(',', $fields);

		$querystring = http_build_query(compact('query', '_limit', '_skip', '_fields'));

		return $this->client->get("lead/" . (empty($querystring) ? "" : "?{$querystring}"));
	}

	public function createLead(Lead $lead)
	{
		return $this->client->post("lead/", $lead->toArray());
	}
}
