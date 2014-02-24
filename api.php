<?php
require_once("mysql_db.php");

//connect to database: server, username, password, database
$mydb = new MySqlDB("localhost", "", "","test"); //enter your parameters


//$sql="SELECT * FROM employees";
//$results=$mydb->query($sql);

//$total_rows=$mydb->numRows($results);

// This is the API, 2 possibility show the user list, and show a specific user by action.

function get_user_by_id($id, $mydb)
{
  //$user_info = array();

  $sql="SELECT * FROM employees WHERE id= $id";
  $results=$mydb->query($sql);
  
  $total_rows=$mydb->numRows($results);
  
  while ($myRow=$mydb->fetchAssoc($results))
  {
  	$user_info = array("first_name" => $myRow["fname"], "last_name" => $myRow["lname"], "age" => $myRow["id"]);
  }
  
  /*
  // make a call in db.
  switch ($id){
    case 1:
      $user_info = array("first_name" => "Marc", "last_name" => "Simon", "age" => $total_rows); // let's say first_name, last_name, age
      break;
    case 2:
      $user_info = array("first_name" => "Frederic", "last_name" => "Zannetie", "age" => 24);
      break;
    case 3:
      $user_info = array("first_name" => "Laure", "last_name" => "Carbonnel", "age" => 45);
      break;
  }
	*/
  
  return $user_info;
}

function get_user_list($mydb)
{
	//connect to database: server, username, password, database
	//$mydb = new MySqlDB("localhost", "", "","test"); //enter your parameters
	
	$sql="SELECT * FROM employees";
	$results=$mydb->query($sql);
	
	$total_rows=$mydb->numRows($results);
	
	if($total_rows)
	{
		while ($myRow=$mydb->fetchAssoc($results)) 
		{
			//$user_list = array(array("id" => 1, "name" => "Simon"), array("id" => 2, "name" => "Zannetie"), array("id" => 3, "name" => "Carbonnel")); // call in db, here I make a list of 3 users.
			
	  		$user_list[] = array("id" => $myRow["id"], "name" => $myRow["fname"]);
					
		}
		
		//return $user_list;
	}
	
		//	$user_list = array(array("id" => $total_rows, "name" => "Simon"), array("id" => 2, "name" => "Zannetie"), array("id" => 3, "name" => "Carbonnel")); // call in db, here I make a list of 3 users.
	  	return $user_list;
}

$possible_url = array("get_user_list", "get_user");

$value = "An error has occurred";

if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
{
  switch ($_GET["action"])
    {
      case "get_user_list":
        $value = get_user_list($mydb);
        break;
      case "get_user":
        if (isset($_GET["id"]))
          $value = get_user_by_id($_GET["id"],$mydb);
        else
          $value = "Missing argument";
        break;
    }
}

exit(json_encode($value));

?>