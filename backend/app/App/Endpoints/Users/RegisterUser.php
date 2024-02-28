<?php
/**
 * @author Louis Figes W21017657
 * This class is responsible for handling the POST request register to the /Users endpoint
 * I put this in its own class just to reduce clutter in the user endpoint class and for increases abstraction
 */
namespace App\Endpoints\Users;

use Core\Endpoint\SubEndpoint\SubEndpoint;
use App\Classes\User;

class RegisterUser extends SubEndpoint
{
    public function __construct() 
    {
        parent::__construct('POST', 'register');
        $this->getAttributes()->addRequiredStrings(['first_name', 'last_name', 'email', 'password']);
    }

    public function process($request)
    {
        parent::process($request);
        $user = new User($this->getDb());
        $user->setFirstName($request->getAttribute('first_name'));
        $user->setLastName($request->getAttribute('last_name'));
        $user->setEmail($request->getAttribute('email'));
        $user->setPassword($request->getAttribute('password'));
        $user->register($this->getDb());
        $this->setResponse(201, 'User created', $user->toArray());
    }
}