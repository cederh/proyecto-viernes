<?php 
class Admin extends MainController
{
    public function __construct(){
        sessionUser();

        $this->ModelAdmin = $this->model('ModelAdmin');
    }

    public function index(){

        $info = $this->ModelAdmin->get_info();

        $parameters = [
            'menu' => 'Admin',
            'patients' => $info['patient'],
            'answers' => $info['answer']
        ];

        $this->view('admin/index', $parameters);
    }
}


?>