<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '../vendor/autoload.php';
require_once 'auth.php';




$app = new \Slim\App;

// get all users
$app->get('/users', function (Request $request, Response $response) {
	require_once '../settings/db_con.php';
    $sql = "SELECT * FROM users";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
    	while($row = $result->fetch_assoc()) {
        	$data[] = $row; 
    	}    	
    	$json = array("status"=>"1", "msg"=>"OK", "data"=>$data);
    	header('Content-type: application/json');
    	echo json_encode($json);
	} else {
    $json = array("status"=>"0", "msg"=>"no data found");
    header('Content-type: application/json');
    echo json_encode($json);
	}
	$conn->close();
});

$app->get('/user/{id}', function (Request $request, Response $response) {

	$id = $request->getAttribute('id');

	require_once '../settings/db_con.php';

    $sql = "SELECT * FROM users where id=$id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    // output data of each row
    	while($row = $result->fetch_assoc()) {
        	$data[] = $row; 
    	}
    	$json = array("status"=>"1", "msg"=>"OK", "data"=>$data);
    	header('Content-type: application/json');
    	echo json_encode($json);
	} else {
    $json = array("status"=>"0", "msg"=>"no data found");
    header('Content-type: application/json');
    echo json_encode($json);
	}
	$conn->close();
});

$app->post('/users',function ($request){
	require_once('../settings/db_con.php');
	$query="INSERT INTO users (name,email,password,status) VALUES(?,?,?,?)";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("ssss",$a,$b,$c,$d);

	$a=$request->getParsedBody()['name'];
	$b=$request->getParsedBody()['email'];
	$c=$request->getParsedBody()['password'];
	$d=$request->getParsedBody()['status'];

	$stmt->execute();
	$num_affected_rows = $stmt->affected_rows;
    if ($num_affected_rows>0) {
      $json = array("status"=>"1", "msg"=>"user created successfuly");
    	header('Content-type: application/json');
    	echo json_encode($json);
    }
    else {
      $json = array("status"=>"0", "msg"=>"user could not created.");
    	header('Content-type: application/json');
    	echo json_encode($json);
    }
});

$app->put('/user/{id}',function ($request){
	require_once('../settings/db_con.php');
	$id = $request->getAttribute('id');

	$query="UPDATE users SET name=?, email=?, password=?, status=? WHERE id=$id";
	$stmt=$conn->prepare($query);
	$stmt->bind_param("ssss",$a,$b,$c,$d);

	$a=$request->getParsedBody()['name'];
	$b=$request->getParsedBody()['email'];
	$c=$request->getParsedBody()['password'];
	$d=$request->getParsedBody()['status'];

	$stmt->execute();
	$num_affected_rows = $stmt->affected_rows;
    if ($num_affected_rows>0) {
      $json = array("status"=>"1", "msg"=>"updated successfuly");
    	header('Content-type: application/json');
    	echo json_encode($json);
    }
    else {
      $json = array("status"=>"0", "msg"=>"not properly updated");
    	header('Content-type: application/json');
    	echo json_encode($json);
    }
});
$app->delete('/user/{id}',function ($request){
	require_once('../settings/db_con.php');
	$id = $request->getAttribute('id');

	$query="DELETE FROM users WHERE id=$id";
	$stmt=$conn->prepare($query);
	
	$stmt->execute();
	$num_affected_rows = $stmt->affected_rows;
    if ($num_affected_rows>0) {
      $json = array("status"=>"1", "msg"=>"deleted successfuly");
    	header('Content-type: application/json');
    	echo json_encode($json);
    }
    else {
      $json = array("status"=>"0", "msg"=>"something going wrong");
    	header('Content-type: application/json');
    	echo json_encode($json);
    }
});

$app->get('/agent',function ($request){
echo $_SERVER['HTTP_USER_AGENT'];
});

$app->run();