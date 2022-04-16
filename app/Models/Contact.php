<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
  use HasFactory;
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'phone_number',
    'project_detail'
  ];

  /**
   * Return the SMS notification routing information.
   *
   * @param \Illuminate\Notifications\Notification|null $notification
   *
   * @return mixed
   */
  public function routeNotificationForSms(?Notification $notication = null)
  {
    return '+50376351839';
  }
}
