<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Aws\Sns\SnsClient;
use Aws\Credentials\Credentials;
use App\Channels\SmsChannel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      Notification::resolved(function(ChannelManager $service) {
        $service->extend('sms', function($app) {
          return new SmsChannel(
            new SnsClient([
              'credentials' => new Credentials(
                config('services.sns.key'),
                config('services.sns.secret')
              ),
              'region' => config('services.sns.region'),
              'version' => '2010-03-31',
            ])
          );
        });
      });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
