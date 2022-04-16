<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Notifications\contactCreated;
use Throwable;
use AWS;
use Aws\Exception\AwsException;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
      $data = $request->validated();

      try {
        $Contact = new Contact();
        $Contact->fill($data)->save();
        //NOTE: send SMS linked to a model, this can be useful for sending messages after user creation
        // $Contact->notify(new contactCreated($Contact));

        //NOTE: send SMS as a step after saving the contact
        $sms = AWS::createClient('sns');

        $sms->publish([
          'Message' => 'New contact created: '.$Contact->first_name.' '.$Contact->last_name,
          'TopicArn' => 'arn:aws:sns:us-east-2:797294200331:Test',
          'MessageAttributes' => [
            'AWS.SNS.SMS.SMSType' => [
              'DataType' => 'String',
              'StringValue' => 'Promotional'
            ]
          ]
        ]);

        return [
          'success' => true,
          'contact' => $Contact,
        ];
      } catch (Throwable $th) {
        return [
          'success' => false,
          'message' =>  'Error'
        ];
      }
      catch (AwsException $e) {
        // output error message if fails
        error_log($e->getMessage());
      } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
