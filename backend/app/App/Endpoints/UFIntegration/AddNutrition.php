<?php
    /**
     * class AddFood
     * @author Nathan Nordstrom-Hearne w21025072
     * 
     * This class is used to add the foods nutrients such as calories,
     * weight, salt, fat, protein, etc. This will allow the user to be 
     * able to track the exact amount of food that they are consuming and
     * the amount of nutrients that they are also consuming.
     */

     namespace App\Endpoints\UFIntegration;

    use Core\Endpoint\Endpoint;
    use Core\HTTP\Classes\Request;
    use Core\Database\Queries;
    use Core\Database;

    class AddNutrition extends Endpoint
    {
        public function _construct()
        {
            parent::_construct('POST', 'addnutrition');
            $this->getAttribute()->addRequiredStrings(['food_name']);
            $this->getAttribute()->addRequiredInts(['weight', 'calories', 'protein', 'carbs', 'fat', 'salt']);
        }

        public function process($request)
        {
            parent::process($request);
            $nutrition = nutrition_details::getInstance($this->getDb());
            $nutrition->setFoodName($request->getAttribute('food_name'));
            $nutrition->setWeight($request>getAttribute('weight'));
            $nutrition->setCalories($request->getAttribute('calories'));
            $nutrition->setProtein($request->getAttribute('protein'));
            $nutrition->setCarbs($request->getAttribute('carbs'));
            $nutrition->setFat($request->getAttribute('fat'));
            $nutrition->setSalt($request->getAttribute('salt'));
            $this->setResponse(200, 'Food Nutrients Created');
        }
    }
?>