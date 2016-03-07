<?php

class ByteArray
{
    public $data;

    function __construct($data)
    {
        $this->data = $data;
    }
}

class RecordSet
{
    public $data;

    function __construct($data)
    {
        $this->data = $data;
    }
}

class PageableRecordSet
{
    public $data;
    public $limit;

    function __construct($data, $limit = 15)
    {
        $this->data = $data;
        $this->limit = $limit;
    }
}

class AcknowledgeMessage
{
    public $_explicitType = "flex.messaging.messages.AcknowledgeMessage";

    //public $_explicitType = "mx.messaging.messages.AcknowledgeMessage";

    function __construct($messageId = NULL, $clientId = NULL)
    {
        $this->messageId = $this->generateRandomId();
        $this->clientId = $clientId != NULL ? $clientId : $this->generateRandomId();
        $this->destination = null;
        $this->body = null;
        $this->timeToLive = 0;
        $this->timestamp = (int)(time() . '00');
        $this->headers = new stdClass();
        $this->correlationId = $messageId;
    }

    protected function generateRandomId()
    {
        // version 4 UUID
        return sprintf('%08X-%04X-%04X-%02X%02X-%012X', mt_rand(), mt_rand(0, 65535),
            bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '0100', 11, 4)), bindec(substr_replace(sprintf('%08b', mt_rand(0, 255)), '01', 5, 2)),
            mt_rand(0, 255), mt_rand());
    }
}

class CommandMessage
{
    public $_explicitType = 'flex.messaging.messages.CommandMessage';
    //public $_explicitType = 'mx.messaging.messages.CommandMessage';
}

class RemotingMessage
{
    public $_explicitType = 'flex.messaging.messages.RemotingMessage';
    //public $_explicitType = 'mx.messaging.messages.RemotingMessage';
}

class ErrorMessage
{
    public $_explicitType = "flex.messaging.messages.ErrorMessage";
    //public $_explicitType = "mx.messaging.messages.ErrorMessage";
    public $correlationId;
    public $faultCode;
    public $faultDetail;
    public $faultString;
}

