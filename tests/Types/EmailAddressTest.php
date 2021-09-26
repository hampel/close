<?php namespace Close\Types;

use Close\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailAddressTest extends TestCase
{
    public function test_EmailAddress_null_email_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address []');

        new EmailAddress(null);
    }

    public function test_EmailAddress_empty_email_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address []');

        new EmailAddress('');
    }

    public function test_EmailAddress_invalid_email_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid email address [foo]');

        new EmailAddress('foo');
    }

    public function test_minimal_EmailAddress()
    {
        $email = new EmailAddress('foo@example.com');

        $result = strval($email);

        $this->assertEquals('foo@example.com', $result);
    }

    public function test_EmailAddress_with_name_param()
    {
        $email = new EmailAddress('foo@example.com', 'foo name');

        $result = strval($email);

        $this->assertEquals('foo name <foo@example.com>', $result);
    }

    public function test_EmailAddress_with_name_in_email()
    {
        $email = new EmailAddress('foo name <foo@example.com>');

        $result = strval($email);

        $this->assertEquals('foo name <foo@example.com>', $result);
    }

    public function test_EmailAddress_with_name_in_email_and_param()
    {
        $email = new EmailAddress('foo 1 name <foo@example.com>', 'foo 2 name');

        $result = strval($email);

        $this->assertEquals('foo 1 name <foo@example.com>', $result);
    }
}
