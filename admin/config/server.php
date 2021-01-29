<?php

/**
 * Define Default TimeZone
 * 
 * SMTP (Simple Mail Transfer Protocol) Configuration
 * [1] Host Name
 * [2] Mail ID
 * [3] Port No
 * [4] SSL or TSL
 * [5] Password
 */
date_default_timezone_set("Asia/Dhaka");


$GLOBALS['SMTPHOST'] = "mail.servername.com";
$GLOBALS['SMTPUSER'] = "noreply@servername.com";
$GLOBALS['SMTPPORT'] = "465";
$GLOBALS['SMTPAUTH'] = "ssl";
$GLOBALS['SMTPPASS'] = "abc123";
