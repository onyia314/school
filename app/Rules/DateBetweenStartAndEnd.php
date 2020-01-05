<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Semester;
use DateTime;

class DateBetweenStartAndEnd implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    /**
     * this makes sure that there is no conflict in start_date and end_date in semesters
     */
    public function passes($attribute, $value)
    {   
        $value = new DateTime($value);
        $value = $value->format('Y-m-d H:i:s');
        $semesters = Semester::where([ 
            ['start_date', '<=' ,  $value],
            ['end_date' , '>=' , $value],
        ])->count();

        return $semesters > 0 ? false : true ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'please check :attribute, it seems you are having date conflicts with :attribute of other semesters';
    }
}
