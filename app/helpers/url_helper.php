<?php

function redirect($whereTo)
{
    header("Location:" . URLROOT. $whereTo);
}