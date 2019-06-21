<?php

class ModelPatient
{
    private $db;

    public function __construct(){
        $this->db = new Sql;
    }

    public function get_patients(){

        $this->db->query(
            "SELECT id_patient, (name +' '+ last_name) AS name, DATEDIFF(hour,birthdate,GETDATE())/8766 AS age, gender, insert_date
            FROM dbfriday.dbo.tbl_patient"
        );

        return $this->db->registers();
    }

    public function get_patient($id){
      //(p.name +' ' + p.last_name) AS name,
        $this->db->query(
            "SELECT p.id_patient, p.name, p.last_name, p.birthdate, DATEDIFF(hour,p.birthdate,GETDATE())/8766 AS age,
            p.gender, p.personality, p.ci, p.[character], p.email, (ui.name +' ' + ui.last_name) AS user_insert,
            p.insert_date, (uu.name +' ' + uu.last_name) AS user_update, update_date
            FROM dbfriday.dbo.tbl_patient AS p
            INNER JOIN dbfriday.dbo.tbl_users AS ui ON ui.id_user = p.id_user
            INNER JOIN dbfriday.dbo.tbl_users AS uu ON uu.id_user = p.id_user_update
            WHERE p.id_patient = CONVERT(INT, :id)"
        );

        $this->db->bind(':id', $id);

        return $this->db->register();
    }

    public function add_patient($patient){

        // Preparamos la consulta
        $this->db->query(
            "add_patient @name = :name,	@last_name = :last_name, @birthdate = :birthdate, @gender = :gender,
            @email = :email, @password = :password, @id_user = :id"
        );

        // Vinculamos los datos
        $this->db->bind(':name',$patient['name']);
        $this->db->bind(':last_name',$patient['last_name']);
        $this->db->bind(':birthdate',$patient['birthdate']);
        $this->db->bind(':gender',$patient['gender']);
        $this->db->bind(':email',$patient['email']);
        $this->db->bind(':password',$patient['password']);
        $this->db->bind(':id',$patient['id_user']);

        // Ejecutamos

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }


    }

    public function update_patient($id, $patient){
      $this->db->query(
           "update_patient @name = :name, @last_name = :last_name, @birthdate = :birthdate,
           @gender = :gender, @email = :email, @id_user = :id_user, @id = :id"
      );
      // Vinculamos los datos a nuestra consulta preparada
      $this->db->bind(':name',$patient['name']);
      $this->db->bind(':last_name',$patient['last_name']);
      $this->db->bind(':birthdate',$patient['birthdate']);
      $this->db->bind(':gender',$patient['gender']);
      $this->db->bind(':email',$patient['email']);
      $this->db->bind(':id_user',$patient['id_user']);
      $this->db->bind(':id', $id);

      if ($this->db->execute()) {
      return true;
      }else {
      return false;
      }
    }

    public function update_password($id, $patient){

        // Preparamos la consulta
        $this->db->query(
            "update_passwordPatient @password = :password,  @id_user = :id_user, @id = :id"
        );

        // Vinculamos los datos a nuestra consulta preparada
        $this->db->bind(':password', $patient['password']);
        $this->db->bind(':id_user', $patient['id_user']);
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
          return true;
        }else {
          return false;
        }
    }

    public function login($email, $password){
        
        $this->db->query(
            "SELECT id_patient, name, last_name, birthdate, gender, personality, ci, [character], email, id_user, insert_date, id_user_update, update_date
            FROM dbfriday.dbo.tbl_patient WHERE email = :email AND password = :password"
        );

        $this->db->bind(":email", $email);
        $this->db->bind(":password", $password);

        return $this->db->register();

    }

    public function new_acount($patient){

        // Preparamos la consulta
        $this->db->query(
            "add_acount @name = :name,	@last_name = :last_name, @birthdate = :birthdate, @gender = :gender,
            @email = :email, @password = :password"
        );

        // Vinculamos los datos
        $this->db->bind(':name',$patient['name']);
        $this->db->bind(':last_name',$patient['last_name']);
        $this->db->bind(':birthdate',$patient['birthdate']);
        $this->db->bind(':gender',$patient['gender']);
        $this->db->bind(':email',$patient['email']);
        $this->db->bind(':password',$patient['password']);

        // Ejecutamos

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_acount($id, $patient){
      $this->db->query(
           "update_acount @name = :name, @last_name = :last_name, @birthdate = :birthdate,
           @gender = :gender, @email = :email, @id = :id"
      );
      // Vinculamos los datos a nuestra consulta preparada
      $this->db->bind(':name',$patient['name']);
      $this->db->bind(':last_name',$patient['last_name']);
      $this->db->bind(':birthdate',$patient['birthdate']);
      $this->db->bind(':gender',$patient['gender']);
      $this->db->bind(':email',$patient['email']);
      $this->db->bind(':id', $id);

      if ($this->db->execute()) {
      return true;
      }else {
      return false;
      }
    }

    public function update_passwordAcount($id, $patient){
      // Preparamos la consulta
      $this->db->query(
           "update_passwordAcount @password = :password, @id = :id"
      );

      // Vinculamos los datos a nuestra consulta preparada
      $this->db->bind(':password', $patient['password']);
      $this->db->bind(':id', $id);

      if ($this->db->execute()) {
         return true;
      }else {
         return false;
      }
    }
}


?>
