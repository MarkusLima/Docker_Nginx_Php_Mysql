<?php 

require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Client.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Owner.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Property.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Contract.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Monthlyfee.php';
require_once realpath($_SERVER["DOCUMENT_ROOT"]) .'/src/models/Transfer.php';

class ApiController{

    private $model;

    public function __construct(string $model) 
    {
        header("Content-Type: application/json");
        $this->model = new $model();
    }

    public function find()
    {
        $this->verificationMethod('GET');
        $params = !empty($_GET['params']) ? $_GET['params'] : false;
        return $this->model->find($params);
    }

    public function all()
    {
        $this->verificationMethod('GET');
        return $this->model->all();
    }

    public function add()
    {
        $this->verificationMethod('POST');
        return $this->model->add();
    }

    public function update()
    {
        $this->verificationMethod('POST');
        $params = !empty($_GET['params']) ? $_GET['params'] : false;
        return $this->model->update($params);
    }

    public function delete()
    {
        $this->verificationMethod('GET');
        $params = !empty($_GET['params']) ? $_GET['params'] : false;
        return $this->model->delete($params);
    }

    public function verificationMethod(string $method)
    {
        if ($_SERVER['REQUEST_METHOD'] != $method) {
            echo json_encode(['msg'=> 'Method not allowed']);
            die();
        }
    }

}