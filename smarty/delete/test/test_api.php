<?php
/**
 * テストAPI
 */

if($_SERVER['REQUEST_METHOD'] === 'GET') {

    require_once("../product/Config.php");
    require_once("../product/Logger.php");

    try {
        $log = Logger::getInstance();
        $log->error('error log.');
        $log->warn('warn log.');
        $log->info('info log.');
        $log->debug('debug log.');

        echo 'test_api called.';
    } catch(Exception $ex) {
        echo $ex->getMessage();
    }
}

?>