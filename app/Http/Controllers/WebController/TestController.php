<?php

namespace App\Http\Controllers\WebController;

use App\BusinessClass\CrawlQLDTData;
use App\Exceptions\InvalidAccountException;
use App\Helpers\SharedFunctions;
use App\Http\Controllers\Controller;
use App\Imports\Import;
use App\Imports\FileImport;
use App\Models\Account;
use App\Models\DataVersionStudent;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Module;
use App\Models\ModuleClass;
use App\Models\ModuleScore;
use App\Models\Notification;
use App\Models\NotificationAccount;
use App\Models\OtherDepartment;
use App\Models\Participate;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use Exception;
use http\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestController extends Controller
{
    /**
     * @throws Exception
     */
    public function test ()
    {
        $a = DB::table('class')
                ->whereNotIn('id_faculty', ['KHOAKHAC'])
                ->orderBy('id_faculty')
                ->orderBy('class_name')
                ->select('id_class', 'class_name', 'id_faculty')
                ->get()
                ->toArray();

        foreach ($a as $e)
        {
            $m = '\'' . substr($e->id_class, 4) . '\'' . '=> [\'class_name\' => \'' . explode(' - ', $e->class_name)[0] . '\',' . PHP_EOL;
            $m .= '\'id_faculty\' => \'' . $e->id_faculty . '\'],' . PHP_EOL;
            file_put_contents('a.php', $m, FILE_APPEND);
        }
    }
}
