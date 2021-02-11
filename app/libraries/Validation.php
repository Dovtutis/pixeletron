<?php


class Validation
{
    private $password;

    public function ifRequestIsPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST")return true;
        return false;
    }

    public function sanitizePost ()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    public function ifRequestIsPostAndSanitize()
    {
        if ($this->ifRequestIsPost()){
            $this->sanitizePost();
            return true;
        }
        return false;
    }

    public function ifEmptyArray($arr)
    {
        foreach ($arr as $value){
            if (!empty($value)) return false;
        }
        return true;
    }

    public function ifEmptyFieldWithReference(&$data, $field, $fieldDisplayName)
    {
        $fieldError = $field . 'Err';
        if (empty($data[$field])){
            $data['errors'][$fieldError] = "Please enter Your $fieldDisplayName";
        }
    }

    public function validateEmpty($field, string $msg)
    {
        return empty($field) ? $msg : '';
    }


    public function validateName($field)
    {
        if (empty($field)) return "Please enter your Name";
        if (!preg_match("/^[a-z ,.'-ĄČĘĖĮŠŲŪŽ]+$/i", $field)) return "Name must only contain Name characters";
        return '';
    }

    public function validateLength($field)
    {
        if (empty($field)) return "Field cannot bet empty";
        if (strlen($field)>50) return "Maximum symbol count 50";
        return '';
    }

    public function validateEmail($field, &$userModel)
    {
        if (empty($field)) return "Please enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email is not correct, please use sabachik @";
        if ($userModel->findUserByEmail($field)) return "Email already taken";
        return '';
    }

    public function validateLoginEmail($field, &$userModel)
    {
        if (empty($field)) return "Please enter Your Email";
        if (filter_var($field, FILTER_VALIDATE_EMAIL) === false) return "Email is not correct, please use sabachik @";
        if (!$userModel->findUserByEmail($field)) return "Email not found";
        return "";
    }

    public function validatePassword($passField, $min, $max)
    {
        if (empty($passField)) return "Please enter Your Password";
        if (strlen($passField) < $min) return "Password must be minimum $min characters long";
        if (strlen($passField) > $max) return "Password must be maximum $max characters long";
        if(!preg_match("#[0-9]+#", $passField)) return "Password must include at least one number!";
        if(!preg_match("#[a-z]+#", $passField)) return "Password must include at least one letter!";
        if(!preg_match("#[A-Z]+#", $passField)) return "Password must include at least one capital letter!";
        $this->password = $passField;
        return '';
    }

    public function confirmPassword($repeatField)
    {
        if (empty($repeatField)) return "Please repeat your password";
        if (!$this->password) return "No password found";
        if ($repeatField !== $this->password) return "Password must match";
        return '';
    }

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

    public function checkIfCoordinatesIsInBound($x, $y, $pixelSize)
    {
        if($x + $pixelSize > 500 || $y + $pixelSize > 500){
            return "Your pixeletron is out of bounds, choose different coordinates";
        }
        return '';
    }
}