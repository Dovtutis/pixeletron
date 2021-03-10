<?php


class Validation
{
    private $password;

    /**
     * Checks if request method is POST
     *
     * @return void
     */
    public function ifRequestIsPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST")return true;
        return false;
    }
    /**
     * Sanitizes inputs from $_POST request
     *
     * @return void
     */
    public function sanitizePost ()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    /**
     * Check if request is POST, if yes, sanitizes it.
     *
     * @return void
     */
    public function ifRequestIsPostAndSanitize()
    {
        if ($this->ifRequestIsPost()){
            $this->sanitizePost();
            return true;
        }
        return false;
    }

    /**
     * Checks if every array value is empty.
     *
     * @param [type] $arr
     * @return void
     */
    public function ifEmptyArray($arr)
    {
        foreach ($arr as $value){
            if (!empty($value)) return false;
        }
        return true;
    }

    /**
     * Checks if given field is empty.
     *
     * @param [type] $data
     * @param [type] $field
     * @param [type] $fieldDisplayName
     * @return void
     */
    public function ifEmptyFieldWithReference(&$data, $field, $fieldDisplayName)
    {
        $fieldError = $field . 'Err';
        if (empty($data[$field])){
            $data['errors'][$fieldError] = "Please enter Your $fieldDisplayName";
        }
    }

    /**
     * Checks is given field is empty and returns given message.
     *
     * @param [type] $field
     * @param string $msg
     * @return void
     */
    public function validateEmpty($field, string $msg)
    {
        return empty($field) ? $msg : '';
    }

    /**
     * Validates name field by specified criteria.
     *
     * @param [type] $field
     * @return void
     */
    public function validateName($field)
    {
        if (empty($field)) return "Please enter your Name";
        if (!preg_match("/^[a-z ,.'-ĄČĘĖĮŠŲŪŽ]+$/i", $field)) return "Name must only contain Name characters";
        return '';
    }

    /**
     * Validates length of the field by specified criteria.
     *
     * @param [type] $field
     * @return void
     */
    public function validateLength($field)
    {
        if (empty($field)) return "Field cannot bet empty";
        if (strlen($field)>50) return "Maximum symbol count 50";
        return '';
    }

    /**
     * Validates email field by specified criteria.
     *
     * @param [type] $field
     * @param [type] $userModel
     * @return void
     */
    public function validateEmail($field, &$userModel)
    {
        if (empty($field)) return "Please enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email is not correct, please use sabachik @";
        if ($userModel->findUserByEmail($field)) return "Email already taken";
        return '';
    }

    /**
     * Validates login email field by specified criteria.
     *
     * @param [type] $field
     * @param [type] $userModel
     * @return void
     */
    public function validateLoginEmail($field, &$userModel)
    {
        if (empty($field)) return "Please enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email is not correct, please use sabachik @";
        if (!$userModel->findUserByEmail($field)) return "Email not found";
        return "";
    }

    /**
     * Validates password by specified criteria.
     *
     * @param [type] $passField
     * @param [type] $min
     * @param [type] $max
     * @return void
     */
    public function validatePassword($passField, $min, $max)
    {
        if (empty($passField)) return "Please enter Your Password";
        $this->password = $passField;
        if (strlen($passField) < $min) return "Password must be minimum $min characters long";
        if (strlen($passField) > $max) return "Password must be maximum $max characters long";
        if(!preg_match("#[0-9]+#", $passField)) return "Password must include at least one number!";
        if(!preg_match("#[a-z]+#", $passField)) return "Password must include at least one letter!";
        if(!preg_match("#[A-Z]+#", $passField)) return "Password must include at least one capital letter!";
        return '';
    }

    /**
     * Validates confirm password field by specified criteria.
     *
     * @param [type] $repeatField
     * @return void
     */
    public function confirmPassword($repeatField)
    {
        if (empty($repeatField)) return "Please repeat your password";
        if (!$this->password) return "No password found";
        if ($repeatField !== $this->password) return "Password must match";
        return '';
    }

    /**
     * Checks if new coordinates of a pixel are valid 
     *
     * @param [type] $usedCoordinates
     * @param [type] $newPixelCoordinates
     * @return void
     */
    public function checkIfCoordinateIsEmpty($usedCoordinates, $newPixelCoordinates)
    {
        foreach ($usedCoordinates as $coordinate) {
            foreach ($newPixelCoordinates as $oldCoordinate){
                if ($coordinate === $oldCoordinate){
                    return "There is another pixeletron in your coordinates, please select different coordinates";
                }
            }
        }
        return '';
    }

    /**
     * Checks if new coordinates of a pixel are valid 
     *
     * @param [type] $x
     * @param [type] $y
     * @param [type] $pixelSize
     * @return void
     */
    public function checkIfCoordinatesIsInBound($x, $y, $pixelSize)
    {
        if($x + $pixelSize > 500 || $y + $pixelSize > 500){
            return "Your pixeletron is out of bounds, choose different coordinates";
        }
        return '';
    }
}