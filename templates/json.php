<?php

if (!isset($result))
	$result=NULL;
if (!isset($err_msg) and !isset($err_code))
	$error = NULL;
else {
	$error = array(
		"msg" => $err_msg,
		"code" => $err_code
	);
	$result = NULL;
}

echo json_encode(array(
	"result" => $result,
	"error" => $error,
));

?>
