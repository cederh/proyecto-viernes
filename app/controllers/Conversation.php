<?php
class Conversation extends MainController
{
    public function __construct(){
        session_start();

        $this->Modelfriday = $this->model('ModelFriday');
    }

    /**
     * Función Index
     *
     * Se encarga de buscar las respuestas a lo que se pregunta en el chat
     * 
     * Obtiene una cadena mediante AJAX con el mensaje que el usuario enviá,
     * separa cada palabra y la pasa a mayúscula para meterlas en un arreglo
     * con dicho arreglo se crea una consulta donde por cada palabra se 
     * agrega un 'OR LIKE "palabra"'  en base a la coincidencia de palabras 
     * claves se devuelve una respuesta y se retorna a la petición AJAX
     * 
     * @author Wilber Méndez
     */
    public function index(){
        // error_reporting(0);  
        header('Content-type: application/json; charset=utf-8');
        
        
        // Limpiamos y pasamos a mayúsculas la cadena enviada por el usuario
        $message = strtoupper(filter_var(trim($_POST['message'], 'FILTER_SANITIZE_STRING')));
        
        // Activar aprendizaje, SOLO PARA ADMINISTRADORES
        if(isset($_SESSION['user']->user_type) && $_SESSION['user']->user_type == 2 && $message == 'ACTIVAR MODO APRENDIZAJE'){
            
            $_SESSION['friday']['learning'] = 1;
            echo "Modo de aprendizaje activado. Dime algo y luego enseñame como responder"; 

        }else if(isset($_SESSION['friday']['learning']) && $_SESSION['friday']['learning'] == 1){
            
            if(!isset($_SESSION['friday']['keywords'])){
                $_SESSION['friday']['keywords'] = $message;
                echo "Que debería responder cuando se me diga " .'"'.$message.'"';

            }else if(isset($_SESSION['friday']['answer']) && $message == 'SI'){
                $keywords = explode(' ', $_SESSION['friday']['keywords']);
                echo "¿Desea guardar?";
                $_SESSION['friday']['learning'] = 2;
            }else if(isset($_SESSION['friday']['answer']) && $message == 'NO'){
                echo "Que debería responder cuando se me diga " .'"'.$_SESSION['friday']['keywords'].'"';
            }else{

                $_SESSION['friday']['answer'] = strtolower($message);
                echo "Entiendo que debería responder " .'"'.$_SESSION['friday']['answer'].'"';
            }
        // Confirmar que se decea guardar la información  
        }else if ( isset($_SESSION['friday']['learning']) && $_SESSION['friday']['learning'] == 2 && $message == 'SI') {
            
            // Guardamos la información
            if ($this->Modelfriday->add_answer( $_SESSION['friday']['answer'], $_SESSION['user']->id_user) ) {
                echo "Nueva información guardada";
                unset($_SESSION['friday']['keywords']);
                unset($_SESSION['friday']['answer']);
                $_SESSION['friday']['learning'] == 0;
            }else{
                echo 'Parece que algo salio mal';
            }
            


        } else if (isset($_SESSION['friday']['learning']) && $_SESSION['friday']['learning'] == 2 && $message != 'SI'){
            echo "Acción cancelada";
            $_SESSION['friday']['learning'] == 0;
        }else{
            // Dividimos la cadena por palabra y almacenamos en un array
            $keywords = explode(' ', $message);
    
            // Creamos nuestra consulta
            $query = "SELECT TOP 1 a.answer, a.id_answer, (COUNT(k.id_answer)) AS N, a.n_keywords  
            FROM dbfriday.dbo.tbl_keywords AS k
            INNER JOIN dbfriday.dbo.tbl_answers AS a
            ON k.id_answer = a.id_answer
            WHERE";
    
            foreach ($keywords as $key => $word) {
                $query .= " keyword LIKE '$word' OR";
            }
    
            // Eliminamos el ultimo " OR" que nos agrega el foreach
            $query = substr($query, 0, -3);
            
            $query .= "
            GROUP BY a.id_answer
            ORDER BY N DESC";
    
            // echo $query;
    
            $db = new Sql;
    
            $db->query($query);
            $answer = $db->register();
            
            $con = 0;
            foreach ($keywords as $key => $word) {
                
                $db->query(
                    "SELECT id_keyword, id_answer, keyword
                    FROM dbfriday.dbo.tbl_keywords
                    WHERE id_answer = :id AND keyword = :word
                ");

                $db->bind(':word', $word);
                $db->bind(':id', $answer->id_answer);

                if ($db->register()) {
                    $con++;
                }
                
            }

            // echo $con . ' ' . $answer->n_keywords ;
    
            if ($answer) {
                if ($con >= $answer->n_keywords / 2) {
                    echo ($answer->answer);    
                }else{
                    echo utf8_encode('Aun no tengo respuesta para eso');
                }
            } else {
                echo utf8_encode('Aun no tengo respuesta para eso');
            }

        }
    }
    
}


?>