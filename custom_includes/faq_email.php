<?php
if (isset($_REQUEST['email']))
{
  //send email
  $email = $_REQUEST['email'] ;
  $name = $_REQUEST['name'];
  $subject = $_REQUEST['subject'];
  $question = $_REQUEST['question'];

  $emailsubject = "FAQ Email Submission: " . $subject;
  $emailbody = "FAQ Email Submission from " . $name . ": " . $question;

  mail("info@tataharper.com", $emailsubject,
  $emailbody, "From:" . $email);
}
?>