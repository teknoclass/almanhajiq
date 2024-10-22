<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting;

class TeacherEvaluation extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $user;
    public $to_email;
    public $password;

    public function __construct($title, $user, $to_email , $password = null)
    {
        $this->title = $title;
        $this->user = $user;
        $this->to_email = $to_email;
        $this->password = $password;
    }

    public function build()
    {
        $data['title']       = getSeting('title_ar') . " ( ". $this->title . " )";
        $data['user']        = $this->user;
        $data['to_email']    = $this->to_email;
        $data['password']    = $this->password;
        $data['header_text'] = $this->title;
        $item                = new Setting();
        $data['settings']    = $item;

        return $this->from($item->valueOf('email'), $item->valueOf('title_ar'))->subject($this->title)->view('mail.teacher_accepted',$data);
        }
}
