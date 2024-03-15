<?php
/**
 * class OrderCollect
 * @author Cameron Bramley w21020682
 * 
 * Sets order status to collected
 */

namespace App\Endpoints\UBIntegration;

use Core\Endpoint\Endpoint;

class OrderCollect extends Endpoint
{

    public function __construct()
    {
        parent::__construct('PUT', 'ordercollect');
        $this->setRequiresAuth(true);
        $this->getAttributes()->addRequiredInts(['order_id']);
    }

    public function process($request)
    {
        $status = ['status' => 'collected'];
        $id = $this->getDb()->createUpdate()->table("orders")->set($status)->where(["id = '" . $request->getAttribute('order_id'). "'"])->execute();

        $this->setResponse(200, 'Order collected', ['id' => $id]);
    }
} 