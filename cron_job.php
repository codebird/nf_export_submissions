<?php
//Connect to the DB
$conn=new PDO('mysql:host=localhost;dbname=DBNAME', 'USERNAME', 'PASSWORD');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//Prepare the statment to get post id using submission id
$post_id_stmt=$conn->prepare("SELECT post_id FROM wp_postmeta WHERE meta_key='_seq_num' AND meta_value=:sub_id ORDER BY meta_id DESC LIMIT 1");

//Prepare the statment to get submitted info using post id
$info_stmt=$conn->prepare("SELECT meta_key, meta_value FROM wp_postmeta WHERE post_id=:post_id");

//Prepare the statement to set processed to 1 for the data we get from new_subs table.
$up_sent_stmt=$conn->prepare("UPDATE new_subs SET processed=1 WHERE form_id=:form_id AND sub_id=:sub_id");

//Map your form field names to their respective real names
$field_mapping=array('_field_71'=>'name', '_field_72'=>'family', '_field_75'=>'dob', '_field_73'=>'father', '_field_76'=>'email', '_field_74'=>'gender', '_field_77'=>'phone', '_field_78'=>'ice');

//Run the query to get new submissions that our script didn't process yet
$submissions_stmt=$conn->query("SELECT sub_id, form_id FROM new_subs WHERE processed=0"); //AND form_id IN (12, 23, 27, 31) //in my case I had multiple forms to be exported.

//Loop through the results of our new submissions query
while($sub_array=$submissions_stmt->fetch(PDO::FETCH_ASSOC)){
	$sub_id=$sub_array['sub_id'];
	$form_id=$sub_array['form_id'];
	
	//Get post id by running our prepared post id statement post_id_stmt
	$post_id_stmt->execute(array('sub_id'=>$sub_id));
	$post_id_array=$post_id_stmt->fetchAll(PDO::FETCH_ASSOC);
	$post_id=$post_id_array[0]['post_id'];

	//create empty info array
	$the_info=array();

	//Get info by executing our prepared info statement info_stmt
	$info_stmt->execute(array('post_id'=>$post_id));
	$info_array=$info_stmt->fetchAll(PDO::FETCH_ASSOC);

	//Loop through the result and fill the_info array using the mapping and the values
	foreach($info_array as $field){
		if(isset($field_mapping[$field['meta_key']])){
			$the_info[$field_mapping[$field['meta_key']]]=$field['meta_value'];
		}
	}

	/*
	* Now the_info is an array that has info 
	* of a submission. you can do whatever you want with the data.
	*/
}
