<?php
class auth
{
    static function authorization($rqUri)
    {

        if (str_starts_with($rqUri, '/member') || str_starts_with($rqUri, '/admin')) {

            if ($_SESSION['userinfo'] ?? '') {

                if (str_starts_with($rqUri, '/admin')) {
                    if ($_SESSION['userinfo']['is_admin']) {
                    } else {
                        require_once "../templates/admin/header.php";

                        echo "Ban khong the truy cap trang admin!!!!";

                        require_once "../templates/admin/footer.php";
                        return 0;
                    }
                }
            } else {
                require_once "../templates/admin/header.php";

                echo "Ban khong the truy cap trang nay!!!!";

                require_once "../templates/admin/footer.php";

                return 0;
            }
        }
        return 1;
    }
}
