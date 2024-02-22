<?php namespace Close\Types\Activity;

use Close\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NoteTest extends TestCase
{
    public function test_Note_no_lead_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid lead_id []');

        new Note("", "");
    }

    public function test_Note_no_note_throws_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('note is required');

        new Note('lead_foo', "");
    }

    public function test_Note_with_data()
    {
        $note = new Note('lead_foo', 'note foo');

        $this->assertEquals('lead_foo', $note->getLeadId());
        $this->assertEquals('note foo', $note->getNote());

        $data = $note->toArray();

        $this->assertEquals(['lead_id' => 'lead_foo', 'note' => 'note foo'], $data);
    }

    public function test_Note_set_new_data()
    {
        $note = new Note('lead_foo', 'note foo');
        $note->setLeadId('lead_foo2');
        $note->setNote('note foo2');

        $this->assertEquals('lead_foo2', $note->getLeadId());
        $this->assertEquals('note foo2', $note->getNote());

        $data = $note->toArray();

        $this->assertEquals(['lead_id' => 'lead_foo2', 'note' => 'note foo2'], $data);
    }
}
