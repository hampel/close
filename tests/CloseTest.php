<?php namespace Close\Tests;

use Close\Close;
use Close\CloseClient;
use Close\Exception\InvalidArgumentException;
use Close\Types\Lead\Lead;
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

    public function test_getLead_no_fields()
    {
        $this->client->expects()->get('lead/foo/')->once()->andReturns([]);

        $lead = $this->close->getLead('foo');

        $this->assertIsArray($lead);
    }

    public function test_getLead_with_fields()
    {
        $this->client->expects()->get('lead/foo/?_fields=fieldA%2CfieldB')->once()->andReturns([]);

        $lead = $this->close->getLead('foo', ['fieldA', 'fieldB']);

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

    public function test_queryLeads_with_params()
    {
        $this->client->expects()->get('lead/?query=company%3A%22foo%22&_limit=10&_skip=5&_fields=fieldA%2CfieldB')->once()->andReturns([]);

        $lead = $this->close->queryLeads('company:"foo"', 10, 5, ['fieldA', 'fieldB']);

        $this->assertIsArray($lead);
    }

    public function test_createLead()
    {
        $this->client->expects()->post('lead/', ['name' => 'foo'])->once()->andReturns([]);

        $lead = $this->close->createLead(new Lead('foo'));

        $this->assertIsArray($lead);
    }

    public function test_getCustomFields_no_params()
    {
        $this->client->expects()->get('custom_fields/lead/')->once()->andReturns([]);

        $fields = $this->close->getCustomFields();

        $this->assertIsArray($fields);
    }

    public function test_getCustomFields_type_contact()
    {
        $this->client->expects()->get('custom_fields/contact/')->once()->andReturns([]);

        $fields = $this->close->getCustomFields('contact');

        $this->assertIsArray($fields);
    }

    public function test_getCustomFields_invalid_type_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid custom field type [foo]');

        $this->close->getCustomFields('foo');
    }
}
