<?php
    class Database{
        private const HOST = '127.0.0.1';
        private const USER = 'root';
        private const DATABASE = 'projeto_web';
        private const PASSWORD = '';
        private const PORT= 3306;
        private const CHARACTER_SET = 'utf8mb4';
        private static ?PDO $CONNECTION = null;

        
        private static function connect():PDO{
            Database::$CONNECTION = new PDO(
                dsn: sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
                Database::HOST,
                Database::PORT,
                Database::DATABASE,
                Database::CHARACTER_SET
            ),
            username: Database::USER,
            password: Database::PASSWORD,
            options: [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]
            );

            return Database::$CONNECTION;
        }
        public static function getConnection():PDO|null{
            if (Database::$CONNECTION == null){
                Database::connect();
            }
            return Database::$CONNECTION;
        }
    }
    
?>