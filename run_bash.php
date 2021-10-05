<?php

$cmd = 'php -r "file_exists(\'.env\') || copy(\'.env.example\', \'.env\');" && ';
$cmd .= 'php artisan key:generate && ';
$cmd .= 'php artisan optimize && ';
$cmd .= 'php artisan view:cache && ';
$cmd .= 'php artisan package:discover --ansi';

shell_exec($cmd);