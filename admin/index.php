<?php

/**
 * Include Required Controller
 * Define Object
 * Include Required Content for this Page
 */
include("app/Http/Controllers/View.php");

$view = new View;
 
$view->loadContent("include", "session");
$view->loadContent("include", "auth-top");
$view->loadContent("content", "admin/login");
$view->loadContent("include", "auth-tail");
