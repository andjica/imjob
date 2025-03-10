<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddEmployeesEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;
    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $request, Company $company)
    {
        $this->request = $request;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.company-add-employees')
        ->from($this->company->email)
        ->subject('Your new invitation') 
        ->to($this->request->get('email')) 
        ->cc(env('ADMIN_EMAIL'));
       
    }
}
