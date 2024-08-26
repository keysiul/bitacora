<?php
class VerifyData
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public static function verifyMethods(array $methods) : bool {
        foreach($methods as $method)
        {
            if($_SERVER['REQUEST_METHOD'] == $method ) return true;
        }
        http_response_code(405);
        echo json_encode([
            "Status" => false,
            "Message" => "Allowed methods: " . implode(",",$methods)
        ], JSON_UNESCAPED_UNICODE);
        return false;
    }

    public function verifyMethod(string $method) : bool {
         if ($_SERVER['REQUEST_METHOD'] !== $method) {
            http_response_code(405);
            header('ALLOW: POST');
            return false;
            //exit();       -> when method call return false we call exit
        }
        return true;
    }
    public function emptyData() : bool {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';


        if ($contentType !== 'application/json') {
            http_response_code(415);
            echo json_encode(["message" => "Only JSON content is supported"]);
            return false;
            //exit();
        }

        if ($this->data === null) {
            http_response_code(400);
            echo json_encode(["message" => "Invalid JSON data"]);
            return false;
            //exit();
        }

        
        
        return true;
    }

    public function verifyInputs(array $params) : bool {
        foreach($params as $input)
        {
            if(!isset($this->data->$input))
            {
                http_response_code(400); 
                echo json_encode(["message" => "Missing parameters"]);
                return false;
            }
        }
        return true;
    }
}
?>