<?php 

require_once("../app/Mage.php");

Mage::app();

$action = (String)$_POST["action"];

switch ($action) { 
	case "question":
		postQuestion();
		break;
	case "answer":
		postAnswer();
		break;
}

function postQuestion() {

	// echo "in function post Question";

	$resource = Mage::getSingleton('core/resource');
	$link = mysqli_connect("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com", "94hebi48h48three", "QrwFbKSFyA7E", "8ehdh84_magentothree");
	
	$prod = $_POST["prod"];
	$text = $_POST["text"];
	$fname = $_POST["fname"];
	$zip = $_POST["zip"];

	if (!(empty($prod) || empty($text) || empty($fname) || empty($zip))){
		$sProd = mysqli_real_escape_string($link, $prod);
		$sText = mysqli_real_escape_string($link, $text);
		$sName = mysqli_real_escape_string($link, $fname);
		$sZip = mysqli_real_escape_string($link, $zip);

		$writeCon = $resource->getConnection('core_write');
		$query = "insert into un38dj4_rg_questions (prod,text,fname,zip) values (:prod, :text, :fname, :zip)";
		$binds = array(
			'prod' => $sProd,
			'text' => $sText,
			'fname' => $sName,
			'zip' => $sZip,
			);
		// echo "query: " . $query . "<br />";
		$status = $writeCon->query($query, $binds);

		// echo "post succes? " . $status . "<br />";
		echo "Thank you - your question was submitted!";

	} else {
		echo "Please try again - there was a problem submitting your question.";
	}
}

function postAnswer() {

	$resource = Mage::getSingleton('core/resource');
	$link = mysqli_connect("0ef549e90e0f270df4fa0fb70d424e21f53e78af.rackspaceclouddb.com", "94hebi48h48three", "QrwFbKSFyA7E", "8ehdh84_magentothree");
	
	$qid = $_POST["qid"];
	$text = $_POST["text"];
	$fname = $_POST["fname"];
	$zip = $_POST["zip"];

	if (!(empty($qid) || empty($text) || empty($fname) || empty($zip))){
		$sQid = mysqli_real_escape_string($link, $qid);
		$sText = mysqli_real_escape_string($link, $text);
		$sName = mysqli_real_escape_string($link, $fname);
		$sZip = mysqli_real_escape_string($link, $zip);

		$writeCon = $resource->getConnection('core_write');
		$query = "insert into un38dj4_rg_answers (qid,text,fname,zip) values (:qid, :text, :fname, :zip)";
		$binds = array(
			'qid' => $sQid,
			'text' => $sText,
			'fname' => $sName,
			'zip' => $sZip,
			);
		// echo "query: " . $query . "<br />";
		$status = $writeCon->query($query, $binds);

		// echo "post succes? " . $status . "<br />";
		echo "Thank you - your answer was submitted!";

	} else {
		echo "Please try again - there was a problem submitting your answer.";
	}

}