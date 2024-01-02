<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

$SERVER_API_KEY = "AAAAZnii67A:APA91bFM0DpV73x5hqh-YxN52tvhkyChqUE2VGZgOngAZ_-lYibupn3upH2Yu1_VF7vFxM78XiMGsdY_CH9sClKHA2UmkAbXQwVB19Mcg8kTJqOHSfh_mDc6UjFGO4gqmtSubsrjHwxk";

    $token_1 = 'dGL8U5uSR0yLLRKO0lzVUp:APA91bFRSUaTO4S_-T2pWNvedeEs9OdPKAklMMy9GtgOwDvUzQP-AG_mAoJJcYevag0yqZjP_dKI8izoKCO-H8h_bhQeLo2n_5wm6oQiGb0yqA-SkURKsiJECaJjQxySDk776cUEoJWU';

    $data = [

        "registration_ids" => [
            $token_1
        ],

        "notification" => [

            "title" => 'Welcome',

            "body" => 'Description',

            "sound"=> "default" // required for sound on ios

        ],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);

    dd($response);

});
