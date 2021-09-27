<?php namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;
use Close\Types\EmailAddress;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function test_Contact_no_name_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name is required');

        new Contact(null);
    }

    public function test_Contact_empty_name_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('name is required');

        new Contact('');
    }

    public function test_Contact_invalid_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lead_id [lead foo]');

        new Contact('name foo', 'lead foo');
    }

    public function test_minimal_Contact()
    {
        $contact = new Contact('name foo');

        $result = $contact->toArray();

        $this->assertEquals(['name' => 'name foo'], $result);
    }

    public function test_Contact_with_custom_field_strips_prefix()
    {
        $contact = new Contact('name foo');
        $contact->setCustomField('custom.foo', 'bar');

        $this->assertEquals(['foo' => 'bar'], $contact->getCustomFields());

        $result = $contact->toArray();

        $this->assertEquals([
            'name' => 'name foo',
            'custom.foo' => 'bar'
        ], $result);
    }

    public function test_full_Contact()
    {
        $contact = new Contact('name foo', 'lead_foo');
        $contact->setTitle('foo title');
        $contact->addPhone(new ContactPhone('123'));
        $contact->addPhone(new ContactPhone('456', 'home'));
        $contact->addEmail(new ContactEmail(new EmailAddress('foo1@example.com')));
        $contact->addEmail(new ContactEmail(new EmailAddress('foo2@example.com'), 'other'));
        $contact->addUrl(new ContactUrl('http://example.com'));

        $result = $contact->toArray();

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
