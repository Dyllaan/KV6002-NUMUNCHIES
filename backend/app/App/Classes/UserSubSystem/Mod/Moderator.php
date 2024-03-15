<?php

namespace App\Classes\UserSubSystem\Mod;

use App\Classes\UserSubSystem\User;
use Core\Database\CrudModel;

class Moderator extends CrudModel
{
    private \AppConfig $appConfigInstance;
    private $user;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->appConfigInstance = new \AppConfig();
        $this->setTable('moderator_users');
    }

    public function isModerator()
    {
        $data = $this->getDb()->createSelect()->cols("*")->from($this->getTable())->where(["user_id = '" . $this->getUser()->getId() . "'"])->execute();
        return count($data) > 0;
    }

    public function searchUsers($offset, $conditions = [], $limit = 10) {
        $data = $this->getDb()->createSelect()->cols("*")
        ->from($this->getUser()->getTable())
        ->where($conditions)->limit($limit)->
        offset($offset)->execute();
        return $data;
    }

    public function searchBusinesses($offset, $conditions = [], $limit = 10) {
        $data = $this->getDb()->createSelect()->cols("*")
        ->from("businesses")
        ->where($conditions)->limit($limit)->
        offset($offset)->execute();
        return $data;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }


}
