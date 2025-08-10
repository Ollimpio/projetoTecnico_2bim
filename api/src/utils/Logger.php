<?php
    class Logger{
        private static string $LOG_FILE = "system/log.log";
        
        public static function log(Throwable $throwable): void
        {
            $message = "\nThrowable trown \n";
            $message.= "Message: ". $throwable->getMessage()."\n";
            $message.= "Code: ". $throwable->getCode()."\n";
            $message.= "File: ". $throwable->getFile()."\n";
            $message.= "Line: ". $throwable->getLine()."\n";
            $message.= "Trace: ". $throwable->getTraceAsString();
            self::writeLog(type:"Throwable", message: $message);
        }
        public static function writeLog(string $type, string $message): void
        {
            $diretoryPath = dirname(path: self::$LOG_FILE);
            if (!is_dir(filename:$diretoryPath)){
                mkdir(directory:$diretoryPath,permissions:0777, recursive:true);
            }
            $dateTime = date(format: 'Y-m-d H:i:s.v');
            $separador = str_repeat("*", 100);
            $entry = "\n[$dateTime] [$type] \n $message \n $separador";
            file_put_contents(filename: self::$LOG_FILE, data: $entry, flags: FILE_APPEND | LOCK_EX );

        }
    }

?>