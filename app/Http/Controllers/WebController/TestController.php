<?php

    namespace App\Http\Controllers\WebController;

    use App\BusinessClass\CrawlQLDTData;
    use App\Helpers\SharedFunctions;
    use App\Http\Controllers\Controller;
    use App\Models\Account;
    use App\Models\DataVersionStudent;
    use App\Models\Department;
    use App\Models\Faculty;
    use App\Models\ModuleClass;
    use App\Models\ModuleScore;
    use App\Models\Notification;
    use App\Models\NotificationAccount;
    use App\Models\OtherDepartment;
    use App\Models\Participate;
    use App\Models\Schedule;
    use App\Models\Teacher;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;

    class TestController extends Controller
    {
        public function test ()
        {
            $a = new DataVersionStudent();
            Cache::put('a', $a->get('191201402'), 5);
//            var_dump(Cache::get('a'));

            return Cache::get('a');
        }
    }
