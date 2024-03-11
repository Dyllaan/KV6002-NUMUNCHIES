<?php
    /**
     * class CatEndpoint
     * @author Nathan Nordstrom-Hearne w21025072
     * 
     * Allows the added, edit, remove to a specific category.
     */
    namespace App\Endpoints;

    use \App\Classes\Category;
    use \App\Endpoints\UFIntegration\AddCat;
    use \App\Endpoints\UFIntegration\EditCat;
    use \App\Endpoints\UFIntegration\RemoveCat;
    use Core\Endpoint\Endpoint;

    class CatEndpoint extends Endpoint
    {
        public function __construct()
        {
            parent::__construct('GET', 'category');
            $this->addSubEndpoint(new AddCat('POST', 'addcategory'));
            $this->addSubEndpoint(new EditCat('PUT', 'edit'));
            $this->addSubEndpoint(new RemoveCat('DELETE', 'removecategory'));
            $this->setRequiresAuth(true);
        }
        public function process($request)
        {
            parent::process($request);
            $cat = Category::getInstance($this->getDb());
            $this->setResponse(200, 'Category Taken', $cat->toArray());
        }
    }
?>