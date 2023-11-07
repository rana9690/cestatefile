<?php
//namespace Libraries;
//use \Exception;
/**
 * Created by PhpStorm.
 * User: nic
 * Date: 14-03-2023
 * Time: 09:16 AM
 */
/**
 * Exception handler for PHPMailer
 * @package PHPMailer
 */
class PhpmailerException extends Exception {
    /**
     * Prettify error message output
     * @return string
     */
    public function errorMessage() {
        $errorMsg = '<strong>' . $this->getMessage() . "</strong><br />\n";
        return $errorMsg;
    }
}
