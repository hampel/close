<?php namespace Close\Types\Task;

use Carbon\Carbon;
use Close\Exception\InvalidArgumentException;
use Close\Types\EmailAddress;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function test_Task_empty_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lead_id []');

        new Task("", "");
    }

    public function test_Task_invalid_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lead_id [lead foo]');

        new Task('lead foo', "");
    }

    public function test_Task_empty_text_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('text is required');

        new Task('lead_foo', "");
    }

    public function test_Task_empty_assigned_to_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid user_id []');

        $task = new Task('lead_foo', 'text foo');
        $task->setAssignedTo("");
    }

    public function test_Task_invalid_assigned_to_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid user_id [user foo]');

        $task = new Task('lead_foo', 'text foo');
        $task->setAssignedTo('user foo');
    }

    public function test_minimal_Task()
    {
        $lead = new Task('lead_foo', 'text foo');

        $result = $lead->toArray();

        $this->assertEquals(['lead_id' => 'lead_foo', 'text' => 'text foo'], $result);
    }

    public function test_full_Task()
    {
        $date = Carbon::create(2000, 1, 1);

        $lead = new Task('lead_foo', 'text foo');
        $lead->setAssignedTo('user_foo');
        $lead->setDate($date);
        $lead->setComplete();

        $result = $lead->toArray();

        $this->assertEquals([
            'lead_id' => 'lead_foo',
            'text' => 'text foo',
            'assigned_to' => 'user_foo',
            'date' => $date->toDateString(),
            'is_complete' => true
        ], $result);
    }
}
