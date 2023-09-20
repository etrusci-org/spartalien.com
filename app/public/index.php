<?php
declare(strict_types=1);
namespace s9com;


// Turn on maintenance mode on/off
const MAINTENANCE_MODE = false;

// Path to app/lib/init.php
const LIB_INIT_FILE = __DIR__.'/../lib/init.php';

// Path to _maintenance.php
const MAINTENANCE_PAGE_FILE = __DIR__.'/_maintenance.php';


// -----------------------------------------------------------


if (!MAINTENANCE_MODE) {
    require LIB_INIT_FILE;
}
else {
    require MAINTENANCE_PAGE_FILE;
}
