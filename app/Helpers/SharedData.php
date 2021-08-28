<?php

namespace App\Helpers;

class SharedData
{
    public static array $faculty_class_info = [
        'MXD'          => ['Class_Name' => 'Lớp Máy xây dựng',
                           'ID_Faculty' => 'CK'],
        'CDT'          => ['Class_Name' => 'Lớp Cơ điện tử',
                           'ID_Faculty' => 'CK'],
        'CNCTCK'       => ['Class_Name' => 'Lớp Công nghệ chế tạo cơ khí',
                           'ID_Faculty' => 'CK'],
        'TDHTKCK'      => ['Class_Name' => 'Lớp Tự động hoá thiết kế cơ khí',
                           'ID_Faculty' => 'CK'],
        'CKOTO'        => ['Class_Name' => 'Lớp Cơ khí ô tô',
                           'ID_Faculty' => 'CK'],
        'VLVH.CNTT'    => ['Class_Name' => 'Lớp Công nghệ thông tin (Hệ vừa làm vừa học)',
                           'ID_Faculty' => 'CNTT'],
        'CNTT'         => ['Class_Name' => 'Lớp Công nghệ thông tin',
                           'ID_Faculty' => 'CNTT'],
        'DBO'          => ['Class_Name' => 'Lớp Đường bộ',
                           'ID_Faculty' => 'CT'],
        'CH2'          => ['Class_Name' => 'Lớp Kỹ thuật xây dựng cầu - hầm',
                           'ID_Faculty' => 'CT'],
        'DHMETRO'      => ['Class_Name' => 'Lớp Kỹ thuật xây dựng đường hầm và metro',
                           'ID_Faculty' => 'CT'],
        'CDBO'         => ['Class_Name' => 'Lớp Kỹ thuật cầu đường bộ',
                           'ID_Faculty' => 'CT'],
        'CDS'          => ['Class_Name' => 'Lớp Kỹ thuật cầu đường sắt',
                           'ID_Faculty' => 'CT'],
        'CTGTCC'       => ['Class_Name' => 'Lớp Công trình giao thông công chính',
                           'ID_Faculty' => 'CT'],
        'DSDT'         => ['Class_Name' => 'Lớp Kỹ thuật đường sắt đô thị',
                           'ID_Faculty' => 'CT'],
        'KTGIS'        => ['Class_Name' => 'Lớp Kỹ thuật GIS và trắc địa công trình giao thông',
                           'ID_Faculty' => 'CT'],
        'TDH'          => ['Class_Name' => 'Lớp Tự động hoá thiết kế cầu đường',
                           'ID_Faculty' => 'CT'],
        'CH'           => ['Class_Name' => 'Lớp Kỹ thuật xây dựng cầu - hầm',
                           'ID_Faculty' => 'CT'],
        'KTXDCTGT(QT)' => ['Class_Name' => 'Lớp Kỹ thuật xây dựng công trình giao thông (QT)',
                           'ID_Faculty' => 'CT'],
        'KTDTTHCN'     => ['Class_Name' => 'Lớp Kỹ thuật điện tử và tin học công nghiệp',
                           'ID_Faculty' => 'DDT'],
        'TBD'          => ['Class_Name' => 'Lớp Trang bị điện trong công nghiệp và giao thông',
                           'ID_Faculty' => 'DDT'],
        'CH1'          => ['Class_Name' => 'Lớp Kỹ thuật xây dựng cầu - hầm',
                           'ID_Faculty' => 'DDT'],
        'KTĐK&TDH'     => ['Class_Name' => 'Kỹ thuật điều khiển và tự động hoá',
                           'ID_Faculty' => 'DDT'],
        'KCXD'         => ['Class_Name' => 'Lớp Kết cấu xây dựng',
                           'ID_Faculty' => 'KTXD'],
        'KTHTDT'       => ['Class_Name' => 'Lớp Kỹ thuật hạ tầng đô thị',
                           'ID_Faculty' => 'KTXD'],
        'XDDDCN'       => ['Class_Name' => 'Lớp Xây dựng dân dụng và công nghiệp',
                           'ID_Faculty' => 'KTXD'],
        'VLCNXDGT'     => ['Class_Name' => 'Lớp Vật liệu và công nghệ xây dựng',
                           'ID_Faculty' => 'KTXD'],
        'QTDNVT'       => ['Class_Name' => 'Lớp Quản trị doanh nghiệp vận tải',
                           'ID_Faculty' => 'VTKT'],
        'KTVTDL'       => ['Class_Name' => 'Lớp Kinh tế vận tải và du lịch',
                           'ID_Faculty' => 'VTKT'],
        'KTVTOTO'      => ['Class_Name' => 'Lớp Kinh tế vận tải ô tô',
                           'ID_Faculty' => 'VTKT'],
        'QTDNBCVT'     => ['Class_Name' => 'Lớp Quản trị doanh nghiệp bưu chính viễn thông',
                           'ID_Faculty' => 'VTKT']
    ];

    public static array $faculties = [
        'CT' => [
            'Kỹ thuật xây dựng công trình giao thông (59)',
            'Kỹ thuật xây dựng công trình giao thông',
            'Kỹ thuật xây dựng Cầu - Đường bộ',
            'Kỹ thuật xây dựng Đường bộ',
            'Kỹ thuật Giao thông đường bộ',
            'Kỹ thuật xây dựng Đường sắt đô thị',
            'Kỹ thuật xây dựng Đường sắt',
            'Kỹ thuật xây dựng Cầu hầm',
            'Kỹ thuật xây dựng Đường hầm - Metro',
            'Kỹ thuật xây dựng Cầu - Đường sắt',
            'Địa kỹ thuật xây dựng Công trình giao thông',
            'Công trình Giao thông đô thị',
            'Kỹ thuật xây dựng Đường ô tô & Sân bay',
            'Kỹ thuật xây dựng Cầu đường ô tô & Sân bay',
            'Công trình Giao thông công chính',
            'Tự động hóa Thiết kế cầu đường',
            'Kỹ thuật GIS và Trắc địa CTGT',
            'Kỹ thuật xây dựng Công trình thủy'
        ],

        'QLXD' => [
            'Kinh tế xây dựng',
            'Kinh tế xây dựng Công trình giao thông',
            'Kinh tế quản lý khai thác cầu đường',
            'Quản lý xây dựng'
        ],

        'VTKT' => [
            'Kinh tế vận tải',
            'Khai thác vận tải',
            'Quản trị kinh doanh',
            'Kinh tế',
            'Kế toán',
            'Kinh tế vận tải du lịch',
            'Kinh tế vận tải hàng không',
            'Kinh tế vận tải ô tô',
            'Kinh tế vận tải đường sắt',
            'Kinh tế vận tải thủy bộ',
            'Điều khiển các quá trình vận tải',
            'Khai thác và quản lý đường sắt đô thị',
            'Tổ chức quản lý khai thác cảng hàng không',
            'Vận tải đa phương thức',
            'Vận tải đường sắt',
            'Vận tải kinh tế đường bộ và thành phố',
            'Vận tải thương mại quốc tế',
            'Quy hoạch và quản lý GTVT đô thị',
            'Vận tải và kinh tế đường sắt',
            'Logistics',
            'Quản trị doanh nghiệp vận tải',
            'Quản trị doanh nghiệp xây dựng',
            'Quản trị kinh doanh GTVT',
            'Quản trị doanh nghiệp Bưu chính viễn thông',
            'Quản trị Logistics',
            'Kế toán',
            'Kinh tế Bưu chính viễn thông'
        ],

        'KTXD' => [
            'Kỹ thuật xây dựng',
            'Xây dựng dân dụng và Công nghiệp',
            'Kết cấu xây dựng',
            'Kỹ thuật hạ tầng đô thị',
            'Vật liệu và Công nghiệp xây dựng'
        ],

        'DDT' => [
            'Kỹ thuật điện',
            'Kỹ thuật điều khiển và tự động hóa',
            'Kỹ thuật điện tử viễn thông',
            'Trang thiết bị trong Công nghiệp và Giao thông',
            'Hệ thống điện Giao thông và Công nghiệp',
            'Kỹ thuật điều khiển và Tự động hóa GT',
            'Kỹ thuật tín hiệu Đường sắt',
            'Tự động hóa',
            'Thông tin tín hiệu',
            'Kỹ thuật điện tử và Tin học công nghiệp',
            'Kỹ thuật thông tin và truyền thông',
            'Kỹ thuật viễn thông'
        ],

        'CK' => [
            'Kỹ thuật cơ khí động lực',
            'Kỹ thuật cơ khí',
            'Kỹ thuật ô tô',
            'Kỹ thuật nhiệt',
            'Đầu máy toa xe',
            'Cơ giới hóa xây dựng cầu đường',
            'Cơ khí giao thông công chính',
            'Đầu máy',
            'Kỹ thuật Máy động lực',
            'Máy xây dựng',
            'Tàu điện Metro',
            'Thiết bị mặt đất Cảng hàng không',
            'Toa xe',
            'Công nghệ chế tạo cơ khí',
            'Cơ điện tử',
            'Tự động hóa thiết kế cơ khí',
            'Kỹ thuật ô tô',
            'Kỹ thuật nhiệt lạnh',
            'Điều hòa không khí và thông gió công trình XD'
        ],

        'CNTT' => [
            'Công nghệ thông tin'
        ],

        'MT&ATGT' => [
            'Kỹ thuật An toàn giao thông',
            'Kỹ thuật môi trường'
        ],

        'KHCB' => [
            'Toán ứng dụng'
        ]
    ];

    public static array $form_login_request = [
        '__EVENTTARGET'              => '',
        '__EVENTARGUMENT'            => '',
        '__LASTFOCUS'                => '',
        '__VIEWSTATE'                => '/wEPDwUKMTkwNDg4MTQ5MQ9kFgICAQ9kFgpmD2QWCgIBDw8WAh4EVGV4dAUuSOG7hiBUSOG7kE5HIFRIw5RORyBUSU4gVFLGr+G7nE5HIMSQ4bqgSSBI4buMQ2RkAgIPZBYCZg8PFgQfAAUNxJDEg25nIG5o4bqtcB4QQ2F1c2VzVmFsaWRhdGlvbmhkZAIDDxAPFgYeDURhdGFUZXh0RmllbGQFBmt5aGlldR4ORGF0YVZhbHVlRmllbGQFAklEHgtfIURhdGFCb3VuZGdkEBUBAlZOFQEgQUU1NjE5NjI2OUFGNDQ3NkI0MjIwNjdDOUI0MjQ1MDQUKwMBZxYBZmQCBA8PFgIeCEltYWdlVXJsBSgvQ01DU29mdC5JVS5XZWIuSW5mby9JbWFnZXMvVXNlckluZm8uZ2lmZGQCBQ9kFgYCAQ8PFgIfAAUGS2jDoWNoZGQCAw8PFgIfAGVkZAIHDw8WAh4HVmlzaWJsZWhkZAICD2QWBAIDDw9kFgIeBm9uYmx1cgUKbWQ1KHRoaXMpO2QCBw8PFgIfAGVkZAIEDw8WAh8GaGRkAgYPDxYCHwZoZBYGAgEPD2QWAh8HBQptZDUodGhpcyk7ZAIFDw9kFgIfBwUKbWQ1KHRoaXMpO2QCCQ8PZBYCHwcFCm1kNSh0aGlzKTtkAgsPZBYIZg8PFgIfAAUJRW1wdHlEYXRhZGQCAQ9kFgJmDw8WAh8BaGRkAgIPZBYCZg8PFgQfAAUNxJDEg25nIG5o4bqtcB8BaGRkAgMPDxYCHwAFtgU8YSBocmVmPSIjIiBvbmNsaWNrPSJqYXZhc2NyaXB0OndpbmRvdy5wcmludCgpIj48ZGl2IHN0eWxlPSJGTE9BVDpsZWZ0Ij4JPGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9wcmludC5wbmciIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkluIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0ibWFpbHRvOj9zdWJqZWN0PUhlIHRob25nIHRob25nIHRpbiBJVSZhbXA7Ym9keT1odHRwczovL3FsZHQudXRjLmVkdS52bi9DTUNTb2Z0LklVLldlYi5JbmZvL0xvZ2luLmFzcHgiPjxkaXYgc3R5bGU9IkZMT0FUOmxlZnQiPjxpbWcgc3JjPSIvQ01DU29mdC5JVS5XZWIuSW5mby9pbWFnZXMvc2VuZGVtYWlsLnBuZyIgIGJvcmRlcj0iMCI+PC9kaXY+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdDtQQURESU5HLVRPUDo2cHgiPkfhu61pIGVtYWlsIHRyYW5nIG7DoHk8L2Rpdj48L2E+PGEgaHJlZj0iIyIgb25jbGljaz0iamF2YXNjcmlwdDphZGRmYXYoKSI+PGRpdiBzdHlsZT0iRkxPQVQ6bGVmdCI+PGltZyBzcmM9Ii9DTUNTb2Z0LklVLldlYi5JbmZvL2ltYWdlcy9hZGR0b2Zhdm9yaXRlcy5wbmciICBib3JkZXI9IjAiPjwvZGl2PjxkaXYgc3R5bGU9IkZMT0FUOmxlZnQ7UEFERElORy1UT1A6NnB4Ij5UaMOqbSB2w6BvIMawYSB0aMOtY2g8L2Rpdj48L2E+ZGRkyoG6tKOetejm3INvwYKVBbOLz1ENP/MgKbfNBVLLTF4=',
        '__VIEWSTATEGENERATOR'       => 'D620498B',
        '__EVENTVALIDATION'          => '/wEdAA/vKet7wh+YewIm1y/+I4jpb8csnTIorMPSfpUKU79Fa8zr1tijm/dVbgMI0MJ/5MgoRSoZPLBHamO4n2xGfGAWHW/isUyw6w8trNAGHDe5T/w2lIs9E7eeV2CwsZKam8yG9tEt/TDyJa1fzAdIcnRuY3plgk0YBAefRz3MyBlTcHY2+Mc6SrnAqio3oCKbxYY85pbWlDO2hADfoPXD/5tdAxTm4XTnH1XBeB1RAJ3owlx3skko0mmpwNmsvoT+s7J0y/1mTDOpNgKEQo+otMEzMS21+fhYdbX7HjGORawQMqpdNpKktwtkFUYS71DzGv7vyGkQfdybHrb/DRlkBCRcuPrNRMkgMJV6Y3cQGV72Nw==',
        'PageHeader1$drpNgonNgu'     => 'AE56196269AF4476B422067C9B424504',
        'PageHeader1$hidisNotify'    => '0',
        'PageHeader1$hidValueNotify' => '.',
        'txtUserName'                => '',
        'txtPassword'                => '',
        'btnSubmit'                  => 'Đăng nhập',
        'hidUserId'                  => '',
        'hidUserFullName'            => ''
    ];

    public static array $form_get_mark_request = [
        '__EVENTTARGET'              => 'drpHK',
        '__EVENTARGUMENT'            => '',
        '__LASTFOCUS'                => '',
        '__VIEWSTATE'                => '',
        '__VIEWSTATEGENERATOR'       => 'C7A1B26E',
        '__EVENTVALIDATION'          => '',
        'PageHeader1$drpNgonNgu'     => 'AE56196269AF4476B422067C9B424504',
        'PageHeader1$hidisNotify'    => '0',
        'PageHeader1$hidValueNotify' => '.',
        'drpField'                   => '36E0D94B3AE842FEB692AC231A7C434A',
        'drpHK'                      => '',
        'drpFilter'                  => '1',
        'hidSymbolMark'              => '0',
        'hidFieldId'                 => '36E0D94B3AE842FEB692AC231A7C434A',
        'hidFieldName'               => 'Công nghệ thông tin',
        'hidStudentId'               => ''
    ];

    public static array $form_get_exam_schedule_request = [
        '__EVENTTARGET'                 => 'drpSemester',
        '__EVENTARGUMENT'               => '',
        '__LASTFOCUS'                   => '',
        '__VIEWSTATE'                   => '',
        '__VIEWSTATEGENERATOR'          => 'C663F6BA',
        '__EVENTVALIDATION'             => '',
        'PageHeader1$drpNgonNgu'        => 'AE56196269AF4476B422067C9B424504',
        'PageHeader1$hidisNotify'       => '0',
        'PageHeader1$hidValueNotify'    => '.',
        'drpSemester'                   => '',
        'drpDotThi'                     => '',
        'drpExaminationNumber'          => '0',
        'hidShowShiftEndTime'           => '0',
        'hidExamShowNote'               => '',
        'hidStudentId'                  => '',
        'hidEsShowRoomCode'             => '',
        'hidDangKyChungChiThuocHeRieng' => ''
    ];
}
