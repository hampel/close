<?php namespace Close\Types\Activity;

use Carbon\Carbon;
use Close\Exception\InvalidArgumentException;
use Close\Types\EmailAddress;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_Email_no_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('lead_id is required');

        new Email(null, null, null);
    }

    public function test_Email_no_direction_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('direction is required');

        new Email('lead_foo', null, null);
    }

    public function test_Email_invalid_direction_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid direction [foo]');

        new Email('lead_foo', 'foo', null);
    }

    public function test_Email_no_status_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('status is required');

        new Email('lead_foo', 'incoming', null);
    }

    public function test_Email_invalid_status_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid status [foo]');

        new Email('lead_foo', 'incoming', 'foo');
    }

    public function test_minimal_Email()
    {
        $email = new Email('lead_foo', 'incoming', 'sent');

        $result = $email->toArray();

        $this->assertEquals(['lead_id' => 'lead_foo', 'direction' => 'incoming', 'status' => 'sent'], $result);
    }

    public function test_logOutboundEmail()
    {
        $date = Carbon::create(2000, 1, 1, 0, 0, 0);

        $email = Email::logOutboundEmail('lead_foo', $date, 'subject foo', 'foo.sender@example.com', 'foo.recipient@example.com', 'foo body');

        $result = $email->toArray();

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'direction' => 'outgoing',
            'status' => 'sent',
            'date_created' => $date->toAtomString(),
            'subject' => 'subject foo',
            'sender' => 'foo.sender@example.com',
            'to' => ['foo.recipient@example.com'],
            'body_text' => 'foo body'
        ], $result);
    }

    public function test_logInboundEmail()
    {
        $date = Carbon::create(2000, 1, 1, 0, 0, 0);

        $email = Email::logInboundEmail('lead_foo', $date, 'subject foo', 'foo.sender@example.com', 'foo.recipient@example.com', 'foo body');

        $result = $email->toArray();

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'direction' => 'incoming',
            'status' => 'inbox',
            'date_created' => $date->toAtomString(),
            'subject' => 'subject foo',
            'sender' => 'foo.sender@example.com',
            'to' => ['foo.recipient@example.com'],
            'body_text' => 'foo body'
        ], $result);
    }

    public function test_getSender_returns_full_email()
    {
        $email = new Email('lead_foo', 'incoming', 'sent');
        $address = new EmailAddress('sender@example.com', 'Sender');

        $email->setSender($address);

        $this->assertEquals('Sender <sender@example.com>', $email->getSender());

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'direction' => 'incoming',
            'status' => 'sent',
            'sender' => 'Sender <sender@example.com>',
        ], $email->toArray());
    }

    public function test_getTo_returns_full_emails()
    {
        $email = new Email('lead_foo', 'incoming', 'sent');

        $address1 = new EmailAddress('sender.1@example.com', 'Sender 1');
        $address2 = new EmailAddress('sender.2@example.com', 'Sender 2');

        $email->addTo($address1);
        $email->addTo($address2);

        $this->assertEquals(['Sender 1 <sender.1@example.com>', 'Sender 2 <sender.2@example.com>'], $email->getTo());

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'direction' => 'incoming',
            'status' => 'sent',
            'to' => ['Sender 1 <sender.1@example.com>', 'Sender 2 <sender.2@example.com>'],
        ], $email->toArray());
    }

    public function test_getCc_returns_full_emails()
    {
        $email = new Email('lead_foo', 'incoming', 'sent');

        $address1 = new EmailAddress('sender.1@example.com', 'Sender 1');
        $address2 = new EmailAddress('sender.2@example.com', 'Sender 2');

        $email->addCc($address1);
        $email->addCc($address2);

        $this->assertEquals(['Sender 1 <sender.1@example.com>', 'Sender 2 <sender.2@example.com>'], $email->getCc());

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'direction' => 'incoming',
            'status' => 'sent',
            'cc' => ['Sender 1 <sender.1@example.com>', 'Sender 2 <sender.2@example.com>'],
        ], $email->toArray());
    }

    public function test_getBcc_returns_full_emails()
    {
        $email = new Email('lead_foo', 'incoming', 'sent');

        $address1 = new EmailAddress('sender.1@example.com', 'Sender 1');
        $address2 = new EmailAddress('sender.2@example.com', 'Sender 2');

        $email->addBcc($address1);
        $email->addBcc($address2);

        $this->assertEquals(['Sender 1 <sender.1@example.com>', 'Sender 2 <sender.2@example.com>'], $email->getBcc());

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'direction' => 'incoming',
            'status' => 'sent',
            'bcc' => ['Sender 1 <sender.1@example.com>', 'Sender 2 <sender.2@example.com>'],
        ], $email->toArray());
    }
}
