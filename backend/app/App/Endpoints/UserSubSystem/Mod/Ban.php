<?php

/**
 * class UserEndpoint
 * Allows the current user to be retrieved, edited and deleted
 * @generated This class was created using Github Copilot
 */

namespace App\Endpoints\UserSubSystem\Mod;

use App\Classes\UserSubSystem\UserAddonEndpoint;
use App\Classes\UserSubSystem\Helpers\SearchHelper;

class Ban extends UserAddonEndpoint
{

    public function __construct()
    {
        parent::__construct('POST', 'ban', 'moderator');
        $this->getAttributes()->addAllowedInts(['user_id']);
        $this->getAttributes()->addAllowedBool('banned');
    }

    public function process($request)
    {
        parent::process($request);
        $banned = 1;

        if($request->hasAttribute('banned')) {
            $banned = ($request->getAttribute('banned') == 'true' ? 1 : 0);
        }

        $this->getModerator()->banUser($request->getAttribute('user_id'), $banned);
        if($banned) {
            $this->setResponse(200, "User has been banned");
        } else {
            $this->setResponse(200, "User has been unbanned");
        }
    }
}
