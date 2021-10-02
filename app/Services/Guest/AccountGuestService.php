<?php


namespace App\Services\Guest;


use App\BusinessClass\CrawlQLDTData;
use App\Repositories\Contracts\GuestInfoDepositoryContract;
use App\Services\Contracts\Guest\AccountGuestServiceContract;
use Exception;

class AccountGuestService implements AccountGuestServiceContract
{
    private CrawlQLDTData $crawl;
    private GuestInfoDepositoryContract $guestInfoDepository;

    /**
     * AccountGuestService constructor.
     * @param CrawlQLDTData $crawl
     * @param GuestInfoDepositoryContract $guestInfoDepository
     */
    public function __construct (CrawlQLDTData $crawl, GuestInfoDepositoryContract $guestInfoDepository)
    {
        $this->crawl               = $crawl;
        $this->guestInfoDepository = $guestInfoDepository;
    }

    /**
     * @throws Exception
     */
    public function updatePassword ($id_student, $password)
    {
        $hash_password = md5($password);
        switch ($this->_verifyAccount($id_student, $hash_password))
        {
            case -1:
                throw new Exception();

            case 0;
                return response('Invalid Password', 401);

            case 1;
                $this->guestInfoDepository->updatePassword($id_student, $hash_password);
                return response('OK');

            default:
                throw new Exception();
        }
    }

    private function _verifyAccount ($id_student, $password): int
    {
        return $this->crawl->loginQLDT($id_student, $password);
    }

    public function updateDeviceToken ($id_student, $device_token)
    {
        $this->guestInfoDepository->updateDeviceToken($id_student, $device_token);
    }

    public function getPassword ($id_student)
    {
        return $this->guestInfoDepository->getPassword($id_student);
    }

    public function getDeviceTokens ($id_faculty_list, $academic_year_list)
    {
        return $this->guestInfoDepository->getDeviceTokens();
    }
}
