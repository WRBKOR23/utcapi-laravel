<?php

    namespace App\Http\Controllers\WebController;

    use App\BusinessClass\CrawlQLDTData;
    use App\Helpers\SharedFunctions;
    use App\Http\Controllers\Controller;
    use App\Models\Account;
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
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;

    class TestController extends Controller
    {
        public const module_class_table = 'Module_Class';
        public const teacher_table = 'Teacher';
        public const schedule_table = 'Schedules';
        public const participate_table = 'Participate';

        public function test ()
        {
            $crawl = new CrawlQLDTData();
            $crawl->loginQLDT('191201402', md5('21/05/2001'));
//            $data = $crawl->getStudentModuleScore(true);
            $ms   = new ModuleScore();
            $arr  = [];
//            foreach ($data as $ele) {
//                foreach ($ele as $e) {
//                    $arr[] = $e;
//
////                    $ms->upsert($e);
//                }
//            }
//            $ms->insertMultiple($arr);
//            echo json_encode($crawl->getStudentExamSchedule([$ms->getLatestSchoolYear('191201402')]));
//            echo json_encode($crawl->getStudentExamSchedule($ms->getAllSchoolYear('191201402')));


            echo Storage::disk('local')->getDriver()->getAdapter()->applyPathPrefix('fsadf');
            echo dirname(storage_path());
        }
    }
