<?php
function logError(Exception $e):void{
    error_log($e->getMessage().'---'.date('Y-m-d H:i:s'."\n"), 3,'log/database_log');
    echo 'An error with the DB has occured'.'<br>';
}