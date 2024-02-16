<?
    class Auth{
        /*
            Kiểm tra đăng nhập
        */
        public static function isLoggedIn(){
            return isset($_SESSION['logged_in']) && $_SESSION['logged_in'];
        }

        /* Bắt buộc đăng nhập */
        public static function requireLogin(){
            if(!static::isLoggedIn()){
                die('Please login to continue !');
            }
        }

        /* Xử lý đăng nhập */
        public static function login(){
            session_regenerate_id(true);
            $_SESSION['logged_in'] = true;
        }
        /* Xử lý đăng xuất */
        public static function logout(){
            if(ini_get("session.use_cookies")){
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }
            session_destroy();
        }
    }
?>