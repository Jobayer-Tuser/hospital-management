<?php

/**
 * Start the SESSION for entire Application
 * 
 * Include Required Configuration Files
 * [1] Site
 * [2] Server
 * [3] DataBase
 * 
 * Define a "VIEW" Class or BluePrint
 * Purpose: This view class object will perform to call pages when it's called only
 */
session_start();

include "config/site.php";
include "config/server.php";
include "config/database.php";

class View
{
	public function loadContent($directory, $page_name)
	{
		include "resource/view/" . $directory . "/" . $page_name . ".php";
	}
}
