<?php namespace Close\Types\Contact;

use Close\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ContactUrlTest extends TestCase
{
    public function test_ContactUrl_empty_url_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid url []');

        new ContactUrl("");
    }

    public function test_ContactUrl_invalid_url_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid url [foo]');

        new ContactUrl('foo');
    }

    public function test_minimal_ContactUrl()
    {
        $url = new ContactUrl('http://example.com');

        $result = $url->toArray();

        $this->assertEquals(['url' => 'http://example.com', 'type' => 'url'], $result);
    }
}
