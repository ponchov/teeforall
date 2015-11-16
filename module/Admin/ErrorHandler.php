<?php
/*
 * this class deals with error specific code, such as defining the path to log the errors to
 * 
 * @author Jimmy
 */
namespace Error;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class ErrorHandler 
{
    const ERROR_PATH = './data/errors/error.log';
    
    private static function errorWriter($message)
    {
        // log the message to the error file
        $writer = new Stream(ErrorHandler::ERROR_PATH);
        $logger = new Logger();
        $logger->addWriter($writer);
         
        $logger->info($message . "\r\r");
    }
}