<?php

namespace App\Channels;

use Aws\Sns\SnsClient;
use App\Channels\Messages\SmsMessage;
use Illuminate\Notifications\Notification;

class SmsChannel
{
  /**
   * The SNS client instance.
   *
   * @var \Aws\Sns\SnsClient
   */
  protected $sns;

  public function __construct(SnsClient $sns)
  {
    $this->sns = $sns;
  }

  public function send($notifiable, Notification $notification)
  {
    if (!$to = $notifiable->routeNotificationFor('sms', $notification)) {
      return;
    }

    //NOTE: If we need to send a message to a single phone number, we can use the following:
    // if (!$result = $this->sns->checkIfPhoneNumberIsOptedOut(['phoneNumber' => $to])) {
    //   return;
    // }

    // if ($result['isOptedOut']) {
    //   return;
    // }

    $message = $notification->toSms($notifiable);

    if (is_string($message)) {
      $message = new SmsMessage($message);
    }

    return $this->sns->publish([
      'Message' => $message->content,
      //NOTE: If we need to send a message to a single phone number, we can use the following:
      // 'PhoneNumber' => $to,
      'TopicArn' => $to,
    ]);
  }
}