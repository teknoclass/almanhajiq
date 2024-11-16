<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class CourseSessionInstallment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'course_id',
        'course_session_id'
    ];

    function courseSession(){
        return $this->belongsTo(CourseSession::class,'course_session_id');
    }


    function getItems(){

        $prev = 0;
        $last = CourseSessionInstallment::where('id' , '<' , $this->id)->where('course_id',$this->course_id)->orderBy('course_session_id','desc')->first();

        if($last)$prev = $last->course_session_id;
        $sessions = CourseSession::where('id' , '>' , $prev)->where('id' , '<=' , $this->course_session_id)->where('course_id',$this->course_id)->select('title','id')->get();

        return $sessions;


    }

    function isPaid(){

        $exist  = StudentSessionInstallment::where('course_id' , $this->course_id)->where('student_id',auth('api')->id())->where('access_until_session_id' , '>=',$this->course_session_id)->exists();

        if($exist)return true;
        else return false;

    }

    function isCur(){

        $installment = $this->getCur();
        if($installment->id == $this->id)return true;
        else return false;



    }

    function getCur(){
        $last = StudentSessionInstallment::where('course_id',$this->course_id)->where('student_id',auth('api')->id())->orderBy('access_until_session_id', 'desc')->first();
        if($last)$id = $last->access_until_session_id;
        else $id = 0;
        $installment = CourseSessionInstallment::where('course_id',$this->course_id)->where('course_session_id','>',$id)->first();

        return $installment;
    }

    function isRemaining(){
        $installment = $this->getCur();
        if($this->id >= $installment->id)return true;
        else return false;
    }



}
