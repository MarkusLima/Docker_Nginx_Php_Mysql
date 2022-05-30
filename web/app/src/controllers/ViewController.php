<?php 

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Client.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Owner.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Property.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Contract.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Monthlyfee.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Transfer.php';

class ViewController{

    private $view;

    public function __construct(string $view) 
    {
        $this->view = $view;
    }

    public function list()
    {
        include_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/header.php');
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/list.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/footer.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/script.php';
    }

    public function create()
    {
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/header.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/create.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/footer.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/script.php';
    }

    public function show()
    {
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/header.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/show.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/footer.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/script.php';
    }

    public function edit()
    {
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/header.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/edit.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/includes/footer.php';
        require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/views/'.$this->view.'/script.php';
    }

}