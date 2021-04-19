<?php
$host='ec2-18-214-140-149.compute-1.amazonaws.com';
$db = 'd2rcudb9lus5jh';
$username = 'alpowsjvfgoidx';
$password = 'ab3a37d4d8295ac1e98a4a0d321e741c2b8262f7fa363b1c69359c0e26a74b77';
$email='';
$attmonth=2;
$attyear=2021;
//$_POST["empdetails"];
//$data = json_decode($empdetails, true);
 
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
 
try{
//$empdetails = $request->getAttribute('empdetails');
print $empdetails;
    // create a PostgreSQL database connection
    $myPDO = new PDO("pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password");
$sql = "SELECT  array_to_json(y)
FROM (
  SELECT  
    array_agg(
      json_build_object(
'associate_code',associate_code,
'official_email',official_email,
'att_date',att_date,
'attday',attday,
'intime',intime,
'outtime',outtime,
'workedhours',workedhours,
'workedmins',workedmins,
'emp_leave_session',emp_leave_session,
'leave_name',leave_name,
'is_weekly_off',is_weekly_off,
'holiday_desc',holiday_desc
      ) ORDER BY att_date -- Order the elements in the resulting array
    ) AS y
  FROM trn_employee_timesheet 
  where official_email ='$email' AND EXTRACT('month' from  att_date) = $attmonth 
    and EXTRACT('year' from att_date)=$attyear
) x;
";
 
    // print_r($sql);
    
    $myArr = $myPDO->query($sql);
    $myJSON = json_encode($myPDO->query($sql));
    // print_r($myJSON);
 
    foreach($myPDO->query($sql)as $row){
        // print "<br/>";
        print $row[0];
    }
 
}catch (PDOException $e){
    // report error message
    echo $e->getMessage();
}
?>
