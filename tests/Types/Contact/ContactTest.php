<?php namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;
use Close\Types\EmailAddress;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function test_Contact_no_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lead_id []');

        new Contact(null, null);
    }

    public function test_Contact_invalid_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lead_id [foo]');

        new Contact('foo', null);
    }

    public function test_Contact_no_name_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name is required');

        new Contact('lead_foo', null);
    }

    public function test_minimal_Contact()
    {
        $email = new Contact('lead_foo', 'name foo');

        $result = $email->toArray();

        $this->assertEquals(['lead_id' => 'lead_foo', 'name' => 'name foo'], $result);
    }

    public function test_Contact_with_custom_field_strips_prefix()
    {
        $email = new Contact('lead_foo', 'name foo');
        $email->setCustomField('custom.foo', 'bar');

        $this->assertEquals(['foo' => 'bar'], $email->getCustomFields());

        $result = $email->toArray();

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'name' => 'name foo',
            'custom.foo' => 'bar'
        ], $result);
    }

    public function test_full_Contact()
    {
        $email = new Contact('lead_foo', 'name foo');
        $email->setTitle('foo title');
        $email->addPhone(new ContactPhone('123'));
        $email->addPhone(new ContactPhone('456', 'home'));
        $email->addEmail(new ContactEmail(new EmailAddress('foo1@example.com')));
        $email->addEmail(new ContactEmail(new EmailAddress('foo2@example.com'), 'other'));
        $email->addUrl(new ContactUrl('http://example.com'));

        $result = $email->toArray();

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'name' => 'name foo',
            'phones' => [
                ['phone' => '123', 'type' => 'office'],
                ['phone' => '456', 'type' => 'home']
            ],
            'emails' => [
                ['email' => 'foo1@example.com', 'type' => 'office'],
                ['email' => 'foo2@example.com', 'type' => 'other']
            ],
            'urls' => [
                ['url' => 'http://example.com', 'type' => 'url']
            ],
            'title' => 'foo title'
        ], $result);
    }
}
