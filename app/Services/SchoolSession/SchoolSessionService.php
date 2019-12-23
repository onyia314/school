<?php
namespace App\Services\SchoolSession;

use App\SchoolSession;

class SchoolSessionService{
    /**
     *  not that more than one sessions can not be current the same time
     */
    public static function currentSession(){
       return SchoolSession::where('current' , 1)->first();
    }
    public static function setSessionToCurrent($session_id){
        SchoolSession::where('id' , $session_id)->update(['current' => 1 ]);
    }

    public static function unsetSessionFromCurrent($session_id){
        SchoolSession::where('id' , $session_id)->update(['current' => 0 ]);
    }

}