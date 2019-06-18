<?php
class ModelFriday 
{
    private $db;

    public function __construct(){
        $this->db = new Sql;
    }

    public function get_answers(){

        $this->db->query(
            "SELECT a.id_answer, (u.name + ' ' + u.last_name) AS name, a.answer, k.keyword
            FROM dbfriday.dbo.tbl_answers AS a
            INNER JOIN dbfriday.dbo.tbl_users AS u ON u.id_user = a.id_user
            INNER JOIN dbfriday.dbo.tbl_keywords AS k ON k.id_answer = a.id_answer
            ORDER BY k.id_keyword ASC"
        );

        return $this->db->registers();

    }

    public function add_answer($answer, $id){
        $this->db->query("add_answer @id_user = :id, @answer = :answer");

        $this->db->bind(':id', $id);
        $this->db->bind(':answer', $answer);

        if ($this->db->execute()) {
            return true;
        }else{
            return false;
        }
    }


    public function last_id(){

        // Preparamos consulta para obtener el ultimo id
        $this->db->query("SELECT max(id_answer) AS id FROM tbl_answers");

        // devolvemos los registros
        return $this->db->register();
    }

    public function add_keyword($keyword, $id_answer){

        // Preparamos consulta
        $this->db->query("add_keyword @id_answer = :id_answer, @keyword = :keyword ");

        $this->db->bind(":id_answer", $id_answer);
        $this->db->bind(":keyword", $keyword);

        // Ejecutamos
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function get_entry_info($id){

        // Preparamos la consulta

        $this->db->query(
            "SELECT a.answer, (ui.name + ' ' + ui.last_name) AS user_insert, 
            (uu.name + ' ' + uu.last_name), k.keyword, k.id_keyword
            FROM dbfriday.dbo.tbl_answers AS a
            INNER JOIN dbfriday.dbo.tbl_users AS ui ON ui.id_user = a.id_user
            INNER JOIN dbfriday.dbo.tbl_users AS uu ON uu.id_user = a.id_user_update
            INNER JOIN dbo.tbl_keywords AS k ON k.id_answer = a.id_answer
            WHERE a.id_answer = CONVERT(INT, :id) "
        );

        $this->db->bind(':id', $id);

        return $this->db->registers();

    }
}


?>