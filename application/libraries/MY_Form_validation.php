<?php

class MY_Form_validation extends CI_Form_validation {

    public function iis_unique($str, $field)
    {

        // Grab any data for exclusion of a single row.
        list($field, $ignoreField, $ignoreValue) = array_pad(explode(',', $field), 3, null);

        // Break the table and field apart
        sscanf($field, '%[^.].%[^.]', $table, $field);
        if ( ! empty($ignoreField) && ! empty($ignoreValue))
        {
            if ($ignoreValue[0] == '{') {
                $key = substr($ignoreValue, 1, -1);
                //echo $_REQUEST[$key];
                if (isset($this->CI->input->post()[$key]))
                    // if (isset($data[$key]))
                    // $ignoreValue = $data[$key];
                    $ignoreValue = $this->CI->input->post()[$key];
            }
            $arr=array("$ignoreField !=$ignoreValue"=>null,$field => $str);
            $row=$this->CI->db->limit(1)->where($arr)->get($table);
        }

        return (bool) ($row->row() === null);
    }
    public function isnew_unique($str, $field)
    {
        $this->set_message('isnew_unique', 'This mobile no is already registered.');
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str,'status1<9'=>null))->num_rows() === 0)
            : FALSE;
    }
    public function check_pass($pass)
    {
        // It's a good practice to make sure each validation rule does
        // its own job. So we decide that this callback does not check
        // for the password field being required. If we need so, we just
        // prepend the "required" rule. For example: "required|min_length[8]|check_pass"
        //
        // So we just let it go if the value is empty:
        if (empty($pass))
        {
            return TRUE;
        }

        // This sets the error message for your custom validation
        // rule. %s will be replaced with the field name if needed.
        $this->set_message('check_pass', 'Password needs to have at least one uppercase letter and a number.');

        // The regex looks ahead for at least one lowercase letter,
        // one uppercase letter and a number. IT'S NOT TESTED THOUGH.
        return (bool) preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $pass);
    }



    /**
     * Checks for a valid date and matches a given date format
     */
   public function valid_date($str,$format)
    {
       // die(123);

        if (empty($format)) {
            return strtotime($str) !== false;
        }

        $date   = DateTime::createFromFormat($format, $str);
        $errors = DateTime::getLastErrors();

        return $date !== false && $errors !== false && $errors['warning_count'] === 0 && $errors['error_count'] === 0;

    }
    /*
     * first date less then today date
     *
     * */
    public function check_equal_less_date($str)
    {
        $today = strtotime(date("Y-m-d"));
        $first_date = strtotime($str);

        if ( ($str != "") && ($first_date > $today) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    public function check_equal_greater_date($str)
    {
        $today = strtotime(date("Y-m-d"));
        $first_date = strtotime($str);

        if ( ($str != "") && ($today > $first_date) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    /*
     * first date less then second date
     *
     * */
    public function check_greater_then_firstDate($str,$first_date)
    {
         $first_date=$this->_field_data[$first_date]['postdata'];
        if ( ($first_date != "") && ($str != "") && (strtotime($first_date) > strtotime($str)) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    /*
     * first number less then second number
     *
     * */
    public function check_greater_then_Number($str,$first_num)
    {
        $first_number=$this->_field_data[$first_num]['postdata'];
        if ( ($first_number != "") && ($str != "") && ($first_number > strtotime($str)) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }
	
	public function valid_pan($str)
    {

        if (! preg_match('~^([A-Z]{5}[0-9]{4}[A-Z]{1})~',strtoupper($str)))
        {
            return false;
        }
        return true;
    }
    public function valid_adhar($str)
    {

        if (! preg_match('~^([2-9]{1}[0-9]{3}\\s[0-9]{4}\\s[0-9]{4})~',strtoupper($str)))
        {
            return false;
        }
        return true;
    }
    public function valid_voterID($str)
    {

        if (! preg_match('~^([A-Z]{3}\d{7})~',strtoupper($str)))
        {
            return false;
        }
        return true;
    }
	public function is_unique_user_type($str, $field)
    {
        $this->set_message('is_unique_user_type', '{field} is already registered.');
        sscanf($field, '%[^.].%[^.]', $table, $field);

        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, [$field => $str,"user_type<>'company'"=>null])->num_rows() === 0)
            : FALSE;
    }
	 public function pan_hash($str)
    {

       // ini_set('display_errors',1);
       // error_reporting(E_ALL);
       
		  
		  
        $this->set_message('pan_hash', '{field} is not valid.');
        if($str==null){
            return true;
        }
		  $ivBytes = hex2bin(IVVAL);
		  $keyBytes = hex2bin(KEYVAL);
		  $ctBytes = base64_decode($str);

		  $decrypt = openssl_decrypt($ctBytes, "aes-256-cbc", $keyBytes, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $ivBytes);
		  
		  
        $decrypt=strtoupper($decrypt);
        if (! preg_match('~^([A-Z]{5}[0-9]{4}[A-Z]{1})~',$decrypt))
        {
            return false;
        }
        return true;
    }
	public function alpha_numeric_spaces($str)
    {
        return (bool) preg_match('/^[A-Za-z0-9 ]+$/i', $str);
    }
	/**
     * Checks to see if an uploaded file's have double dot.
     */
    public function double_dot(?string $blank, string $params): bool
    {
        // Grab the file name off the top of the $params
        // after we split it.
        $params = explode(',', $params);
        $name   = array_shift($params);
        $request = service('request');
        if (! ($files = $request->getFileMultiple($name))) {
            $files = [$request->getFile($name)];
        }

        foreach ($files as $file) {
            if ($file === null) {
                return false;
            }
            $fileData =explode('.',$file->getName());
            if(count($fileData)>2){
                return false;
            }
        }

        return true;
    }
	/**
     * Checks to see if an uploaded file's have valid signature after read.
     */
	public function isValidPDF(?string $blank, string $params): bool
	{
		// Grab the file name off the top of the $params
		// after we split it.
		$params = explode(',', $params);
		$name   = array_shift($params);
		$request = service('request');
		if (! ($files = $request->getFileMultiple($name))) {
			$files = [$request->getFile($name)];
		}

		foreach ($files as $file) {
			if ($file === null) {
				return false;
			}
			if ( !file_exists( $file ) ) return false;

			if ( $f = fopen($file, 'rb') )
			{
				$header1 = fread($f, 3);
				fclose($f);
				// Signature = PDF
				$check1 = strncmp($header1, "\x50\x44\x46", 3)==0 && strlen ($header1)==3;
			}

			if ( $f = fopen($file, 'rb') )
			{
				$header2 = fread($f, 4);
				fclose($f);
				// Signature = %PDF
				$check2 = strncmp($header2, "\x25\x50\x44\x46", 4)==0 && strlen ($header2)==4;
			}

			return ($check1 || $check2) ? true : false;
		}

		return true;
	}

  





}