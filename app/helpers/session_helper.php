<?php
session_start();

/**
 * Handles flash messages by request.
 *
 * @param string $name
 * @param string $message
 * @param string $class
 * @return void
 */
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)){
        if (!empty($message) && empty($_SESSION[$name])){

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;

        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo "<div class='$class' id='msg-flash'>{$_SESSION[$name]}</div>";
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

/**
 * Checks is user is logged in.
 *
 * @return boolean
 */
function isLoggedIn(){
    if (isset($_SESSION['user_id'])) return true;
    return false;
}