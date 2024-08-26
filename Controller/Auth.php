<?php
require_once "../vendor/autoload.php";
use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;

class Auth 
{
    private string $key;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('../');
        $dotenv->load();
        $this->key = $_ENV["SECRET_KEY"];
    }

    public function authenticateJWT() : bool {
        if (!preg_match("/^Bearer\s+(.*)$/", $_SERVER["HTTP_AUTHORIZATION"], $matches)) {
            http_response_code(400);
            echo json_encode(["message" => "incomplete authorization header"]);
            return false;
        }

        try {
            $data = JWT::decode($matches[1],new Key($this->key, 'HS512'));
        } catch (SignatureInvalidException $sig) {

            http_response_code(401);
            echo json_encode(["message" => "invalid signature", "trace" => $sig->getMessage()]);
            return false;
        } catch (Exception $e) {

            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            return false;
        }
        return true;
    }
}

?>