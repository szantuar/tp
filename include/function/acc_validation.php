<?php

//validation name
function check_name($name)
	{
	if(strlen($name)<4 || strlen($name) > 25)
		{	
		$_SESSION['ERR_REG'] = TRUE;
		return FALSE;
	}
		
	if(preg_match('/[^0-9A-Za-z]/',$name))
		{
		$_SESSION['ERR_REG'] = TRUE;
		return FALSE;
		}
	}

//check name with db
function name_db($name, $exception)
	{
	$param = 'name&'.htmlentities($name).'&STR';	
	$result = $exception->exc_db("SELECT name FROM account WHERE name=:name", $param);
	
	if($result !== FALSE)
		{
		$_SESSION['ERR_REG'] = TRUE;
		return FALSE;
		}	

	}
	
//validation email
function check_email($email)
	{
	if(empty($email) || !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email))
			{
			$_SESSION['ERR_REG'] = TRUE;
			return FALSE;
			}
	}

//check email with db
function email_db($email, $exception)
	{
	$param = 'email&'.htmlentities($email).'&STR';	
	$result = $exception->exc_db("SELECT email FROM account WHERE email=:email", $param);

	if($result !== FALSE)
		{
		$_SESSION['ERR_REG'] = TRUE;
		return FALSE;
		}
	}
	
//validation password
function check_pass($pass)
	{
	if(empty($pass) || preg_match('/[^0-9A-Za-z]/',$pass) || strlen($pass) < 8 || strlen($pass) > 24)
		{
		$_SESSION['ERR_REG'] = TRUE;
		return FALSE;
		}
	}
	
//compare pass
function pass_Compare($pass1, $pass2)
	{
	if($pass1 != $pass2)
		{
		$_SESSION['ERR_REG'] = TRUE;
		return FALSE;
		}
	}
	

?>