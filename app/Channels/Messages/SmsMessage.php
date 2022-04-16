<?php

namespace App\Channels\Messages;

class SmsMessage
{
    /**
     * The message to be sent.
     *
     * @var string
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function content(string $content)
    {
        $this->content = trim($content);

        return $this;
    }
}