<?php 
 require_once('../mysqli_connect.php');

/*$query1="TRUNCATE TABLE data" ;
$stmt1=mysqli_prepare($dbc,$query1);
mysqli_stmt_execute($stmt1);
*/
//mysqli_query($dbc,"TRUNCATE TABLE data");


$data= file_get_contents('http://engineering.shiksha.com/be-btech-courses-in-chennai-2-ctpg');
//var_dump($data);
//preg_match_all('@<a class="institute-title-clr" href=(.+) ',$data,$link);
if (preg_match_all('@(?<=<h2 class="tuple-clg-heading">)<a href="(.*)" target="_blank">(.+)</a>@',$data,$match))
{   //match[1][] contains links
    //match[2][] contains names of colleges
    

   // var_dump($match[1][3]);
    for($i=0;$i<3;$i++)
    {
    $col = file_get_contents($match[1][$i])  ; 
   //established $year[0]
   $year[0]=0;
   preg_match('(Established\s.[^<]+)',$col,$yr);
   preg_match('@[0-9]+@',$yr[0],$year);
   
   if($year[0]==NULL)
   $year[0] =0;
   
      //address $add[0]
       preg_match('@(?<=<span class="flLt add-details">)[\s\S]*(?=<\/span>
                            <\/p>
                        <\/li>)@',$col,$add);
                        
    //courses offered $title[1]
    preg_match_all('@<a uniqueattr="LISTING_INSTITUTE_PAGES/CO_LINK_CLICK" href="[^"]+">(.+), </a> <span>@',$col,$title);
    
    //college website $web[0]
    preg_match('@(?<=target="_blank" rel="nofollow">)(.*)(?=<\/a>)@',$col,$web);
    
    
    //infra $infra[0]
    preg_match_all('@(?<=<h3  uniqueattr="NATIONAL_INSTITUTE_PAGE/Wiki_Infrastructure / Teaching Facilities">)[^.]*<ul>([^.]*)</ul>@',$col,$it);
				
    //preg_match_all("/<h3[^.]+ uniqueattr=\"NATIONAL_INSTITUTE_PAGE\/Wiki_Infrastructure \/ Teaching Facilities\">[^.]*<ul>([^.]*)<\/ul>/",$col,$it);
				
//	var_dump($it[1][0]);
	

	preg_match_all('@[A-Z]+(.*)(?=<\/li>)@',$it[1][0],$infra);

        $cour=implode(",",$title[1]);
        //var_dump($cour);
	    $inf=implode(",",$infra[0]);
//	echo "course" .$cour ."infrastr <br>" .$inf ;
/*$query1="TRUNCATE TABLE data" ;
$stmt1=mysqli_prepare($dbc,$query1);
mysqli_stmt_execute($stmt1);
*/	
$query=("INSERT INTO data (cname, cadd, year, courses, infra, web) VALUES  (?,?,?,?,?,?)");
     $stmt = mysqli_prepare($dbc, $query);
     mysqli_stmt_bind_param($stmt,"ssisss",$match[2][$i],$add[0],$year[0],$cour,$inf,$web[0]);
    mysqli_stmt_execute($stmt);
   
   
     $affected_rows = mysqli_stmt_affected_rows($stmt);

         

        if($affected_rows == 1){

            echo 'Student Entered' .$i . "<br>";

             mysqli_stmt_close($stmt);
        }else {
            echo 'Error Occurred<br />';
            echo mysqli_error($dbc);
            mysqli_stmt_close($stmt);
           // mysqli_close($dbc);
                }

        
        
    //mysqli_query($dbc,$query);
   /* echo "college name   :   " .$match[2][$i] . "<br>" ." address " .$add[0] ;
    echo "establihed in " .$year[0] ."courses  :" . "<br>"  ;
  
    foreach($title[1] as $value)
        {
       echo $value . "<br>";
        }
        
        echo "infra <br>";
    foreach($infra[0] as $value)
        {
       echo $value . "<br>";
        }
    echo "website " .$web[0];
    
    echo   "<br>". "<br>". "<br>" . "<br>". "<br>";
    
    */
    }
}
else
{
    echo "failed";
}










?>