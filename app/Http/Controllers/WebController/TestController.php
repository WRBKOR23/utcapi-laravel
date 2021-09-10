<?php

namespace App\Http\Controllers\WebController;

use App\BusinessClass\CrawlQLDTData;
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
use App\Models\Teacher;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    /**
     * @throws Exception
     */
    public function test ()
    {
        return Cache::get('module_list');
    }
}
