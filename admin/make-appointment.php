<?php

/**
 * Include Required Controller
 * Define Object
 * Include Required Content for this Page
 */
include("app/Http/Controllers/View.php");

$view = new View;
 
$view->loadContent("include", "session");
$view->loadContent("include", "top");
$view->loadContent("content", "appointment/make-appointment");
$view->loadContent("include", "tail");