<?php #if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mydb
{
   private $CI, $Data, $mysqli, $ResultSet;

   /**
   * The constructor
   */

   function __construct()
   {
     $this->CI =& get_instance();
     $this->Data = '';
     $this->ResultSet = array();
     $this->mysqli = $this->CI->db->conn_id;
   }

    public function GetMultiResults($SqlCommand)
    {
    /* execute multi query */
    if (mysqli_multi_query($this->mysqli, $SqlCommand)) {
        $i=0;
        do
        {

             if ($result = $this->mysqli->store_result()) 
             {
                while ($row = $result->fetch_assoc())
                {
                    $this->Data[$i][] = $row;
                }
                mysqli_free_result($result);
             }
            $i++; 
        }
        while ($this->mysqli->next_result());
    }
    return $this->Data;

   }   
}
