<?php

/**
 * Redirects to other location by request.
 *
 * @param [type] $whereTo
 * @return void
 */
function redirect($whereTo)
{
    header("Location:" . URLROOT. $whereTo);
}