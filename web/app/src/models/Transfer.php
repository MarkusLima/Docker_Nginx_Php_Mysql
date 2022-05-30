<?php

require_once realpath($_SERVER["DOCUMENT_ROOT"]) . '/src/models/Model.php';

class Transfer extends Model
{
    public function __construct()
    {
        parent::__construct('transfers');
    }

}
