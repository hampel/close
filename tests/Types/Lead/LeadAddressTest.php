<?php namespace Close\Types\Lead;

use Close\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LeadAddressTest extends TestCase
{
    public function test_LeadAddress_null_address_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('address1 is required');

        new LeadAddress(null, null, null, null, null);
    }

    public function test_LeadAddress_empty_address_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('address1 is required');

        new LeadAddress('', null, null, null, null);
    }

    public function test_LeadAddress_invalid_label_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid label [foo]');

        new LeadAddress('foo', null, null, null, null, null, 'foo');
    }

    public function test_LeadAddress_invalid_country_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid country code [bar]');

        new LeadAddress('foo', null, null, null, null, 'bar');
    }

    public function test_minimal_LeadAddress()
    {
        $address = new LeadAddress('foo', null, null, null, null);

        $result = $address->toArray();

        $this->assertEquals([
            'address_1' => 'foo',
            'label' => 'business'
        ], $result);
    }

    public function test_LeadAddress_filter_country()
    {
        $address = new LeadAddress('foo', null, null, null, null, 'aa');

        $result = $address->toArray();

        $this->assertEquals([
            'address_1' => 'foo',
            'country' => 'AA',
            'label' => 'business'
        ], $result);
    }

    public function test_LeadAddress()
    {
        $address = new LeadAddress('foo address 1', 'foo address 2', 'foo city', 'foo state', 'foo zip', 'aa', 'other');

        $result = $address->toArray();

        $this->assertEquals([
            'address_1' => 'foo address 1',
            'address_2' => 'foo address 2',
            'city' => 'foo city',
            'state' => 'foo state',
            'zipcode' => 'foo zip',
            'country' => 'AA',
            'label' => 'other'
        ], $result);
    }
}
