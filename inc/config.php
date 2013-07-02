<?php

// database credentials
define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'd0133e48');
define('DATABASE_PASS', 'AFNqVZWCbxzyp2AA');
define('DATABASE_NAME', 'd0133e48');


// application settings
define('REQUEST_TIMEOUT_MINUTES', 15); // requests are invalidated after this time (prevent ppl from blocking items by starting the form but never finishing it)

define('RESPECT_APPROVED_ON_AVI_CALC', false); // whether the amount of available items in a timeframe should respect the "approved" flag (only count items in requests which are approved)


define('EXPIRATION_MINUTES', 60);


?>