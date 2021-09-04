<?php
class debugger{
    public function _debug( $data, $clear_log = false ) {
        $uri_debug_file = $_SERVER['DOCUMENT_ROOT'] . '/log/debug.log';
        if( $clear_log ){
          file_put_contents($uri_debug_file, print_r('', true));
        }
        file_put_contents($uri_debug_file, print_r($data,true), FILE_APPEND);
    }
}
?>