<?php

class Respuesta_Indicadores{

    private $response = [
        'status' => "ok",
        'result' => array()
    ];

    public function error_405(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Solicitud no Admitida"
        );

        return $this->response;
    }

    public function error_200($string = ""){
        $this->response['status'] = 'success';
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $string
        );

        return $this->response;
    }

    public function error_400($string){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "$string"
        );

        return $this->response;
    }
}

Class respuesta_error_indicadores{
    public $flag;
    public $detalle;
}

?>