<?php
require('class/DatabaseManager.php');
require('class/User.php');
require('class/Passwords.php');

try {
    http_response_code(200);
    header('Content-Type: application/json');

    $headers = getallheaders();
    if(isset($headers['Authorization'])){
        $current_token = getallheaders()['Authorization'];
        if($current_token != ('Bearer ' . Passwords::API_TOKEN)){
            throw new Exception("Token is not correct.", 401);
        }
    } else throw new Exception("Token is not correct.", 401);

    $method = $_SERVER['REQUEST_METHOD'];
    $body = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
        case 'GET':
            // GET data
            if (isset($_GET['pseudo']) && isset($_GET['password'])) {
                // password verify
                $pseudo = htmlspecialchars($_GET['pseudo']);
                $password = base64_decode($_GET['password']);

            	$correct_password = User::getPassword($pseudo);
            	if($correct_password == null) throw new Exception("Un problème est survenu.", 500);
        		echo '{"result":' . (password_verify($password, $correct_password) ? 'true' : 'false') . '}';
            } else if(isset($_GET['request'])){
                $request = json_decode($_GET['request'], true);
                $table = $request['table'];

                $where_str = '';
                $values = array();
                if(isset($request['where'])){
                    if($request['where'] != null){
                        $keys = array();
                        foreach ($request['where'] as $condition) {
                            array_push($keys, $condition['key']);
                            array_push($values, $condition['value']);
                        }

                        $where_str = ' WHERE ';
                        for ($i=0; $i < count($keys); $i++) {
                            $where_str .= $keys[$i] . '=?';
                            if($i != (count($keys) - 1)){
                                $where_str .= ' AND ';
                            }
                        }
                    }
                }

                $db = DatabaseManager::dbConnect();
                $query = $db->prepare('SELECT * FROM ' . $table . $where_str);
                $query->execute($values);

                $json_str = '';
                while($data = $query->fetch(PDO::FETCH_ASSOC)){
                    $json_str .= json_encode($data);
                    $json_str .= ',';
                }
                $json_str = substr($json_str, 0, -1);

                echo '[' . $json_str . ']';
            } else throw new Exception("Aucune donnée reçue", 400);
            break;
        case 'POST':
            // POST data
            $table = $body['table'];
            $data = $body['data'];

            $values = array();
            $values_str = 'VALUES(';
            $keys_str = '(';
            foreach ($data as $key => $value) {
                // Check if key == password
                if($key == "password"){
                    array_push($values, password_hash(base64_decode($value), PASSWORD_DEFAULT));
                } else {
                    array_push($values, $value);
                }
                $values_str .= '?,';
                $keys_str .= $key . ',';
            }
            $values_str = substr($values_str, 0, -1);
            $keys_str = substr($keys_str, 0, -1);
            $values_str .= ')';
            $keys_str .= ')';

            $db = DatabaseManager::dbConnect();
            $req = $db->prepare('INSERT INTO ' . $table . $keys_str . ' ' . $values_str);
            if (!$req) {
                print_r($db->errorInfo());
            }
            $req->execute($values);

            var_dump($values);
            echo '{"message": "Data sent."}';
            break;
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo '{"error": "' . $e->getMessage() . '"}';
    header('Content-Type: application/json');
}
