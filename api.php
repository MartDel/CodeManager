<?php
require('class/DatabaseManager.php');
require('class/User.php');
require('class/Passwords.php');

try {
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
            } else {
                $table = $body['table'];

                $where_str = '';
                $values = array();
                if($body['where'] != null){
                    $keys = array();
                    foreach ($body['where'] as $condition) {
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
            }
            http_response_code(200);
            header('Content-Type: application/json');
            break;
        case 'POST':
            // POST data
            break;
    }
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo '{"error": "' . $e->getMessage() . '"}';
    header('Content-Type: application/json');
}
