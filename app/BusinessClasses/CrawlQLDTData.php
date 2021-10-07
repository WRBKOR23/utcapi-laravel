<?php

namespace App\BusinessClasses;

use App\Exceptions\InvalidQLDTAccount;
use App\Helpers\SharedData;
use App\Helpers\SharedFunctions;
use App\Helpers\simple_html_dom;
use DOMDocument;
use Exception;

class CrawlQLDTData
{
    private string $id_student;
    private string $major = '';
    private array $school_year_arr = [];
    private array $form_crawl_request = [];
    private string $url = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.Info/Login.aspx';
    private string $url_login = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.info/';
    private string $url_student_info = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.info/';
    private string $url_student_mark = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.info/';
    private string $url_student_exam_schedule = 'https://qldt.utc.edu.vn/CMCSoft.IU.Web.info/';
    private bool $is_all = false;
    private $ch;

    public function __construct ()
    {
        $this->ch = curl_init();
        $this->_getAccessToken();
    }

    private function _getAccessToken ()
    {
        file_get_contents($this->url);
        $response_header = explode(' ', $http_response_header[3]);
        $location        = explode('/', $response_header[1]);
        $access_token    = $location[2];

        $this->url_login                 .= $access_token . '/Login.aspx';
        $this->url_student_mark          .= $access_token . '/StudentMark.aspx';
        $this->url_student_exam_schedule .= $access_token . '/StudentViewExamList.aspx';
        $this->url_student_info          .= $access_token . '/StudentProfileNew/HoSoSinhVien.aspx';
    }

    /**
     * @throws Exception
     */
    public function loginQLDT (string $id_student, string $qldt_password)
    {
        $this->id_student = $id_student;

        $form_login_request                = SharedData::$form_login_request;
        $form_login_request['txtUserName'] = $this->id_student;
        $form_login_request['txtPassword'] = $qldt_password;

        $response = $this->_postRequest($this->url_login, $form_login_request);

        $html = new simple_html_dom();
        $html->load($response);

        $flag = $html->find('select[id=drpCourse]', 0);
        if (empty($flag))
        {
            $flag2 = $html->find('input[id=txtUserName]', 0);
            if (empty($flag2))
            {
                throw new Exception();
            }
            else
            {
                throw new InvalidQLDTAccount();
            }
        }
    }

    public function getStudentInfo () : array
    {
        $response1 = $this->_getRequest($this->url_student_mark);
        $response2 = $this->_getRequest($this->url_student_info);

        $html = new simple_html_dom();
        $html->load($response1);

        $data['student_name']  = $html->find('span[id=lblStudentName]', 0)->innertext;
        $data['academic_year'] = $html->find('span[id=lblAy]', 0)->innertext;
//        $data['class_name']    = $html->find('span[id=lblAdminClass]', 0)->innertext;
//        $data['class_name']    = 'Lớp ' . SharedFunctions::formatString(substr_replace($data['class_name'],
//                                                                                       '- Khóa ',
//                                                                                       strlen($data['class_name']) - 2,
//                                                                                       0));
        $html->load($response2);
        $data['birth'] = $html->find('input[id=txtNgaySinh]', 0)->value;
        $data['birth'] = SharedFunctions::formatDate($data['birth']);

//        $dom = new DOMDocument();
//        @$dom->loadHTML(mb_convert_encoding($response1, 'HTML-ENTITIES', "UTF-8"));
//        $major = $dom->getElementById('drpField')->childNodes->item(1)->textContent;

//        $str_length = 0;
//        foreach (SharedData::$faculties as $faculty => $arr)
//        {
//            foreach ($arr as $a)
//            {
//                if (strpos($major, $a) !== false
//                    && strlen($a) > $str_length)
//                {
//                    $data['id_faculty'] = $faculty;
//                    $str_length         = strlen($a);
//                }
//            }
//        }

        return $data;
    }

    public function getStudentModuleScore ($is_all) : array
    {
        $this->is_all = $is_all;

        $this->_getFormRequireDataOfStudentModuleScore();
        $data = $this->_getDataModuleScore();
        $data = $this->_formatModuleScoreData($data);

        curl_close($this->ch);

        return $data;
    }

    private function _getFormRequireDataOfStudentModuleScore ()
    {
        $this->_getSchoolYear();

        $html = new simple_html_dom();

        $response = $this->_getRequest($this->url_student_mark);
        $html->load($response);

        $this->form_crawl_request                      = SharedData::$form_get_mark_request;
        $this->form_crawl_request['__VIEWSTATE']       = $html->find('input[name=__VIEWSTATE]', 0)->value;
        $this->form_crawl_request['__EVENTVALIDATION'] = $html->find('input[name=__EVENTVALIDATION]', 0)->value;
        $this->form_crawl_request['hidStudentId']      = $html->find('input[id=hidStudentId]', 0)->value;
        $this->form_crawl_request['drpField']          = $html->find('select[name=drpField] option', 0)->value;
        $this->form_crawl_request['hidFieldId']        = $html->find('input[id=hidFieldId]', 0)->value;
        $this->form_crawl_request['hidFieldName']      = $this->major;
    }

    private function _getSchoolYear ()
    {
        $html = new simple_html_dom();

        $response = $this->_getRequest($this->url_student_mark);
        $html->load($response);

        $elements = $html->find('select[name=drpHK] option');
        unset($elements[0]);

        if ($this->is_all)
        {
            $this->_getAllSchoolYears($elements);
        }
        else
        {
            $this->_getLatestSchoolYear($elements);
        }
    }

    private function _getAllSchoolYears ($elements)
    {
        foreach ($elements as $e)
        {
            $this->school_year_arr[] = $e->innertext;
        }
    }

    private function _getLatestSchoolYear ($elements)
    {
        foreach (array_reverse($elements) as $e)
        {
            if (strlen(trim($e->innertext, ' ')) != 7)
            {
                $this->school_year_arr[] = $e->innertext;
                break;
            }
        }
    }

    private function _getDataModuleScore () : array
    {
        $data = [];
        foreach ($this->school_year_arr as $school_year)
        {
            $this->form_crawl_request['drpHK'] = $school_year;
            $response                          = $this->_postRequest($this->url_student_mark,
                                                                     $this->form_crawl_request);

            $html = new simple_html_dom();
            $html->load($response);
            $tr = $html->find('table[id=tblStudentMark] tr');

            for ($j = 1; $j < count($tr) - 1; $j++)
            {
                $arr                = [];
                $arr['school_year'] = $school_year;

                $td               = explode('<br><br>', $tr[$j]->children(1)->innertext);
                $arr['id_module'] = $td[1] ?? $td[0];

                $td                 = explode('<br><br>', $tr[$j]->children(2)->innertext);
                $str                = $td[1] ?? $td[0];
                $arr['module_name'] = SharedFunctions::formatStringDataCrawled($str);

                $td            = explode('<br><br>', $tr[$j]->children(3)->innertext);
                $arr['credit'] = $td[1] ?? $td[0];

                $td                = explode('<br><br>', $tr[$j]->children(8)->innertext);
                $temp_evaluation   = $td[1] ?? $td[0];
                $arr['evaluation'] = $temp_evaluation == '&nbsp;' ? null : $temp_evaluation;

                $td                = explode('<br><br>', $tr[$j]->children(9)->innertext);
                $arr['id_student'] = $td[1] ?? $td[0];

                //------------------Process Score-------------------------------------------
                $temp_data = $tr[$j]->children(10)->innertext;
                $td3       = explode('<br><br><br>', $temp_data);
                $td2       = explode('<br><br>', $temp_data);
                $td1       = explode('<br>', $temp_data);

                $temp_score = $td3[1] ?? $td3[0];
                if (strpos($temp_score, '<br>') !== false)
                {
                    $temp_score = $td2[1] ?? $td2[0];
                }
                if (strpos($temp_score, '<br>') !== false)
                {
                    $temp_score = $td1[1] ?? $td1[0];
                }

                if (count($tr[$j]->children()) == 11)
                {
                    $arr['process_score']                  = null;
                    $arr['test_score']                     = null;
                    $arr['final_score']                    = $temp_score == '&nbsp;' ? null : $temp_score;
                    $data[$school_year][$arr['id_module']] = $arr;

                    continue;
                }

                $arr['process_score'] = $temp_score == '&nbsp;' ? null : $temp_score;
                //------------------------------------------------------------


                //------------------Test Score-------------------------------------------
                $temp_data = $tr[$j]->children(11)->innertext;
                $td3       = explode('<br><br><br>', $temp_data);
                $td2       = explode('<br><br>', $temp_data);
                $td1       = explode('<br>', $temp_data);

                $temp_score = $td3[1] ?? $td3[0];
                if (strpos($temp_score, '<br>') !== false)
                {
                    $temp_score = $td2[1] ?? $td2[0];
                }
                if (strpos($temp_score, '<br>') !== false)
                {
                    $temp_score = $td1[1] ?? $td1[0];
                }
                $arr['test_score'] = $temp_score == '&nbsp;' ? null : $temp_score;
                //------------------------------------------------------------

                if (count($tr[$j]->children()) == 12)
                {
                    $arr['final_score']                    = null;
                    $data[$school_year][$arr['id_module']] = $arr;

                    continue;
                }

                //------------------Theoretical Score-------------------------------------------
                $temp_data = $tr[$j]->children(12)->innertext;
                $td3       = explode('<br><br><br>', $temp_data);
                $td2       = explode('<br><br>', $temp_data);
                $td1       = explode('<br>', $temp_data);

                $temp_score = $td3[1] ?? $td3[0];
                if (strpos($temp_score, '<br>') !== false)
                {
                    $temp_score = $td2[1] ?? $td2[0];
                }
                if (strpos($temp_score, '<br>') !== false)
                {
                    $temp_score = $td1[1] ?? $td1[0];
                }
                $arr['final_score'] = $temp_score == '&nbsp;' ? null : $temp_score;
                //------------------------------------------------------------

                $data[$school_year][$arr['id_module']] = $arr;
            }
        }

        return $data;
    }

    private function _postRequest ($url, $post_form)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($post_form));
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'c.txt');
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($this->ch);

        return $response;
    }

    private function _getRequest ($url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, 'c.txt');
        $response = curl_exec($this->ch);

        return $response;
    }

    public function getStudentExamSchedule ($is_all) : array
    {
        $this->is_all = $is_all;

        $this->_getFormRequireDataOfStudentExamSchedule();
        $data = $this->_getDataExamSchedule();

        curl_close($this->ch);

        return $data;
    }

    private function _getFormRequireDataOfStudentExamSchedule ()
    {
        $this->_getSchoolYear();

        $html = new simple_html_dom();

        $response = $this->_getRequest($this->url_student_exam_schedule);
        $html->load($response);

        $this->form_crawl_request                      = SharedData::$form_get_exam_schedule_request;
        $this->form_crawl_request['__VIEWSTATE']       = $html->find('input[name=__VIEWSTATE]', 0)->value;
        $this->form_crawl_request['__EVENTVALIDATION'] = $html->find('input[name=__EVENTVALIDATION]', 0)->value;
        $this->form_crawl_request['hidStudentId']      = $html->find('input[id=hidStudentId]', 0)->value;

        $this->_formatToUnOfficialSchoolYear();
        $elements = $html->find('select[name=drpSemester] option');

        $data = [];
        $flag = false;
        for ($i = count($elements) - 1; $i >= 0; $i--)
        {
            if (in_array($elements[$i]->innertext, $this->school_year_arr))
            {
                $data[$elements[$i]->innertext] = $elements[$i]->value;
                $flag                           = true;
            }
            else if ($flag)
            {
                $data[$elements[$i]->innertext] = $elements[$i]->value;
                break;
            }
        }

        if (empty($data))
        {
            $data = [
                $elements[2]->innertext => $elements[2]->value,
                $elements[1]->innertext => $elements[1]->value
            ];
        }

        $this->school_year_arr = $data;
    }

    private function _formatToUnOfficialSchoolYear ()
    {
        $arr = [];
        foreach ($this->school_year_arr as $school_year)
        {
            $arr[] = SharedFunctions::formatToUnOfficialSchoolYear($school_year);
        }

        $this->school_year_arr = $arr;
    }

    private function _getDataExamSchedule () : array
    {
        $data = [];
        foreach ($this->school_year_arr as $school_year_key => $school_year_value)
        {
            $this->form_crawl_request['drpSemester'] = $school_year_value;

            $response = $this->_postRequest($this->url_student_exam_schedule, $this->form_crawl_request);
            $html     = new simple_html_dom();
            $html->load($response);
            $exam_type_by_shtmldom = $html->find('select[id=drpDotThi] option');

            $response = mb_convert_encoding($response, 'HTML-ENTITIES', "UTF-8");
            $dom      = new DOMDocument();
            @$dom->loadHTML($response);
            $exam_type_by_dom_document = $dom->getElementById('drpDotThi');

            $exam_type = [];
            $j         = 1;
            for ($i = 3; $i < $exam_type_by_dom_document->childNodes->count(); $i += 2)
            {
                $exam_type[$i - (2 + $j)][] = $exam_type_by_dom_document->childNodes->item($i)->textContent;
                $exam_type[$i - (2 + $j)][] = $exam_type_by_shtmldom[$i - ($j + 1)]->value;
                $j++;
            }

            $exam_type_selected = $html->find('select[id=drpDotThi] option[selected=selected]', 0)->value;
            for ($i = count($exam_type) - 1; $i >= 0; $i--)
            {
                if ($exam_type[$i][1] != $exam_type_selected)
                {
                    $this->form_crawl_request['drpDotThi']         = $exam_type[$i][1];
                    $this->form_crawl_request['__EVENTTARGET']     = 'drpDotThi';
                    $this->form_crawl_request['__VIEWSTATE']       = $html->find('input[name=__VIEWSTATE]', 0)->value;
                    $this->form_crawl_request['__EVENTVALIDATION'] = $html->find('input[name=__EVENTVALIDATION]',
                                                                                 0)->value;

                    $response = $this->_postRequest($this->url_student_exam_schedule, $this->form_crawl_request);
                    $html->load($response);

                    $this->form_crawl_request['__EVENTTARGET'] = 'drpSemester';
                    $this->form_crawl_request['drpDotThi']     = '';
                }

                $flag = $html->find('table[id=tblCourseList] tr', 1);
                if (empty($flag))
                {
                    continue;
                }

                $tr = $html->find('table[id=tblCourseList] tr');
                for ($j = 1; $j < count($tr) - 1; $j++)
                {
                    $arr = [];

                    $arr['school_year'] = SharedFunctions::formatToOfficialSchoolYear($school_year_key);

                    $temp_examination   = SharedFunctions::formatWrongWord($exam_type[$i][0]);
                    $arr['examination'] = SharedFunctions::formatStringDataCrawled($temp_examination);

                    $arr['id_student'] = $this->id_student;

                    $arr['id_module'] = SharedFunctions::formatStringDataCrawled($tr[$j]->children(1)->innertext);

                    $arr['module_name'] = SharedFunctions::formatStringDataCrawled($tr[$j]->children(2)->innertext);

                    $arr['credit'] = SharedFunctions::formatStringDataCrawled($tr[$j]->children(3)->innertext);

                    $temp_date         = SharedFunctions::formatStringDataCrawled($tr[$j]->children(4)->innertext);
                    $arr['date_start'] = SharedFunctions::formatDate($temp_date);

                    $arr['time_start'] = SharedFunctions::formatStringDataCrawled($tr[$j]->children(5)->innertext);

                    $arr['method'] = SharedFunctions::formatStringDataCrawled($tr[$j]->children(6)->innertext);

                    $arr['identification_number'] = SharedFunctions::formatStringDataCrawled($tr[$j]->children(7)->innertext);

                    $temp_room   = SharedFunctions::formatWrongWord($tr[$j]->children(8)->innertext);
                    $arr['room'] = SharedFunctions::formatStringDataCrawled($temp_room);

                    $data[SharedFunctions::formatToOfficialSchoolYear($school_year_key)][] = $arr;
                }
            }
        }

        if (empty($data))
        {
            foreach ($this->school_year_arr as $school_year_key => $school_year_value)
            {
                $data[SharedFunctions::formatToOfficialSchoolYear($school_year_key)] = [];
                break;
            }
        }

        return $data;
    }

    private function _formatModuleScoreData ($data) : array
    {
        $temp = [];
        foreach ($this->school_year_arr as $school_year)
        {
            if (strlen(trim($school_year, ' ')) == 7)
            {
                $temp[] = $school_year;
            }
        }

        sort($temp);
        foreach ($temp as $e)
        {
            foreach ($data[$e] as $module)
            {
                $official_school_year = SharedFunctions::convertToOfficialSchoolYear(trim($e, ' '));

                if (isset($data[$official_school_year][$module['id_module']]))
                {
                    $dupl_evaluation    = $data[$official_school_year][$module['id_module']]['evaluation'];
                    $dupl_process_score = $data[$official_school_year][$module['id_module']]['process_score'];
                    $dupl_test_score    = $data[$official_school_year][$module['id_module']]['test_score'];
                    $dupl_theore_score  = $data[$official_school_year][$module['id_module']]['final_score'];

                    $module['evaluation']    = $dupl_evaluation == null ? $module['evaluation'] : $dupl_evaluation;
                    $module['process_score'] = $dupl_process_score == null ? $module['process_score'] : $dupl_process_score;
                    $module['test_score']    = $dupl_test_score == null ? $module['test_score'] : $dupl_test_score;
                    $module['final_score']   = $dupl_theore_score == null ? $module['final_score'] : $dupl_theore_score;
                }

                $module['school_year'] = $official_school_year;

                $data[$official_school_year][$module['id_module']] = $module;
            }
            unset($data[$e]);
        }

        return $data;
    }
}
