<?php 
class Admin extends MainController
{
    public function __construct(){
        sessionUser();
    }

    public function index(){

        $parameters = [
            'menu' => 'Admin'
        ];

        $this->view('admin/index', $parameters);
    }
}


?>