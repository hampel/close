<?php namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ContactPhoneTest extends TestCase
{
    public function test_ContactPhone_null_phone_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('phone number is required');

        new ContactPhone(null);
    }

    public function test_ContactPhone_empty_phone_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('phone number is required');

        new ContactPhone('');
    }

    public function test_ContactPhone_zero_phone_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('phone number is required');

        new ContactPhone(0);
    }

    public function test_ContactPhone_invalid_phone_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('phone number is required');

        new ContactPhone('foo');
    }

    public function test_minimal_ContactPhone()
    {
        $contact = new ContactPhone('1');

        $result = $contact->toArray();

        $this->assertEquals(['phone' => 1, 'type' => 'office'], $result);
    }

    public function test_filtered_ContactPhone()
    {
        $contact = new ContactPhone('+1.9.1234.5678');

        $result = $contact->toArray();

        $this->assertEquals(['phone' => '+1912345678', 'type' => 'office'], $result);
    }
}
