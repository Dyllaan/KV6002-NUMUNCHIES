<?php

namespace App\Endpoints\BusinessSubsystem\Subendpoints;

use App\Classes\BusinessSubsystem\Address;
use App\Classes\BusinessSubsystem\Business;

use Core\Endpoint\SubEndpoint\SubEndpoint;

class CreateBusiness extends SubEndpoint
{

    public function __construct()
    {
        parent::__construct('POST', 'create');
        $this->getAttributes()->addRequiredStrings(['name', 'description', 'address', 'city', 'postcode', 'country']);
        $this->getAttributes()->addAllowedStrings(['email', 'phone']);
        $this->setRequiresAuth(true);
    }

    public function process($request)
    {
        parent::process($request);

        $user = $this->getUser();

        if (!isset($user)) {
            return $this->setResponse(401, "User is not logged in!");
        }

        $fields = $request->getAttributes();

        // create address object
        $address = new Address($this->getDb());
        $address->city = $fields['city'];
        $address->address = $fields['address'];
        $address->postcode = $fields['postcode'];
        $address->country = $fields['country'];
        $res = $address->save();

        // if address is created then we continue, if not we return the error
        if (!$res["id"]) {
            $this->setResponse(400, "Address not created");
            return;
        }

        // create business
        $business = new Business($this->getDb());
        $business->name = $fields['name'];
        $business->description = $fields['description'];
        if (isset($fields['phone'])) {
            $business->phone_optional = $fields['phone'];
        }
        if (isset($fields['email'])) {
            $business->email_optional = $fields['email'];
        }

        // set the address id to fo
        $business->address = $res["id"];

        // save the business
        $res = $business->save();

        $ub_connect = $this->getDb()->createInsert()->into("users_businesses")->cols('user_id, business_id')->values([$user->getId(), $res["id"]])->execute();

        $this->setResponse(200, $res);
    }
}
