<?php

namespace App\Traits;

trait HttpResponses{
    protected function success($data,$message=null,$code=200){
        return response()->json([
            'status'=>'Rerquest was succesful',
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }

    protected function error($data,$message=null,$code){
        return response()->json([
            'status'=>'Error has occurred.....',
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }

public static function send($tokens, $title, $body)
    {
    $SERVER_API_KEY = 'AAAAZnii67A:APA91bFM0DpV73x5hqh-YxN52tvhkyChqUE2VGZgOngAZ_-lYibupn3upH2Yu1_VF7vFxM78XiMGsdY_CH9sClKHA2UmkAbXQwVB19Mcg8kTJqOHSfh_mDc6UjFGO4gqmtSubsrjHwxk';

    $data = [
        "to" => $tokens,
        "notification" => [
            "title" => $title,
            "body" => $body,
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
    //return $response;
    }
}
