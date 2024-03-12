<?php
    /**
     * class Category
     * @author Nathan Nordstrom-Hearne w21025072
     * 
     * Category is used to store cat data such as adding and removing a category.
     */

    namespace App\Classes;

    use Firebase\JWT\JWT;
    use Core\Database\CrudModel;
    use Core\Database\CrudInterface;

    class Category extends CrudModel implements CrudInterface
    {
        private $catName;
        private $catImage;

        private static $instance = null;

        private \AppConfig $appConfigInstance;

        public function __construct($db)
        {
            parent::__construct($db);
            $this->appConfigInstance = new \Appconfig();
            $this->setTable("category");
        }
        public static function getInstance($db)
        {
            if(self::$instance ===null){
                self::$instance = new Category($db);
            }
            return self::$instance;
        }
        public function exists()
        {
            if ($this->getId() != null) {
                $data = $this->getDb()->createSelect()->cols("*")->from($this->getTable())->where(["cat_id = '" . $this->getId() . "'"])->execute();
                if (count($data) == 0) {
                    return false;
                } else {
                    return true;
                }
            } elseif ($this->getCatName() != null) {
                $data = $this->getDb()->createSelect()->cols("*")->from($this->getTable())->where(["cat_name = '" . $this->getCatName() . "'"])->execute();
                if (count($data) == 0) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
        public function save()
        {
            if ($this->checkSavable()) {
                $this->getDb()->beginTransaction();
                try {
                    $id = $this->getDb()->createInsert()->into($this->getTable())->cols('cat_name')->values([$this->getCatName()])->execute();
                    if ($id != null) {
                        $this->getDb()->commit();
                        $this->setId($id);
                        return $this->toArray();
                    } else {
                        $this->getDb()->rollBack();
                        $this->setResponse(400, "Category could not be saved");
                    }
                } catch (\Exception $e) {
                    $this->getDb()->rollBack();
                    $this->setResponse(500, "An error occurred: " . $e->getMessage());
                }
            } else {
                $this->setResponse(400, "Category could not be saved");
            }
        }
        private function checkSavable()
        {
            $errors = [];

        // TODO: maybe lets predefine these messages in some other file as constants and then just reference to them ie. $errorMessages['missingName']

        if (empty($this->getCatName())) {
            $errors[] = "Missing Category name";
        }

        if (strlen($this->getCatName()) < 3) {
            $errors[] = "First Category must be at least 3 characters";
        } elseif (strlen($this->getCatName()) > 30) {
            $errors[] = "First Category must be less than 30 characters";
        }

        if (!empty($errors)) {
            $len = count($errors);
            $this->setResponse(400, `There are: $len`, $errors);
        }
        return true;
        }
        public function get()
        {
            $data = $this->getDb()->createSelect()->cols(["cat_name"])->from($this->getTable())->where(["cat_id" => $this->getId()]);
            
            if(count($data) == 0)
            {
                $this->setResponse(400, "Category does not Exist");
            } else {
                $this->setCatName($data[0]['cat_name']);
            }
        }
        public function update()
        {
            if(!$this->exists())
            {
                $this->setResponse(400, "Category does not Exists");
            }
            $data = $this->getDb()->createSelect()->cols(["cat_name"])->from($this->getTable())->where(["cat_id" => $this->getId()]);
            
            if(count($data) == 0)
            {
                $this->setResponse(400, "Category does not Exist");
            } 
            $changed = array_filter([
                'cat_name' => $this->getCatName() !== $data[0]['cat_name'] ? $this->getCatName() : null,
                'cat_image' => $this->getCatImage() !== $data[0]['cat_image'] ? $this->getCatImage() : null
            ]);
            if(empty($changed))
            {
                return['message' => "No changes"];
            }
            $this->getDb()->createUpdate()->table('categories')->set($changed)->where(["cat_id" => $this->getId()]);
            return['message' => "Category Updated"];
        }
        public function delete()
        {
            if($this->exists())
            {
                $this->getDb()->createDelete()->from($this->getTable())->where(["cat_id = '" . $this->getId() . "'"])->execute();
                return ['message' => "Category Deleted"];
            }
            $this->setResponse(400, "Category does not Exist");
        }
        public function toArray()
        {
            $cat['categories'] = [
                'cat_id' => $this->getId(),
                'cat_name' => $this->getCatName(),
                'cat_image' => $this->getCatImage()
            ];
            return $cat;
        }
        
        public function getCatName()
        {
            return $this->catName;
        }
        public function setCatName($catName)
        {
            $this->catName = $catName;
        }
        public function getCatImage()
        {
            return $this->catImage;
        }
        public function setCatImage($catImage)
        {
            $this->catImage = $catImage;
        }
    }
?>