<?php


namespace App\Http;


class CmdController extends Controllers\Controller
{
    public function runScript ()
    {
        $command1 = escapeshellcmd('php artisan optimize');
        $command2 = 'cd ' . dirname(storage_path());
        shell_exec($command2 . ' && ' . $command1);
    }
}
