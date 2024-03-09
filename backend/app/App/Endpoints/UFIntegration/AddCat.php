<?php
    /**
     * class AddCat
     * @author Nathan Nordstrom-Hearne w21025072
     * 
     * Used to upload a catagory to the cat database and to display 
     * on the website.
     */

     namespace App\Endpoints\UFIntegration;

    use Core\Endpoint\Endpoint;

    class AddCat extends Endpoint
    {
        public function _construct()
        {
            parent::_construct('POST', 'addcategory');
            $this->setRequiresAuth(true);
            $this->getAttributes()->addRequiredString(['cat_name', 'cat_image']);
        }

        public function process($request)
        {
            parent::process($request);
            $cat = categories::getInstance($this->getDb());
            $cat->setCatName($request->getAttribute('cat_name'));
            $cat->setCatImage($request->getAttribute('cat_image'));
            $cat->category($this->getDb());
            $this->setResponse(200, 'Category Created', $cat->toArray());
        }
    }
?>