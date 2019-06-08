<?php
class Patient extends MainController
{
    public function __construct(){
        sessionUser();

        $this->ModelPatient = $this->model('ModelPatient');
    }

    public function index($alert = ''){

        $patients = $this->ModelPatient->get_patients();

        $parameters = [
            'menu' => 'Pacientes',
            'patients' => $patients,
            'alert' => $alert
        ];
        $this->view('patient/index', $parameters);
    }

    public function add_patient(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $patient['name'] = sanitize($_POST['name']);
            $patient['last_name'] = sanitize($_POST['last_name']);
            $patient['birthdate'] = sanitize($_POST['birthdate']);
            $patient['gender'] = sanitize($_POST['gender']);
            $patient['email'] = sanitize($_POST['email']);
            $patient['password'] = hash('sha512', SALT . sanitize($_POST['password']));
            $patient['id_user'] = $_SESSION['user']->id_user;

            if ($this->ModelPatient->add_patient($patient)) {
                redirect('/patient/saved');
            } else{
                die("Error al guardar los datos");
            }

        }

        $parameters = [
            'menu' => 'Pacientes'
        ];

        $this->view('patient/add_patient', $parameters  );
    }

    public function info($id = 0){

        // Obtenemos la información del paciente
        $patient = $this->ModelPatient->get_patient($id);

        // Si no hay un paciente con ese id redireccionamos
        if (!$patient) {
            redirect('/patient');
        }

        // Preparamentos para enviar a la vista
        $parameters = [
            'menu' => 'Pacientes',
            'patient' => $patient
        ];

        // llamamos la vista y mandamos los parámetros
        $this->view('patient/info', $parameters);
    }
}


?>