<?php
$host='localhost';
$db = 'postgres';
$username = 'postgres';
$password = 'kgisl123';
$email='baraneetharan.r@kgisl.com';
$attmonth=2;
$attyear=2021;
 
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
 
try{
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
