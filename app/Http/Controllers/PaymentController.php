<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function initialisePaystack(){
        $curl = curl_init();

        $email = "onyia314@email.com";
        $amount = 30000;  //the amount in kobo. This value is actually NGN 300

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount'=>$amount,
            'email'=>$email,
        ]),
        CURLOPT_HTTPHEADER => [
            "authorization: Bearer sk_test_b6c0b49254032fd6dd4af7595629c42e1cf760d1", //replace this with your own test key
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
        // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response , true);

        if(!$tranx['status']){
        //print_r('API returned error: ' . $tranx['message']);
        return back()->with('apiError');
        }

        // redirect to page so User can pay
    
        header('Location: ' . $tranx['data']['authorization_url']);
    }

    public function verifyPayment(){
        
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if(!$reference){
        die('No reference supplied');
        }

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization:  Bearer sk_test_b6c0b49254032fd6dd4af7595629c42e1cf760d1",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
        die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response);

        if(!$tranx->status){
        // there was an error from the API
        die('API returned error: ' . $tranx->message);
        }

        if('success' == $tranx->data->status){
        // transaction was successful...
        // please check other things like whether you already gave value for this ref
        // if the email matches the customer who owns the product etc
        // Give value

        dd('payment successful');
        }
    }


}
