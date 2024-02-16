<?
    class User{
        public $id;
        public $username;
        public $password;
        // Construction
        public function __construct($username ='', $password ='')
        {
            if($username != '' && $password != '')
            $this->username = $username;
            $this->password = $password;
        }
        // Authentication
        public static function authenticate($conn, $username, $password) {
            try {
                $sql = "SELECT * FROM users WHERE username = :username";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                $stmt->execute();
                $user = $stmt->fetch();
        
                if ($user) {
                    $hash = $user->password;
                    return password_verify($password, $hash);
                } else {
                    return false; // User not found
                }
            } catch (PDOException $e) {
                // Handle database errors
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
        // Phương thức kiểm tra nhập dữ liệu
        protected function validate(){
            $rs = $this->username != '' && $this->password != '';
            return $rs;
        }
        // Add user
        public function addUser($conn){
            if($this->validate()){
                // Tạo câu lệnh insert chống SQL injection
                $sql = "insert into users(username, password) values(:username,:password);";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
                $hash = password_hash($this->password, PASSWORD_DEFAULT);
                $stmt->bindValue(':password', $hash, PDO::PARAM_STR);
                return $stmt->execute();
            }
            else{
                return false;
            }
        }

    }
?>