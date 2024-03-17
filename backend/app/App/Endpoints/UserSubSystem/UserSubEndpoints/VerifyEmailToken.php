<?php
/**
 * @author Louis Figes W21017657
 */
namespace App\Endpoints\UserSubSystem\UserSubEndpoints;

use Core\Endpoint\SubEndpoint\SubEndpoint;

class VerifyEmailToken extends SubEndpoint
{
    public function __construct() 
    {
        parent::__construct('POST', 'verify-email-token');
        $this->setRequiresAuth(true);
        $this->getAttributes()->addRequiredStrings(['token', 'type']);
    }

    public function process($request)
    {
        parent::process($request);


        /** 
         * Only allow supported verification types
        */
        $allowed = ['email_verification', 'password_reset', 'ip_verification'];
        if(!in_array($request->getAttribute('type'), $allowed)) {
            $this->setResponse(400, 'Invalid type');
            return;
        }

        $this->getUser()->get();
        if($this->getUser()->getEmailHandler()->verifyEmailToken($request->getAttribute('token'), $request->getAttribute('type'))) {
            $this->setResponse(200, 'This token has been verified');
        } else {
            $this->setResponse(400, 'Unable to verify user');
        }
    }
}