<?php
/**
 * @author Louis Figes W21017657
 * @generated Github Copilot was used during the creation of this code.
 * This endpoint requests an email to be resent to the user with a new OTP.
 */
namespace App\Endpoints\Users\UserSubEndpoints;

use Core\Endpoint\SubEndpoint\SubEndpoint;

class ResendEmail extends SubEndpoint
{
    public function __construct() 
    {
        parent::__construct('GET', 'resend-otp');
        $this->setRequiresAuth(true);
    }

    public function process($request)
    {
        parent::process($request);
        $this->getUser()->get();
        $this->getUser()->sendNewEmailOTP();
        
    }
}