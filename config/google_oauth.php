<?php

require_once BASE_PATH . 'config/env.php';

loadEnv();

define('GOOGLE_CLIENT_ID', env('GOOGLE_CLIENT_ID', ''));
define('GOOGLE_CLIENT_SECRET', env('GOOGLE_CLIENT_SECRET', ''));
define('GOOGLE_REDIRECT_URI', env('GOOGLE_REDIRECT_URI', 'http://localhost/pcbuild/auth/google/callback'));
define('GOOGLE_AUTH_URL', env('GOOGLE_AUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth'));
define('GOOGLE_TOKEN_URL', env('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token'));
define('GOOGLE_USERINFO_URL', env('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v2/userinfo'));
