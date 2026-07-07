<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Courierapi;
use App\Models\PaymentGateway;
use App\Models\SmsGateway;
use Illuminate\Http\Request;
use Toastr;

class ApiIntegrationController extends Controller
{
    public function pay_manage()
    {
        $bkash = PaymentGateway::where('type', '=', 'bkash')->first();
        $shurjopay = PaymentGateway::where('type', '=', 'shurjopay')->first();

        return view('backEnd.apiintegration.pay_manage', compact('bkash', 'shurjopay'));
    }

    public function pay_update(Request $request)
    {
        $update_data = PaymentGateway::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');

        return redirect()->back();
    }

    public function sms_manage()
    {
        $sms = SmsGateway::first();

        return view('backEnd.apiintegration.sms_manage', compact('sms'));
    }

    public function sms_update(Request $request)
    {
        $update_data = SmsGateway::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        $input['order'] = $request->order ? 1 : 0;
        $input['forget_pass'] = $request->forget_pass ? 1 : 0;
        $input['password_g'] = $request->password_g ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');

        return redirect()->back();
    }

    public function courier_manage()
    {
        $steadfast = Courierapi::where('type', '=', 'steadfast')->first();
        $pathao = Courierapi::where('type', '=', 'pathao')->first();

        return view('backEnd.apiintegration.courier_manage', compact('steadfast', 'pathao'));
    }

    public function courier_update(Request $request)
    {
        $update_data = Courierapi::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');

        return redirect()->back();
    }

    public function fraudcheckapi()
    {
        return view('backEnd.apiintegration.fraudcheckapi');
    }

    public function fraudcheckapi_update(Request $request)
    {
        $update_data = FraudCheckapi::find($request->id);
        $input = $request->all();
        $input['status'] = $request->status ? 1 : 0;
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');

        return redirect()->back();
    }

    public function check_balance()
    {
        $courier_info = Courierapi::where(['status' => 1, 'type' => 'steadfast'])->first();
        if ($courier_info) {
            $client = new \GuzzleHttp\Client();
            try {
                $baseUrl = preg_replace('/\/create_order\/?$/', '', $courier_info->url);
                $baseUrl = rtrim($baseUrl, '/');
                $balanceUrl = $baseUrl.'/get_balance';

                $response = $client->get($balanceUrl, [
                    'headers' => [
                        'Api-Key' => $courier_info->api_key,
                        'Secret-Key' => $courier_info->secret_key,
                        'Content-Type' => 'application/json',
                    ],
                ]);

                $responseData = json_decode($response->getBody(), true);

                if (isset($responseData['status']) && $responseData['status'] == 200) {
                    return response()->json([
                        'success' => true,
                        'balance' => $responseData['current_balance'],
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch balance from Steadfast.',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'API Error: '.$e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Steadfast Courier API info not configured or inactive.',
        ]);
    }
}
