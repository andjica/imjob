<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompanyPendingActivationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.company-pending-activation') // Blade view for the email
            ->subject('Company Registration Confirmation') // Subject of the email
            ->to($this->company->email) // Send to the company owner
            ->cc(env('ADMIN_EMAIL')) // CC to the admin (configured in .env file)
            ->with([
                'company' => $this->company, // Pass the company data to the email view
            ]);
    }
}
