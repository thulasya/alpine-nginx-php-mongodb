
<?php
require '/vendor/autoload.php';
// Initialize connection
try{
  $mongo = New MongoDB\Client("mongodb://mongo2:27017");
	$db = $mongo->test;
	$collection = $db->logs;
	;
} catch (MongoConnectionException $check){
	die ('Error msg: '. $check->getMessage());
	}
	
// Create array for saving logs
$request = array(
    'user_name' => $_SERVER['PHP_AUTH_USER'],
	'ip_address' => $_SERVER['REMOTE_ADDR'],
	'viewed_at' => new MongoDB\BSON\UTCDateTime($_SERVER['time_local']),
	'page' => $_SERVER['SCRIPT_NAME'],
	'req_method' => $_SERVER['REQUEST_METHOD'],
	'protocol' => $_SERVER['SERVER_PROTOCOL']
	);

//Insert array to collection
$collection->insertOne($request);

$cursor = $collection->find(array(),array('user_name','ip_address','viewed_at','page','req_method','protocol')); 
//$cursor->sort(array(-1));

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<div class="contentblock">
	<h3>Log management</h3>
	<table>
		<thead>
			<tr>
                <th>USER</th>
				<th>IP address</th>
				<th>Date/Time</th>
				<th>URL</th>
				<th>Method</th>
				<th>Protocol</th>
			</tr>
		</thead>
	<tbody>
	

			<tr>
                <td><?php echo $request['user_name'];?></td>
				<td><?php echo $request['ip_address'];?></td>
				<td><?php echo date('F j Y, g:i a',$request['viewed_at']->sec);?></td>
				<td><?php echo $request['page'];?></td>
				<td><?php echo $request['req_method']; ?></td>
				<td><?php echo $request['protocol']; ?></td>
			</tr>
	
	
	</tbody>
	</table>