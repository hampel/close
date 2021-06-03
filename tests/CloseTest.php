<?php namespace Close\Tests;

use Close\Close;
use Close\CloseClient;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class CloseTest extends TestCase
{
    protected $client;

    protected $close;

    public function setUp() : void
    {
        parent::setUp();

        $this->client = m::mock(CloseClient::class);

        $this->close = new Close($this->client);
    }

    public function test_getLead()
    {
        $this->client->expects()->get('lead/foo/')->once()->andReturns([]);

        $lead = $this->close->getLead('foo');

        $this->assertIsArray($lead);
    }

    public function test_queryLeads_no_parameters()
    {
        $this->client->expects()->get('lead/')->once()->andReturns([]);

        $lead = $this->close->queryLeads();

        $this->assertIsArray($lead);
    }

    public function test_queryLeads_withQuery()
    {
        $this->client->expects()->get('lead/?query=company%3A%22foo%22')->once()->andReturns([]);

        $lead = $this->close->queryLeads('company:"foo"');

        $this->assertIsArray($lead);
    }
}
