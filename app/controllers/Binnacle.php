<?php 
class Binnacle extends MainController
{
    public function __construct(){
        sessionAdmin();
        $this->ModelBinnacle = $this->model('ModelBinnacle');
    }

    public function index(){

        // Obtenemos los registros
        $registers = $this->ModelBinnacle->get_binnacle_registers();

        // Preparamos la información para mostrar en la vista
        $parameters = [
            'menu' => 'Bitacora',
            'registers' => $registers
        ];

        // Llamamos la vista y enviamos los parámetros
        $this->view('binnacle/index', $parameters);
    }

    public function info($id = 0){

        // Obtenemos la información del registro 
        $register = $this->ModelBinnacle->get_binnacle_register($id);

        if (!$register) {
            redirect('/binnacle');
        }

        // metemos en un arreglo la nueva información registrada
        $new_data = explode("|", $register->new_data);

        // Ordenamos la información dependiendo del tipo de operación
        if ($register->operation == 'UPDATE') {
            $type = 'UPDATE';
            $old_data = explode("|", $register->old_data);
        }else if($register->operation == 'INSERT'){
            $type = 'INSERT';
            $old_data = '';
        } else if($register->operation == 'DELETE'){
            $type = 'DELETE';
            $new_data = '';
            $old_data = explode("|", $register->old_data);

        }
// print_r($old_data);
        $parameters = [
            'menu' => 'Biacora',
            'register' => $register,
            'new_data' => $new_data,
            'old_data' => $old_data,
            'type' => $type
        ];

        $this->view('binnacle/info', $parameters);
    }
}


?>