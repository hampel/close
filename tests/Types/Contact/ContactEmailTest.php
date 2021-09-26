<?php namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;
use Close\Types\EmailAddress;
use PHPUnit\Framework\TestCase;

class ContactEmailTest extends TestCase
{
    public function test_ContactEmail_with_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type [foo]');

        $email = new EmailAddress('foo@example.com');
        new ContactEmail($email, 'foo');
    }

    public function test_minimal_ContactEmail()
    {
        $email = new EmailAddress('foo@example.com');
        $contact = new ContactEmail($email);

        $result = $contact->toArray();

        $this->assertEquals(['email' => 'foo@example.com', 'type' => 'office'], $result);
    }
}
