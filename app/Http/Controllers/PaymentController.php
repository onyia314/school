<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Fee;
use App\Section;
use App\Semester;
use App\Payment;
use App\Services\StudentSection\StudentSectionService;

class PaymentController extends Controller
{  

    public function index($fee_id){
        $fee = Fee::with([
            'section' => function($query){ $query->with('schoolClass'); },
            'semester' => function($query){ $query->with('schoolsession'); },
            ])->findOrFail($fee_id);
        $payments = Payment::with(['student' , 'fee' ])->where('fee_id' , $fee->id )->paginate(50);
        return view('payments.index', ['payments' => $payments , 'fee' => $fee]);
    }
    
    private function isFeeForSection($fee_id , $section_id , $semester_id){
        return Fee::where([
            'id' => $fee_id , 
            'section_id' => $section_id , 
            'semester_id' => $semester_id,
            ])->exists();
    }

    private function studentHasPaidForFee( $fee_id , $student_id){
        return Payment::where(['fee_id' => $fee_id , 'student_id' => $student_id, ])->exists();
    }

    private function isValueGivenToRef($reference){
        return Payment::where('reference', $reference)->exists();
    }

    private function validateParam($request){
        return $request->validate([
            'fee_id' => 'required|integer|exists:fees,id',
            'section_id' => 'required|integer|exists:sections,id',
            'semester_id' => 'required|integer|exists:semesters,id',
        ]);
    }

    public function initialisePaystack(Request $request){
        
        $data = $this->validateParam($request);

        $fee = Fee::find($data['fee_id']);
        $semester = Semester::with('schoolSession')->find($data['semester_id']);
        $section = Section::with('schoolClass')->find($data['section_id']);
    
        if( !$this->isFeeForSection($fee->id , $section->id , $semester->id) ){
            abort(403 , 'fee not for section in the selected semester');
        }

        if( !StudentSectionService::hasStudentBeenInSection(
            Auth::user()->id , $section->id , $semester->id) 
        )
        {
           abort(403 , 'you were never in this section in the selected semester');
        }

        if( $this->studentHasPaidForFee( $data['fee_id'] , Auth::user()->id ) ){
            return back()->with('feeAlreadyPaid');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'amount'=> Fee::find($data['fee_id'])->amount * 100, //amount must be in kobo
            'email'=> Auth::user()->email,
            'metadata' => json_encode([
                'fee_id' => $fee->id,
                'section_id' => $section->id,
                'class_id' => $section->schoolClass->id,
                'semester_id' => $semester->id,
                'session_id' =>  $semester->schoolSession->id,
                'custom_fields' => [
                    [
                        'display_name' => "name of student",
                        'variable_name' => "name",
                        'value' => Auth::user()->name,
                    ],
                    [
                        'display_name' => "fee",
                        'variable_name' => "fee_name",
                        'value' => $fee->fee_name,
                    ],
                    [
                        'display_name' => "class",
                        'variable_name' => "class_name",
                        'value' => $section->schoolClass->class_name .' ' .$section->schoolClass->group,
                    ],
                    [
                        'display_name' => "section",
                        'variable_name' => "section_name",
                        'value' => $section->section_name,
                    ],
                    [
                        'display_name' => "session",
                        'variable_name' => "session_name",
                        'value' => $semester->schoolSession->session_name,
                    ],
                    [
                        'display_name' => "semester",
                        'variable_name' => "semester_name",
                        'value' => $semester->semester_name,
                    ],
                ]
            ]),
        ]),
        CURLOPT_HTTPHEADER => [
            "authorization: Bearer " .config('services.paystack.key'),
            "content-type: application/json",
            "cache-control: no-cache"
        ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err){
            // there was an error contacting the Paystack API
            Log::info('Curl returned error: ' . $err);
            return back()->with('apiError');
        }

        $tranx = json_decode($response , true);

        if(!$tranx['status']){
            Log::info('API returned error: ' . $tranx['message']);
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
            "authorization:  Bearer " .config('services.paystack.key'),
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

            // value might have been given through  webhook
            if( $this->isValueGivenToRef($tranx->data->reference) ){
                return redirect()->route('view.fee' , [ 
                    'section_id' => $tranx->data->metadata->section_id,
                    'semester_id' => $tranx->data->metadata->semester_id,
                    ]
                )->with('DbPaymentSuccess');
            }

            try {

                Payment::create([
                    'student_id' => Auth::user()->id,
                    'fee_id' => $tranx->data->metadata->fee_id,
                    'section_id' => $tranx->data->metadata->section_id,
                    'semester_id' => $tranx->data->metadata->semester_id,
                    'session_id' => $tranx->data->metadata->session_id,
                    'class_id' => $tranx->data->metadata->class_id,
                    'amount_paid' => $tranx->data->amount / 100, // convert kobo to naira
                    'payment_mode' => 'online',
                    'reference' => $tranx->data->reference,
                ]);

                return redirect()->route('view.fee' , [ 
                    'section_id' => $tranx->data->metadata->section_id,
                    'semester_id' => $tranx->data->metadata->semester_id,
                    ]
                )->with('DbPaymentSuccess');

            } catch (\Exception $e) {
                Log::info('payment has been made but we have error inserting into the database : ' .$e->getMessage() );
                return redirect()->route('view.fee' , [ 
                    'section_id' => $tranx->data->metadata->section_id,
                    'semester_id' => $tranx->data->metadata->semester_id,
                    ]
                )->with('DbPaymentError');
            }
            
   
        }//if success ends
    }//verify payment ends


}
