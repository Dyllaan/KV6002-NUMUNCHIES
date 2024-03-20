<?php
/**
 * @author Louis Figes W21017657
 * @generated Github Copilot was used during the creation of this code.
 * This endpoint requests an email to be resent to the user with a new OTP.
 */
namespace App\Endpoints\UserSubSystem\UserSubEndpoints;

use Core\Endpoint\SubEndpoint\SubEndpoint;

class ResendEmail extends SubEndpoint
{
    public function __construct() 
    {
        parent::__construct('GET', 'resend-email');
        $this->getAttributes()->addRequiredStrings(['type']);
        $this->getAttributes()->addAllowedStrings(['new_email', 'new_password']);
        $this->setRequiresAuth(true);
    }

    public function process($request)
    {
        parent::process($request);
        $type = $request->getAttribute('type');
        switch($type){
            case 'change_email':
                if(!$request->hasAttribute('new_email')){
                    $this->setResponse(400, 'New email required');
                    return;
                }
                $this->getUser()->getEmailHandler()->changeEmail($request->getAttribute('new_email'));
                $this->setResponse(200, 'Email sent', ['new_email'=> $request->getAttribute('new_email')]);
                break;
            case 'change_password':
                if(!$request->hasAttribute('new_password')){
                    $this->setResponse(400, 'Password required');
                    return;
                }
                if($this->getUser()->getEmailHandler()->sendEmailToken($type, null, $request->getAttribute('new_password'))){
                    $this->setResponse(200, 'Email sent');
                }
                break;
            case 'ip_verification':
            case 'email_verification':
                if($this->getUser()->getEmailHandler()->sendEmailToken($type)){
                    $this->setResponse(200, 'Email sent');
                }
                break;
            default:
                $this->setResponse(400, 'Invalid type', ['supported'=> ['ip_verification', 'email_verification', 'change_email']]);
                return;
                break;
        }
        $this->setResponse(400, 'Unable to send email');
    }
}