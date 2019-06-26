<?php

class ModelAdmin
{
    private $db;

    public function __construct(){
        $this->db = new Sql;
    }

    public function get_info(){
        $this->db->query("SELECT COUNT(id_patient) AS patient FROM tbl_patient");
        $patient = $this->db->register();

        $array['patient'] = $patient->patient;

        $this->db->query("SELECT COUNT(id_answer) AS answer FROM tbl_answers");
        $answer = $this->db->register();

        $array['answer'] = $answer->answer;

        return $array;
    }
}


?>