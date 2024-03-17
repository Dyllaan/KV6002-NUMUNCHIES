<?php
/**
 * @author Louis Figes
 * @generated Github CoPilot was used during the creation of this code
 * This class is used to handle the user's IP address for MFA
 */

namespace App\Classes\UserSubSystem;

use App\Classes\UserSubSystem\User;
use Core\Database\CrudModel;

class UserIP extends CrudModel
{
    private \AppConfig $appConfigInstance;
    private $user;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->appConfigInstance = new \AppConfig();
        $this->setTable('user_ips');
    }

    public function addIP()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $id = $this->getDb()->createInsert()->into($this->getTable())
        ->cols('user_id, ip_address')
        ->values([$this->getUser()->getId(), $ip])->execute();
        return $ip;
    }

    public function checkForIp($ip)
    {
        $ip = strval($_SERVER['REMOTE_ADDR']);
        $data = $this->getDb()->createSelect()->
        cols("*")->from($this->getTable())->
        where(["user_id = '" . $this->getUser()->getId() . "'", "ip_address = '" . $ip . "'"])->execute();
        if (count($data) == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function isIPAllowed($ip) {
        $data = $this->getDb()->createSelect()->
        cols("*")->from($this->getTable())->
        where(["user_id = '" . $this->getUser()->getId() . "'",
         "ip_address = '" . $ip . "'", "allowed = 1"])->execute();
        if (count($data) == 0) {
            return false;
        } else {
            return true;
        }
    
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

}
