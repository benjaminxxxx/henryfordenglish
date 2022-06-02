<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Twilio\Rest\Client;

class WspSend extends Component
{
    public function render()
    {
        $sid    = env( 'TWILIO_SID' );
        $token  = env( 'TWILIO_TOKEN' );
       //$client = new Client( $sid, $token );

        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                        ->create("whatsapp:+51986103337", // to
                                [
                                    "from" => "whatsapp:+51993187237",
                                    "body" => "Hi, Joe! Thanks for placing an order with us. We’ll let you know once your order has been processed and delivered. Your order number is O12235234"
                                ]
                        );

        dd($message->sid);
        return view('livewire.wsp-send');
    }
}
