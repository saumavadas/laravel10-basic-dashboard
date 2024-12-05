<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;


class SellerAuthController extends Controller
{
    public function registerSeller(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:15|unique:sellers',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otp = rand(100000, 999999);

        $seller = Seller::updateOrCreate(
            ['phone' => $request->phone],
            ['otp' => $otp]
        );

        $this->sendOtp($seller->phone, $otp);

        // Simulate sending OTP (Replace with actual SMS integration)
        \Log::info("OTP for {$seller->phone}: $otp");

        return response()->json(['message' => 'OTP sent to your phone.', 'seller_id' => $seller->id]);
    }

    public function verifySellerOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:sellers,id',
            'otp' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $seller = Seller::find($request->seller_id);

        if ($seller->otp !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 401);
        }

        $seller->otp_verified_at = now();
        $seller->otp = null;
        $seller->save();

        $token = $seller->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'OTP verified successfully.', 'token' => $token]);
    }

    private function sendOtp($phoneNumber, $otp)
    {
        $accountSid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $url = "https://api.twilio.com/2010-04-01/Accounts/$accountSid/Messages.json";
        $data = [
            'To' => $phoneNumber,        // Recipient's phone number
            'From' => $twilioNumber,       // Your Twilio phone number
            'Body' =>  env('TWILIO_MSG_TEXT'). ': '. $otp // SMS body
        ];


        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_USERPWD, "$accountSid:$authToken");
        
        $response = curl_exec($ch);

        if (curl_errno($ch)) 
        {
            \Log::info( 'Error:' . curl_error($ch));
        } 
        else
        {
            \Log::info( 'Response:' . $response);
        }
    }

}
