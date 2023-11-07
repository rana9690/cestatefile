<?php
class Throttle
{

    protected $db;
    protected $input;
    protected $throttleTable;
    public function __construct()
    {
        $CI =& get_instance();
        isset($CI->db) OR $CI->load->database();
        $this->db = $CI->db;

        $this->throttleTable='throttles';
        $this->input	=& load_class('Input', 'core');

    }



    /**
     * throttles multiple connections attempts to prevent abuse
     * @param int $type type of throttle to perform.
     *
     */
    public function throttle($type = 0, $limit = 5, $timeout = 20)
    {

        //clean up login attempts older than specified time
        $this->throttle_cleanup($timeout, $type, $timeout);
        $data = [
            'ip' => $this->input->ip_address(),
            'type' => $type,
        ];

        $this->db->insert($this->throttleTable,$data);

    }

    /**
     * Cleans up old throttling attempts based on throttle timeout
     *
     * @param $timeout
     * @return result of query
     */
    public function throttle_cleanup($timeout, $type)
    {
        $formatted_current_time = date("Y-m-d H:i:s.u", strtotime('-' . (int)$timeout . ' minutes'));
        //$modifier =  ' BETWEEN "1970-00-00 00:00:00" and ' . $formatted_current_time;
        return $this->db->where(['created_at <='=>$formatted_current_time, 'type' => $type])->delete($this->throttleTable);
    }


    public function throttleCheck($type = 0, $limit = 5, $timeout = 20)
    {

        //clean up login attempts older than specified time
        $this->throttle_cleanup($timeout, $type, $timeout);


        $attempts = $this->db->where(['ip' => $this->input->ip_address(), 'type' => $type])->from($this->throttleTable)->get();
        $attemptsCounts=  $attempts->num_rows();

        if ($attemptsCounts > $limit) {
            return [
                'status'=>false,
                'message'=>'Too many attempts. Try back after ' . $timeout . ' minutes.'
            ];

            //die;
            // show_error('Too many attempts. Try back after ' . $timeout . ' minutes.', 503, 'Attempt failed');
        }
        $attemptsCount=$attemptsCounts+1;
        $totalAttempts=$limit+1;
        return [
            'status'=>true,
            'message'=>'You have made '.$attemptsCount.' unsuccessful attempt(s) out of '.$totalAttempts.' allowed attempts. Please try again carefully.'
        ];

        //return $attemptsCounts; // return current number of attempted logins
    }


}
