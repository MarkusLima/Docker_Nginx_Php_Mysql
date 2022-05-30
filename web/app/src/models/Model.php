<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/src/config/Database.php';

abstract class Model
{

    private $db;
    private $db_table;

    public function __construct($db_table)
    {
        $this->db = new Database();
        $this->db_table = $db_table;
        date_default_timezone_set('America/Sao_Paulo');
    }

    public function find(string $params)
    {
        $params = [
            ':id' => $params
        ];

        $result['body'] = $this->db->read("SELECT * FROM $this->db_table WHERE id = :id", $params);

        if ($result['body']) {
            $result['msg'] = 'success';
        } else {
            $result['msg'] = 'not found';
        }

        echo json_encode($result);
    }

    public function all()
    {
        $result['body'] = $this->db->read("SELECT * FROM $this->db_table");
        $result['msg'] = 'success';
        echo json_encode($result);
    }

    public function add()
    {
        $data = json_decode(file_get_contents("php://input"));

        $read = "SELECT * FROM $this->db_table WHERE ";
        $insert = "INSERT INTO $this->db_table VALUES(0, ";

        $idx = 1;
        foreach ($data as $key => $value) {

            $parameter[':' . $key] = trim($value);
            // $parameter = [
            //     ':name' => trim($data->name),
            //     ':email' => trim($data->email),
            //     ':phone' => trim($data->phone),
            //     ':day_to_pass_on' =>trim($data->day_to_pass_on)
            // ];

            if (count((array)$data) == $idx) {
                $read .= "" . $key . " = :" . $key . "";
                //name = :name
            } else {
                $read .= "" . $key . " = :" . $key . " AND ";
                //name = :name AND email = :email AND phone = :phone AND
            }


            if (count((array)$data) == $idx) {
                $insert .= " :" . $key . ")";
                //:name, :email, :phone)
            } else {
                $insert .= " :" . $key . ", ";
                //:name, :email, :phone,
            }

            $idx++;
        }

        //"SELECT * FROM $this->db_table WHERE name = :name AND email = :email AND phone = :phone AND day_to_pass_on = :day_to_pass_on"
        $verification = $this->db->read($read, $parameter);

        if (!empty($verification)) {
            $result['msg'] = 'already exists';
            echo json_encode($result);
            die();
        }

        //"INSERT INTO $this->db_table VALUES(0, :name, :email, :phone, :day_to_pass_on)"
        $result['body'] = $this->db->create($insert, $parameter);

        if ($result['body']) {

            $result['body'] = $this->db->read($read, $parameter);

            if ($_GET['route'] == 'contract_add') {
                $this->generate_contracts($result['body']);
            }

            $result['msg'] = 'success';
            echo json_encode($result);
        } else {
            $result['msg'] = 'not found';
            echo json_encode($result);
        }
    }

    public function update(string $params)
    {
        $param = [
            ':id' => $params
        ];

        $result = $this->db->read("SELECT * FROM $this->db_table WHERE id = :id", $param);

        if (empty($result)) {
            $result['msg'] = 'not found';
            echo json_encode($result);
            die();
        }

        $data = json_decode(file_get_contents("php://input"));

        $update = "UPDATE $this->db_table SET ";

        $idx = 1;
        foreach ($data as $key => $value) {

            $parameter[':' . $key] = trim($value);
            $body[$key] = trim($value);
            // $parameter = [
            //     ':name' => trim($data->name),
            //     ':email' => trim($data->email),
            //     ':phone' => trim($data->phone),
            //     ':day_to_pass_on' =>trim($data->day_to_pass_on)
            // ];

            if (count((array)$data) == $idx) {
                $update .= "" . $key . " = :" . $key . " WHERE id = :id";
                //name = :name
            } else {
                $update .= "" . $key . " = :" . $key . ", ";
                //name = :name, email = :email, phone = :phone,
            }

            $idx++;
        }

        $parameter[':id'] = trim($params);

        //"UPDATE $this->db_table SET name = :name, email = :email, phone = :phone, day_to_pass_on = :day_to_pass_on WHERE id = :id"
        $ret = $this->db->update($update, $parameter);

        if ($ret) {
            $response['body'] = $body;

            if ($_GET['route'] == 'monthlyfee_update') {
                if($data->status != 'Pending'){
                    $this->generate_transfer($result);
                }
            }

            $response['msg'] = 'success';
            echo json_encode($response);
        } else {
            $response['body'] = [];
            $response['msg'] = 'not found';
            echo json_encode($response);
        }
    }

    public function delete(string $params)
    {
        $param = [
            ':id' => $params
        ];

        $result = $this->db->read("SELECT * FROM $this->db_table WHERE id = :id", $param);

        if (empty($result)) {
            $result['msg'] = 'not found';
            echo json_encode($result);
            die();
        }

        $this->db->delete("DELETE FROM $this->db_table WHERE id = :id", $param);

        echo json_encode(['msg' => 'success']);
    }

    public function generate_contracts($contract)
    {
        $this->generateMonthCurrent($contract);
        $this->getPeriod($contract);
    }

    public function getPeriod($contract)
    {
        $dt = new DateTime('first day of this month');
        $value = $contract[0]->rent_value + $contract[0]->administrative_fee + $contract[0]->condominium_value + $contract[0]->iptu_value;

        for ($i = 1; $i < 12; $i++) {

            $dt->modify('+1 month');

            $parameter = [
                ':contract_id' => $contract[0]->id,
                ':status' => 'Pending',
                ':value' => $value,
                ':reference' => $dt->format('Y-m-d'),
                ':expiration' => $dt->format('Y-m-d')
            ];
    
            $result['body'] = $this->db->create(
                "INSERT INTO monthly_fees VALUES(0, :contract_id, :status, :value, :reference, :expiration)",
                $parameter
            );
        }

    }

    public function generateMonthCurrent($contract)
    {
        $date_initial = date('Y-m-d'); //data atual
        $month = date('m'); //mes atual
        $year = date('Y'); //ano atual
        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year); //qtd dias do mes atual

        $date = new DateTime('now');
        $date->modify('last day of this month');
        $date_finish = $date->format('Y-m-d'); //data final do mes atual

        $diferenca = strtotime($date_finish) - strtotime($date_initial);
        $dias = floor($diferenca / (60 * 60 * 24)); //dias de diferenca
        $calc = number_format(($contract[0]->rent_value / $day) * $dias, 2); //calculo para pegar a proporção de dias ate o fim do mes
        $value = $calc + $contract[0]->administrative_fee + $contract[0]->condominium_value + $contract[0]->iptu_value;

        $parameter = [
            ':contract_id' => $contract[0]->id,
            ':status' => 'Pending',
            ':value' => $value,
            ':reference' => $contract[0]->start_date,
            ':expiration' => $contract[0]->start_date
        ];

        $result['body'] = $this->db->create(
            "INSERT INTO monthly_fees VALUES(0, :contract_id, :status, :value, :reference, :expiration)",
            $parameter
        );
    }

    public function generate_transfer($monthlyfee)
    {
        $param = [
            ':id' => $monthlyfee[0]->contract_id
        ];

        $contract = $this->db->read("SELECT * FROM contracts WHERE id = :id", $param);
        $value = $contract[0]->rent_value + $contract[0]->iptu_value;
        
        $parameter = [
            ':monthlyfee_id' => $monthlyfee[0]->id,
            ':status' => 'Pending',
            ':value' => $value
        ];
        $p = [
            ':monthlyfee_id' => $monthlyfee[0]->id
        ];

        $result = $this->db->read("SELECT * FROM transfers WHERE monthlyfee_id = :monthlyfee_id", $p);

        if(empty($result)){
            $this->db->create(
                "INSERT INTO transfers VALUES(0, :monthlyfee_id, :status, :value)",
                $parameter
            );
        }

    }
}

