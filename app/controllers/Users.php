<?php

/*
 * Users class
 * Register user
 * Login user
 * Control Users behavior and access
 */

class Users extends Controller
{
        private $userModel;
        private $vld;


    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->vld = new Validation();
    }

    public function index()
    {
        redirect('/pages');
    }

    public function register()
    {
        if ($this->vld->ifRequestIsPostAndSanitize()) {

            $data = [
                'firstname' => trim($_POST['firstname']),
                'lastname' => trim($_POST['lastname']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'errors' => [
                    'firstnameErr' => '',
                    'lastnameErr' => '',
                    'emailErr' => '',
                    'passwordErr' => '',
                    'confirmPasswordErr' => '',
                ],
                'currentPage' => 'register'
            ];

            $data['errors']['firstnameErr'] = $this->vld->validateName($data['firstname']);
            $data['errors']['lastnameErr'] = $this->vld->validateName($data['lastname']);
            $data['errors']['lastnameErr'] = $this->vld->validateLength($data['lastname']);
            $data['errors']['emailErr'] = $this->vld->validateEmail($data['email'], $this->userModel);
            $data['errors']['passwordErr'] = $this->vld->validatePassword($data['password'], 6, 15);
            $data['errors']['confirmPasswordErr'] = $this->vld->confirmPassword($data['confirmPassword']);

            if ($this->vld->ifEmptyArray($data['errors'])){
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                var_dump($data);
                if ($this->userModel->register($data)){
                    flash('register_success', 'You have registered successfully');
                    redirect('/users/login');
                }else{
                    die('Something went wrong in adding user to DB');
                }
            }else {
                flash('register_fail', 'Please check the form', 'alert alert-danger');
                $this->view('users/register', $data);
            }

        }else {
            $data = [
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'errors' => [
                    'firstnameErr' => '',
                    'lastnameErr' => '',
                    'emailErr' => '',
                    'passwordErr' => '',
                    'confirmPasswordErr' => '',
                ],
                'currentPage' => 'register'
            ];

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        if ($this->vld->ifRequestIsPostAndSanitize()){

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'errors' => [
                    'emailErr' => '',
                    'passwordErr' => ''
                ],
                'currentPage' => 'login'
            ];

            $data['errors']['emailErr'] = $this->vld->validateLoginEmail($data['email'], $this->userModel);
            $data['errors']['passwordErr'] = $this->vld->validateEmpty($data['password'], 'Please enter your password');

            if ($this->vld->ifEmptyArray($data['errors'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser){
                    $this->createUserSession($loggedInUser);
                }else {
                    $data['errors']['passwordErr'] = "Wrong password or email";
                    $this->view('users/login', $data);
                }
            }else {
                $this->view('users/login', $data);
            }

        }else {

            $data = [
                'email' => '',
                'password' => '',
                'errors' => [
                    'emailErr' => '',
                    'passwordErr' => ''
                ],
                'currentPage' => 'login'
            ];

            $this->view('users/login', $data);
        }
    }

    public function createUserSession($userRow)
    {
        $_SESSION['user_id'] = $userRow->user_id;
        $_SESSION['user_email'] = $userRow->email;
        $_SESSION['user_name'] = $userRow->firstname;
        redirect('pages');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);

        session_destroy();
        redirect('users/login');
    }

}