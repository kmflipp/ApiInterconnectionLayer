<?php

if(!defined("SQL_LAYER"))
{

    define("SQL_LAYER","mysql");

    class sql_db
    {

        var $db_connect_id;
        var $query_result;
        var $row = array();
        var $rowset = array();
        var $num_queries = 0;
        //
        // Constructor
        //
        function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true)
        {
            $this->persistency = $persistency;
            $this->user = $sqluser;
            $this->password = $sqlpassword;
            $this->server = $sqlserver;
            $this->dbname = $database;

            $this->db_connect_id = mysqli_connect($this->server, $this->user, $this->password,$this->dbname);

            if($this->db_connect_id)
            {
                return $this->db_connect_id;
            }
            else
            {
                return false;
            }
        }

        //
        // Other base methods
        //
        function sql_close()
        {
            if($this->db_connect_id)
            {
                if($this->query_result)
                {
                    mysqli_free_result($this->query_result);
                }
                $result = mysqli_close($this->db_connect_id);
                return $result;
            }
            else
            {
                return false;
            }
        }

        //
        // Base query method
        //
        function sql_query($query = "", $transaction = FALSE){
            // Remove any pre-existing queries
            unset($this->query_result);
            if ($query!="") {
                $this->query_result = mysqli_query($this->db_connect_id, $query);
            }
            return $this->query_result;
        }


        //
        // Other query methods
        //
        function sql_numrows($query_id = 0)
        {
            if(!$query_id)
            {
                $query_id = $this->query_result;
            }
            if($query_id)
            {
                $result = mysqli_num_rows($query_id);
                return $result;
            }
            else
            {
                return false;
            }
        }
        function sql_affectedrows()
        {
            if($this->db_connect_id)
            {
                $result = mysqli_affected_rows($this->db_connect_id);
                return $result;
            }
            else
            {
                return false;
            }
        }
        function sql_numfields($query_id = 0)
        {
            if(!$query_id)
            {
                $query_id = $this->query_result;
            }
            if($query_id)
            {
                $result = mysqli_num_fields($query_id);
                return $result;
            }
            else
            {
                return false;
            }
        }
        function sql_fetchrow($query_id = 0)
        {
            if(!$query_id)
            {
                $query_id = $this->query_result;
            }
            if($query_id)
            {
                $id = (int) $query_id;
                $this->q_array[$id] = mysqli_fetch_array($query_id,MYSQL_ASSOC);
                return $this->q_array[$id];
            }
            else
            {
                return false;
            }
        }
        function sql_fetchrowset($query_id = 0)
        {
            if(!$query_id)
            {
                $query_id = $this->query_result;
            }
            if($query_id)
            {
                unset($this->rowset[$query_id]);
                unset($this->row[$query_id]);
                while($this->rowset[$query_id] = mysqli_fetch_array($query_id))
                {
                    $result[] = $this->rowset[$query_id];
                }
                return $result;
            }
            else
            {
                return false;
            }
        }
        function sql_nextid(){
            if($this->db_connect_id)
            {
                $result = mysqli_insert_id($this->db_connect_id);
                return $result;
            }
            else
            {
                return false;
            }
        }
        function sql_freeresult($query_id = 0){
            if(!$query_id)
            {
                $query_id = $this->query_result;
            }

            if ( $query_id )
            {
                unset($this->row[$query_id]);
                unset($this->rowset[$query_id]);

                mysqli_free_result($query_id);

                return true;
            }
            else
            {
                return false;
            }
        }
        function sql_error($query_id = 0)
        {
            $result["message"] = mysqli_error($this->db_connect_id);
            $result["code"] = mysqli_errno($this->db_connect_id);

            return $result;
        }

    } // class sql_db

} // if ... define

?>