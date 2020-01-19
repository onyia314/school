<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * student_sections table keep track of both current and previous sections of a student
 * per academic section
 *
 */
class StudentSection extends Model
{
    protected $guarded = [];
}
