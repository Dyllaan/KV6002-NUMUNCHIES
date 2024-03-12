<?php
/**
 * @author Louis Figes W21017657
 * This class is responsible for handling the PUT request to the /Users endpoint
 * I put this in its own class just to reduce clutter in the user endpoint class and for increases abstraction
 */
namespace App\Endpoints\UserSubSystem\UserSubEndpoints;

use Core\Endpoint\SubEndpoint\SubEndpoint;
use App\Classes\UserSubSystem\User;

class EditUser extends SubEndpoint
{

    public function __construct() 
    {
        parent::__construct('PUT', 'edit');
        $this->getAttributes()->addAllowedStrings(['name', 'email', 'password']);
    }

    public function process($request)
    {
        parent::process($request);
        $changeFlag = false;
        
        $attributes = $request->getAttributes();
        if($attributes === null || empty($attributes)) {
            $this->setResponse(400, ['message' => 'No attributes to edit']);
        }
        if($request->hasAttribute('name')) {
            $changeFlag = true;
            $this->getUser()->setName($request->getAttribute('name'));
        } 
        if($request->hasAttribute('email')) {
            $changeFlag = true;
            $this->getUser()->setEmail($request->getAttribute('email'));
        } 
        if($request->hasAttribute('password')) {
            $changeFlag = true;
            $this->getUser()->setPassword($request->getAttribute('password'));
        }

        if($changeFlag) {
            $this->getUser()->update();
        } else {
            $this->setResponse(400, ['message' => 'No attributes to edit']);
        }

        $this->setResponse(201, "Profile updated", $this->getUser()->toArray()); 
    }
}