<?php namespace Close\Types\Activity;

use Carbon\Carbon;
use Close\Arrayable;
use Close\Types\AbstractType;
use Close\Types\EmailAddress;
use Close\Exception\InvalidArgumentException;

class Email extends AbstractType implements Arrayable
{
    /** @var string[]  */
	private static $directions = ['incoming', 'outgoing'];

	/** @var string[]  */
    private static $statuses = ['inbox', 'draft', 'scheduled', 'outbox', 'sent'];

	/** @var string  */
    private $contact_id;

    /** @var string  */
	private $user_id;

	/** @var string  */
	private $lead_id;

	/** @var string  */
	private $direction;

	/** @var string  */
	private $created_by;

	/** @var string  */
    private $created_by_name;

	/** @var Carbon date created */
	private $date_created;

	/** @var string  */
	private $subject;

	/** @var EmailAddress  */
    private $sender;

	/** @var EmailAddress[] */
	private $to = [];

	/** @var EmailAddress[] */
	private $bcc = [];

	/** @var EmailAddress[] */
	private $cc = [];

	/** @var string  */
    private $status;

    /** @var string  */
    private $body_text;

    /** @var string  */
	private $body_html;

//	$private attachments;

    /** @var optional|null  */
	private $template_id;

	/**
	 * @param string $lead_id		required - Close.com lead to associate message with ("lead_???")
	 * @param string $direction	    required - ['incoming', 'outgoing']
	 * @param string $status        required - ['inbox', 'draft', 'scheduled', 'outbox', 'sent'] - setting status to "outbox" will send an email!
     * @param string|null $subject  optional - subject of the message
	 */
	public function __construct(string $lead_id, string $direction, string $status, ?string $subject = null)
	{
		$this->setLeadId($lead_id);
		$this->setDirection($direction);
		$this->setStatus($status);
		if ($subject) $this->setSubject($subject);
	}

    /**
     * @param string $lead_id       Close.com lead
     * @param Carbon $date_created  date created
     * @param string $subject       email subject
     * @param string $sender        sender email address
     * @param string $to            recipient email address
     * @param string|null $body_text optional email body text
     * @param string|null $body_html option email body html
     *
     * @return Email
     */
	public static function logOutboundEmail(string $lead_id, Carbon $date_created, string $subject, string $sender, string $to, ?string $body_text = null, ?string $body_html = null) : Email
	{
		$email = new static($lead_id, 'outgoing', 'sent', $subject);
		$email->setDateCreated($date_created);
		$email->setSender(new EmailAddress($sender));
		$email->addTo(new EmailAddress($to));
        if ($body_text) $email->setBodyText($body_text);
        if ($body_html) $email->setBodyHtml($body_html);

		return $email;
	}

    /**
     * @param string $lead_id Close.com lead
     * @param Carbon $date_created date created
     * @param string $subject email subject
     * @param string $sender sender email address
     * @param string $to recipient email address
     * @param string|null $body_text optional email body text
     * @param string|null $body_html option email body html
     *
     * @return Email
     */
	public static function logInboundEmail(string $lead_id, Carbon $date_created, string $subject, string $sender, string $to, ?string $body_text = null, ?string $body_html = null) : Email
	{
        $email = new static($lead_id, 'incoming', 'inbox', $subject);
        $email->setDateCreated($date_created);
        $email->setSender(new EmailAddress($sender));
        $email->addTo(new EmailAddress($to));
        if ($body_text) $email->setBodyText($body_text);
        if ($body_html) $email->setBodyHtml($body_html);

        return $email;
	}

    /**
	 * @return string
	 */
	public function getContactId() : ?string
	{
		return $this->contact_id;
	}

    /**
     * @param string $contact_id Close.com contact id to associate message with ("cont_???")
     *
     * @throws InvalidArgumentException
     */
    public function setContactId(string $contact_id) : void
    {
        if (substr($contact_id, 0, 5) !== 'cont_')
        {
            throw new InvalidArgumentException("Invalid contact_id [{$contact_id}]");
        }

        $this->contact_id = $contact_id;
    }

    /**
     * @return string
     */
    public function getUserId() : ?string
	{
		return $this->user_id;
	}

    /**
     * @param string $user_id Close.com user id message is associated with ("user_???")
     *
     * @throws InvalidArgumentException
     */
    public function setUserId(string $user_id) : void
    {
        if (substr($user_id, 0, 5) !== 'user_')
        {
            throw new InvalidArgumentException("Invalid user_id [{$user_id}]");
        }

        $this->user_id = $user_id;
    }

    /**
	 * @return string
	 */
	public function getLeadId() : string
	{
		return $this->lead_id;
	}

    /**
     * @param string $lead_id Close.com lead to associate message with ("lead_???")
     *
     * @throws InvalidArgumentException
     */
    public function setLeadId(string $lead_id) : void
    {
        if (substr($lead_id, 0, 5) !== 'lead_')
        {
            throw new InvalidArgumentException("Invalid lead_id [{$lead_id}]");
        }

        $this->lead_id = $lead_id;
    }

    /**
	 * @return string
	 */
	public function getDirection() : string
	{
		return $this->direction;
	}

    /**
     * @param string $direction
     *
     * @throws InvalidArgumentException
     */
    public function setDirection(string $direction) : void
    {
        if (!in_array($direction, self::$directions))
        {
            throw new InvalidArgumentException("Invalid direction [{$direction}]");
        }

        $this->direction = $direction;
    }

    /**
	 * @return string
	 */
	public function getCreatedBy() : ?string
	{
		return $this->created_by;
	}

    /**
     * @param string $created_by Close.com user id message was created by ("user_???")
     *
     * @throws InvalidArgumentException
     */
    public function setCreatedBy(string $created_by) : void
    {
        if (substr($created_by, 0, 5) !== 'user_')
        {
            throw new InvalidArgumentException("Invalid created_by user: [{$created_by}]");
        }

        $this->created_by = $created_by;
    }

    /**
	 * @return string
	 */
	public function getCreatedByName() : ?string
	{
		return $this->created_by_name;
	}

    /**
     * @param string $created_by_name name of user message created by
     */
    public function setCreatedByName($created_by_name)
    {
        $this->created_by_name = $created_by_name;
    }

    /**
	 * @return Carbon
	 */
	public function getDateCreated() : ?Carbon
	{
		return $this->date_created;
	}

    /**
     * @return string
     */
    public function getDateCreatedAtom() : ?string
    {
        return $this->date_created ? $this->date_created->toAtomString() : null;
    }

    /**
     * @param Carbon $date_created date message was created
     */
    public function setDateCreated(Carbon $date_created) : void
    {
        $this->date_created = $date_created;
    }

    /**
	 * @return string
	 */
	public function getSubject() : ?string
	{
		return $this->subject;
	}

    /**
     * @param string $subject
     */
    public function setSubject(string $subject) : void
    {
        $this->subject = $subject;
    }

    /**
	 * @return string
	 */
	public function getSender() : ?string
	{
		return $this->sender ? strval($this->sender) : null;
	}

    /**
     * @param EmailAddress $sender sender email address of the message
     */
    public function setSender(EmailAddress $sender) : void
    {
        $this->sender = $sender;
    }

    /**
	 * @return array
	 */
	public function getTo() : array
	{
		return array_map('strval', $this->to);
	}

    /**
     * @param EmailAddress $to array of EmailAddress email sent to
     */
    public function addTo(EmailAddress $to) : void
    {
        $this->to[] = $to;
    }

    /**
	 * @return array
	 */
	public function getBcc() : array
	{
		return array_map('strval', $this->bcc);
	}

    /**
     * @param EmailAddress $bcc array of EmailAddress email Bcc'd to
     */
    public function addBcc(EmailAddress $bcc) : void
    {
        $this->bcc[] = $bcc;
    }

    /**
	 * @return mixed
	 */
	public function getCc() : array
	{
		return array_map('strval', $this->cc);
	}

    /**
     * @param EmailAddress $cc email Cc'd to
     */
    public function addCc(EmailAddress $cc) : void
    {
        $this->cc[] = $cc;
    }

    /**
	 * @return string
	 */
	public function getStatus() : string
	{
		return $this->status;
	}

    /**
     * @param string $status ['inbox', 'draft', 'scheduled', 'outbox', 'sent'] - setting status to "outbox" will send an email!
     *
     * @throws InvalidArgumentException
     */
    public function setStatus(string $status) : void
    {
        if (!in_array($status, self::$statuses))
        {
            throw new InvalidArgumentException("Invalid status [{$status}]");
        }

        $this->status = $status;
    }

    /**
	 * @return string
	 */
	public function getBodyText() : ?string
	{
		return $this->body_text;
	}

    /**
     * @param string $body_text text representation of email
     */
    public function setBodyText(string $body_text) : void
    {
        $this->body_text = $body_text;
    }

    /**
     * @return string html representation of email
     */
    public function getBodyHtml() : ?string
    {
        return $this->body_html;
    }

    /**
     * @param string $body_html
     */
    public function setBodyHtml(string $body_html) : void
    {
        $this->body_html = $body_html;
    }

    /**
	 * @return string
	 */
	public function getTemplateId() : ?string
	{
		return $this->template_id;
	}

    /**
     * @param string $template_id template id to send email with instead of body ("tmpl_???")
     *
     * @throws InvalidArgumentException
     */
    public function setTemplateId(string $template_id) : void
    {
        if (substr($template_id, 0, 5) !== 'tmpl_')
        {
            throw new InvalidArgumentException("Invalid template_id [{$template_id}]");
        }

        $this->template_id = $template_id;
    }

    public function toArray() : array
	{
        $to = $this->getTo();
        $bcc = $this->getBcc();
        $cc = $this->getCc();

	    $email = [
	        'lead_id' => $this->getLeadId(),
            'direction' => $this->getDirection(),
            'status' => $this->getStatus(),
            'contact_id' => $this->getContactId(),
            'user_id' => $this->getUserId(),
            'created_by' => $this->getCreatedBy(),
            'created_by_name' => $this->getCreatedByName(),
            'date_created' => $this->getDateCreatedAtom(),
            'subject' => $this->getSubject(),
            'sender' => $this->getSender(),
            'to' => !empty($to) ? $to : null,
            'bcc' => !empty($bcc) ? $bcc : null,
            'cc' => !empty($cc) ? $cc : null,
            'body_html' => $this->getBodyHtml(),
            'body_text' => $this->getBodyText(),
            'template_id' => $this->getTemplateId(),
        ];

        return $this->filterNullValues($email);
	}
}
