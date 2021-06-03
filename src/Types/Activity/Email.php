<?php namespace Close\Types\Activity;

use Carbon\Carbon;
use Close\Arrayable;
use Close\Types\EmailAddress;
use Close\Exception\InvalidArgumentException;

class Email implements Arrayable
{
	static $directions = ['incoming', 'outgoing'];

	static $statuses = ['draft', 'inbox', 'outbox', 'sent'];

    private $contact_id;

	private $user_id;

	private $lead_id;

	private $direction;

	private $created_by;

    private $created_by_name;

	/** @var Carbon date created */
	private $date_created;

	private $subject;

    private $sender;

	/** @var array EmailAddress */
	private $to = [];

	/** @var array EmailAddress */
	private $bcc = [];

	/** @var array EmailAddress */
	private $cc = [];

    private $status;

    private $body_text;

	private $body_html;

//	$private attachments;

	private $template_id;

	/**
	 * @param $contact_id 	optional - Close.io contact id to associate message with ("cont_???")
	 * @param $user_id 		optional - Close.io user id message is associated with ("user_???")
	 * @param $lead_id		required - Close.io lead to associate message with ("lead_???")
	 * @param $direction	required - "incoming" or "outgoing"
	 * @param $created_by	optional - Close.io user id message was created by ("user_???")
	 * @param $created_by_name	optional - name of user message created by
	 * @param Carbon $date_created	required - date message was created
	 * @param $subject		required - subject of the message
	 * @param EmailAddress $sender	required - sender email address of the message
	 * @param array $to		optional - array of EmailAddress email sent to
	 * @param array $bcc	optional - array of EmailAddress email Bcc'd to
	 * @param array $cc		optional - array of EmailAddress email Cc'd to
	 * @param $status		required - "draft", "inbox", "outbox" or "sent". Setting status to "outbox" will send an email!
	 * @param $body_text	required - text representation of email
	 * @param $body_html	required - html representation of email
	 * @param $template_id	optional - template id to send email with instead of body ("tmpl_???")
	 */
	function __construct(
		$contact_id,
		$user_id,
		$lead_id,
		$direction,
		$created_by,
		$created_by_name,
		Carbon $date_created,
		$subject,
		EmailAddress $sender,
		array $to,
		array $bcc,
		array $cc,
		$status,
		$body_text,
		$body_html,
		$template_id = null
	)
	{
		if (!empty($contact_id) AND substr($contact_id, 0, 5) !== 'cont_')
		{
			throw new InvalidArgumentException("Invalid contact_id passed to Email activity constructor: [{$contact_id}]");
		}

		if (!empty($user_id) AND substr($user_id, 0, 5) !== 'user_')
		{
			throw new InvalidArgumentException("Invalid user_id passed to Email activity constructor: [{$user_id}]");
		}

		if (!empty($lead_id) AND substr($lead_id, 0, 5) !== 'lead_')
		{
			throw new InvalidArgumentException("Invalid lead_id passed to Email activity constructor: [{$lead_id}]");
		}

		if (!in_array($direction, self::$directions))
		{
			throw new InvalidArgumentException("Invalid direction passed to Email activity constructor: [{$direction}]");
		}

		if (!empty($created_by) AND substr($created_by, 0, 5) !== 'user_')
		{
			throw new InvalidArgumentException("Invalid created_by passed to Email activity constructor: [{$created_by}]");
		}

		foreach ($to as $email)
		{
			if (!is_object($email) OR get_class($email) != EmailAddress::class)
			{
				throw new InvalidArgumentException("Invalid Email object passed to Email activity constructor (to): " . gettype($email));
			}
		}

		foreach ($bcc as $email)
		{
			if (!is_object($email) OR get_class($email) != EmailAddress::class)
			{
				throw new InvalidArgumentException("Invalid Email object passed to Email activity constructor (bcc): " . gettype($email));
			}
		}

		foreach ($cc as $email)
		{
			if (!is_object($email) OR get_class($email) != EmailAddress::class)
			{
				throw new InvalidArgumentException("Invalid Email object passed to Email activity constructor (cc): " . gettype($email));
			}
		}

		if (!in_array($status, self::$statuses))
		{
			throw new InvalidArgumentException("Invalid status passed to Email activity constructor: [{$status}]");
		}

		if (!empty($template_id) AND substr($template_id, 0, 5) !== 'tmpl_')
		{
			throw new InvalidArgumentException("Invalid template_id passed to Email activity constructor: [{$template_id}]");
		}

		$this->contact_id = $contact_id;
		$this->user_id = $user_id;
		$this->lead_id = $lead_id;
		$this->direction = $direction;
		$this->created_by = $created_by;
		$this->created_by_name = $created_by_name;
		$this->date_created = $date_created;
		$this->subject = $subject;
		$this->sender = $sender;
		$this->to = $to;
		$this->bcc = $bcc;
		$this->cc = $cc;
		$this->status = $status;
		$this->body_text = $body_text;
		$this->body_html = $body_html;
		$this->template_id = $template_id;
	}

	public static function logOutboundEmail($lead_id, $date_created, $subject, $sender, array $to = [], array $bcc = [], array $cc = [], $body_text = '', $body_html = '')
	{
		$sender_email = new EmailAddress($sender);
		$to_array = array_map([EmailAddress::class, 'createEmailAddress'], $to);
		$bcc_array = array_map([EmailAddress::class, 'createEmailAddress'], $bcc);
		$cc_array = array_map([EmailAddress::class, 'createEmailAddress'], $cc);

		return new self(null, null, $lead_id, 'outgoing', null, null, $date_created, $subject, $sender_email, $to_array, $bcc_array, $cc_array, 'sent', $body_text, $body_html);
	}

	public static function logInboundEmail($lead_id, $date_created, $subject, $sender, array $to = [], array $bcc = [], array $cc = [], $body_text = '', $body_html = '')
	{
		$sender_email = new EmailAddress($sender);
		$to_array = array_map([EmailAddress::class, 'createEmailAddress'], $to);
		$bcc_array = array_map([EmailAddress::class, 'createEmailAddress'], $bcc);
		$cc_array = array_map([EmailAddress::class, 'createEmailAddress'], $cc);

		return new self(null, null, $lead_id, 'incoming', null, null, $date_created, $subject, $sender_email, $to_array, $bcc_array, $cc_array, 'inbox', $body_text, $body_html);
	}

	/**
	 * @return mixed
	 */
	public function getContactId()
	{
		return $this->contact_id;
	}

	public function getUserId()
	{
		return $this->user_id;
	}

	/**
	 * @return mixed
	 */
	public function getLeadId()
	{
		return $this->lead_id;
	}

	/**
	 * @return mixed
	 */
	public function getDirection()
	{
		return $this->direction;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedBy()
	{
		return $this->created_by;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedByName()
	{
		return $this->created_by_name;
	}

	/**
	 * @return Carbon
	 */
	public function getDateCreated()
	{
		return $this->date_created;
	}

	public function getDateCreatedAtom()
	{
		return $this->date_created ? $this->date_created->toAtomString() : null;
	}

	/**
	 * @return mixed
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @return EmailAddress
	 */
	public function getSender()
	{
		return $this->sender->getFull();
	}

	/**
	 * @return array
	 */
	public function getTo()
	{
//		return array_map(function ($a) { return $a->getEmail(); }, $this->to);
		return array_map([__CLASS__, 'getEmail'], $this->to);
	}

	/**
	 * @return array
	 */
	public function getBcc()
	{
		return array_map([__CLASS__, 'getEmail'], $this->bcc);
	}

	/**
	 * @return mixed
	 */
	public function getCc()
	{
		return array_map([__CLASS__, 'getEmail'], $this->cc);;
	}

	/**
	 * @return mixed
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @return mixed
	 */
	public function getBodyText()
	{
		return $this->body_text;
	}

	/**
	 * @return mixed
	 */
	public function getBodyHtml()
	{
		return $this->body_html;
	}

	/**
	 * @return mixed
	 */
	public function getTemplateId()
	{
		return $this->template_id;
	}

	protected static function getEmail(EmailAddress $email)
	{
		return $email->getFull();
	}

	public function toArray()
	{
		return [
			"contact_id" => $this->getContactId(),
			"user_id" => $this->getUserId(),
			"lead_id" => $this->getLeadId(),
			"direction" => $this->getDirection(),
			"created_by" => $this->getCreatedBy(),
			"created_by_name" => $this->getCreatedByName(),
			"date_created" => $this->getDateCreatedAtom(),
			"subject" => $this->getSubject(),
			"sender" => $this->getSender(),
			"to" => $this->getTo(),
			"bcc" => $this->getBcc(),
			"cc" => $this->getCc(),
			"status" => $this->getStatus(),
			"body_text" => $this->getBodyText(),
			"body_html" => $this->getBodyHtml(),
			"template_id" => $this->getTemplateId(),
		];
	}
}
