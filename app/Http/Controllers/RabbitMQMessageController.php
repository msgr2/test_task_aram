<?php

namespace App\Http\Controllers;

use App\Services\ClickhouseService;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Str;

class RabbitMQMessageController extends Controller
{
    public function index(Request $request)
    {
        $names = ["Jahir", "Rajarshi"];
        $mqService = new \App\Services\RabbitMQService();
        $sms_campaign_id = Str::uuid();
        $receiverDetails = [
            /**
             * Where to send a text message (your cell phone?), 
             * For trial period ,currently it's only supported registered number
             * This number is used for demo purpose
             */
            'phone' => '+911234567890'
        ];
        foreach ($names as $name) {
            $mqService->publish($name);
            /** 
             * Clickhouse
             */
            $insertClicks = [];
            $insertClicks[] = [
                'team_id' => Str::uuid(),
                'updated_datetime' => date('Y-m-d H:i:s'),
                'sms_campaign_id'  => $sms_campaign_id,
                'sms_campaign_send_id' => Str::uuid(),
                'segment_id' => Str::uuid(),
                'contact_id' => Str::uuid(),
                'phone_normalized' => '1234567890',
                'network_id' => '1234',
                'country_id' => 91,
                'foreign_id' => 91,
                'fail_reason' => 'N/A',
                'is_sent' => 1,
                'is_clicked' => 1,
                'is_lead' => 1,
                'is_sale' => 1,
                'conversion_profit' => 0,
                'is_unsubscribed' =>  0,
                'domain_id' => Str::uuid(),
                'shortened_url' => 'localhost',
                'offer_id' => 'Campaign offer',
                'campaign_text_id' => Str::uuid(),
                'final_text' => Str::random(10),
                'text_parts' => 5,
                'sms_routing_plan_id' =>  Str::uuid(),
                'sms_routing_plan_rule_id' => Str::uuid(),
                'sms_routing_route_id' => Str::uuid(),
                'sms_rule_selected_data' => null,
                'sender_id_id' => Str::uuid(),
                'sms_parts' => 5,
                'dlr_code' => 7,
                'dlr_str'  => null,
                'cost_platform_profit' => '12.02',
                'cost_platform_cost' => '122.52',
                'cost_user_vendor_cost' => '150.54',
                'click_meta' => null,
                'sent_at' => date('Y-m-d H:i:s'),
                'time_clicked' => date('Y-m-d H:i:s'),
                'meta' => 'Test campaign'
            ];
            ClickhouseService::getClient()->insertAssocBulk('msgr.sms_sendlogs', $insertClicks);
            /**
             * Twilio
             */
            // Your Account SID and Auth Token from twilio.com/console
            $account_sid = env('TWILIO_SID');
            $auth_token = env('TWILIO_AUTH_TOKEN');
            // A Twilio number you own with SMS capabilities
            $twilio_number = env('TWILIO_NUMBER');

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $receiverDetails['phone'],
                array(
                    'from' => $twilio_number,
                    'body' => 'Welcome to the Twilio'
                )
            );
        }
        return 'Successfully message sent';
    }
}
