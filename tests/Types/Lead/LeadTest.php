<?php namespace Close\Types\Lead;

use Close\Exception\InvalidArgumentException;
use Close\Types\Contact\Contact;
use PHPUnit\Framework\TestCase;

class LeadTest extends TestCase
{
    public function test_Lead_null_name_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name is required');

        new Lead(null);
    }

    public function test_Lead_empty_name_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name is required');

        new Lead('');
    }

    public function test_Lead_invalid_url_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid url [url foo]');

        $lead = new Lead('name foo');
        $lead->setUrl('url foo');
    }

    public function test_Lead_invalid_status_id_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid status_id [status foo]');

        $lead = new Lead('name foo');
        $lead->setStatusId('status foo');
    }

    public function test_minimal_Lead()
    {
        $lead = new Lead('name foo');

        $result = $lead->toArray();

        $this->assertEquals([
            'name' => 'name foo',
        ], $result);
    }

    public function test_Lead_with_custom_field_strips_prefix()
    {
        $lead = new Lead('name foo');
        $lead->setCustomField('custom.foo', 'bar');

        $this->assertEquals(['foo' => 'bar'], $lead->getCustomFields());

        $result = $lead->toArray();

        $this->assertEquals([
            'name' => 'name foo',
            'custom.foo' => 'bar'
        ], $result);
    }

    public function test_full_Lead()
    {
        $lead = new Lead('name foo');
        $lead->setUrl('http://example.com');
        $lead->setDescription('description foo');
        $lead->setStatusId('stat_foo');
        $lead->addContact(new Contact('contact foo'));
        $lead->setCustomField('custom.foo', 'bar');
        $lead->addAddress(new LeadAddress('address foo', null, null, null, null));

        $result = $lead->toArray();

        $this->assertEquals([
            'name' => 'name foo',
            'url' => 'http://example.com',
            'description' => 'description foo',
            'status_id' => 'stat_foo',
            'contacts' => [
                ['name' => 'contact foo'],
            ],
            'custom.foo' => 'bar',
            'addresses' => [
                ['address_1' => 'address foo']
            ]
        ], $result);

    }
}
