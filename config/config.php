<?php 

define('DEBUG', true);
define('DEFAULT_CONTROLLER', 'Home');			//základní controller 

define('DEFAULT_LAYOUT', 'default');    		//no layout -> základní layout nastaven
define('SITE_TITLE', 'MVC Framework');			//Zákldání site title
define('PROOT', '/MVC-Framework/'); 			// pro spuštění na live serveru změnit -> '/'

//nastavení DB params
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mvc');
define('DB_USER', 'root');
define('DB_PASS', '');

//cookie pro remember me a login sessions
define('COOKIE_NAME', 'XTWjK4Q3x38VCb39orV7N');
define('COOKIE_EXPIRY', 2592000);
define('USER_SESSION_NAME', 'Bli5XN4giw1QnHGXKMjG');

define('MENU_BRAND', 'MVC-Framework');
define('ACCESS_RESTRICTED', 'Restricted');