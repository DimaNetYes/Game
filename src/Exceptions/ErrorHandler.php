<?php
/**
 * Created by PhpStorm.
 * User: McCalister
 * Date: 10.09.2020
 * Time: 22:58
 */

namespace Exceptions;


class ErrorHandler extends \ErrorException
{
    public function register()
    {
        set_error_handler([$this, 'myError']);
        register_shutdown_function([$this, 'fatalErrorHandler']);
//        error_reporting(0);
//        error_log($str, 3, 'error.log');
    }

    public function myError($errno, $msg, $file, $line)
    {
        $this->showError($errno, $msg, $file, $line);
        return true;
    }

    public function fatalErrorHandler()
    {
        if(!empty($error = error_get_last())) {
            ob_get_clean();
            $this->showError($error['type'], $error['message'], $error['file'], $error['line']);
        }
        error_log('asdfzxcv', 3, 'error.log');
    }

    protected function showError($errno, $msg, $file, $line, $status = 500)
    {
        header("HTTP/1.1 {$status}");
        $dt = date("d-m-Y H:i:s");
        $str = "[$dt] - $msg in $file:$line\n";
        echo "Something wrong <a href='/www/'>Backward</a>";
        exit();
    }

}