<?php


namespace App\Services\Guest;


use App\BusinessClass\CrawlQLDTData;
use App\Depositories\Contracts\GuestInfoDepositoryContract;
use App\Services\Contracts\Guest\LoginGuestServiceContract;
use Exception;

class LoginGuestService implements LoginGuestServiceContract
{
    private CrawlQLDTData $crawl;
    private GuestInfoDepositoryContract $guestInfoDepository;

    /**
     * LoginGuestService constructor.
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
    public function login ($id_student, $password)
    {
        $hash_password = md5($password);
        switch ($this->_verifyAccount($id_student, $hash_password))
        {
            case -1:
                throw new Exception();

            case 0;
                return response('Invalid Password', 401);

            case 1;
                $this->_createGuestData($id_student, $hash_password);
                return $this->_getGuestInfo($id_student);

            default:
                throw new Exception();
        }
    }

    private function _verifyAccount ($id_student, $password): int
    {
        return $this->crawl->loginQLDT($id_student, $password);
    }

    private function _getInfo (): array
    {
        return $this->crawl->getStudentInfo();
    }

    private function _createGuestData ($id_student, $password)
    {
        $data               = $this->_getInfo();
        $data['ID_Student'] = $id_student;
        $data['Password']   = $password;
        $this->_upsertGuestData($data);
    }

    private function _upsertGuestData ($data)
    {
        $this->guestInfoDepository->upsert($data);
    }

    private function _getGuestInfo ($id_student)
    {
        return $this->guestInfoDepository->get($id_student);
    }
}
