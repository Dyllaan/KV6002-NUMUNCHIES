<?php

namespace App\Endpoints\BusinessSubsystem;

use App\Classes\BusinessSubsystem\Business;
use App\Endpoints\BusinessSubsystem\Subendpoints\AcceptOrder;
use App\Endpoints\BusinessSubsystem\Subendpoints\CreateBusiness;
use App\Endpoints\BusinessSubsystem\Subendpoints\CreateItem;
use App\Endpoints\BusinessSubsystem\Subendpoints\DeclineOrder;
use App\Endpoints\BusinessSubsystem\Subendpoints\DeleteBusiness;
use App\Endpoints\BusinessSubsystem\Subendpoints\ForceVerifyBusiness;
use App\Endpoints\BusinessSubsystem\Subendpoints\GetBusinessItems;
use App\Endpoints\BusinessSubsystem\Subendpoints\GetBusinessOrders;
use App\Endpoints\BusinessSubsystem\Subendpoints\GetCategories;
use App\Endpoints\BusinessSubsystem\Subendpoints\MyBusinesses;
use App\Endpoints\BusinessSubsystem\Subendpoints\UpdateBusiness;
use App\Endpoints\BusinessSubsystem\Subendpoints\DeleteItem;
use Core\Endpoint\Endpoint;

class BusinessEndpoint extends Endpoint
{
    public function __construct()
    {
        parent::__construct('GET', 'business');
        $this->getAttributes()->addAllowedInts(['id']);
        $this->addSubEndpoint(new CreateBusiness());
        $this->addSubEndpoint(new UpdateBusiness());
        $this->addSubEndpoint(new MyBusinesses());
        $this->addSubEndpoint(new DeleteBusiness());
        $this->addSubEndpoint(new GetBusinessItems());
        $this->addSubEndpoint(new ForceVerifyBusiness());
        $this->addSubEndpoint(new GetBusinessOrders());
        $this->addSubEndpoint(new DeleteItem());
        $this->addSubEndpoint(new CreateItem());
        $this->addSubEndpoint(new GetCategories());
        $this->addSubEndpoint(new AcceptOrder());
        $this->addSubEndpoint(new DeclineOrder());
    }

    public function process($request)
    {
        parent::process($request);

        $id = $request->getAttribute('id');

        $business = new Business($this->getDb());


        if (isset($id)) {
            $business->id = $id;
            $this->setResponse(200, $business->getById());
        } else {
            $this->setResponse(200, $business->get());
        }

        $this->setResponse(0, $business->get());
    }
}
