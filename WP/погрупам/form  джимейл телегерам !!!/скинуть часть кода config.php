<?php
// настроить под себя 

if (file_exists(__DIR__ . '/env.php')) { //потключения файла 
	$env = require __DIR__ . '/env.php'; //потключения файла 
	define('GMAIL_USERNAME', $env['GMAIL_USERNAME']);  // название переменой имя 
	define('GMAIL_APP_PASSWORD', $env['GMAIL_APP_PASSWORD']); // название переменой пароль
	define('BOT_TOKEN', $env['BOT_TOKEN']); // апи токена телеграма 
} else {
	define('GMAIL_USERNAME', '');
	define('GMAIL_APP_PASSWORD', '');
	define('BOT_TOKEN', '');
}
