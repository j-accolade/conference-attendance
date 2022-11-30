<?php
    class user{
        //private database object
        private $db;
        
        //constructor to initialize private variable to the database connection
        function __construct($conn){
            $this->db = $conn;
        }


        public function insertUser($username, $password){
            try {
                $result = $this -> getUserByUsername($username);
                if ($result['num'] > 0) {
                    return false;
                }else{
                    $new_password = md5($password.$username);
                    $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
                    $stmt = $this -> db -> prepare($sql);
                    
                    $stmt -> bindparam(':username',$username);
                    $stmt -> bindparam(':password',$new_password);

                    $stmt -> execute();
                    return true;

                }
            } catch (PDOException $e) {
                echo $e -> getMessage();
                return false;
            }
        }

        public function getUser($username, $password){
            try {
                $sql = "SELECT * FROM user WHERE username = :username AND password = :password";
                $stmt = $this -> db -> prepare($sql);

                $stmt -> bindparam(':username', $username);
                $stmt -> bindparam(':password', $username);
                
                $stmt -> execute();
                $result = $stmt -> fetch();
                return $result;

            } catch (PDOException $e) {
                echo $e -> getMessage();
            }
        }

        public function getUserByUsername($username){
            try {
                $sql = "SELECT COUNT(*) AS num FROM user where username = :username";
                $stmt = $this -> db -> prepare($sql);
    
                $stmt -> bindparam(':username',$username);
                $stmt -> execute();
                $result = $stmt -> fetch();
                return $result;
            } catch (PDOException $e) {
                echo $e -> getMessage();
            }

        }

    }  
?>