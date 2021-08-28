<?php

    namespace App\Depositories;

    use App\Depositories\Contracts\NotificationAccountDepositoryContract;
    use App\Helpers\SharedFunctions;
    use App\Models\NotificationAccount;
    use Illuminate\Support\Collection;

    class NotificationAccountDepository implements NotificationAccountDepositoryContract
    {
        // NotificationAccount Model
        private NotificationAccount $model;

        public function __construct (NotificationAccount $model)
        {
            $this->model = $model;
        }

        public function insertMultiple ($id_account_list, $id_notification)
        {
            if (empty($id_account_list)) {
                return;
            }

            $data = SharedFunctions::setUpNotificationAccountData($id_account_list, $id_notification);
            $this->model->insertMultiple($data);
        }

        public function getIDAccounts ($id_notification_list) : array
        {
            return $this->model->getIDAccounts($id_notification_list);
        }

        public function getNotifications ($id_account, $id_notification = '0') : array
        {
            return $this->model->getNotifications($id_account, $id_notification);
        }
    }
