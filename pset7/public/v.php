<?php 
 require("../includes/config.php"); 

$data= file_get_contents('http://engineering.shiksha.com/be-btech-courses-in-chennai-2-ctpg');
//var_dump($data);
//preg_match_all('@<a class="institute-title-clr" href=(.+) ',$data,$link);
if (preg_match_all('@<a class="institute-title-clr" href="(.+)" title="[^"]+">(.+)</a><span>@',$data,$match))
{   //match[1][] contains links
    //match[2][] contains names of colleges
    
   // var_dump($match[1][3]);
    for($i=0;$i<2;$i++)
    {
    $col = file_get_contents($match[1][$i])  ; 
   //established $year[0]
   preg_match('(Established\s.[^<]+)',$col,$yr);
   preg_match('@[0-9]+@',$yr[0],$year);
   
   
      //address $add[0]
       preg_match('@(?<=<span class="flLt add-details">)[\s\S]*(?=<\/span>
                            <\/p>
                        <\/li>)@',$col,$add);
                        
    //courses offered $title[1]
    preg_match_all('@<a uniqueattr="LISTING_INSTITUTE_PAGES/CO_LINK_CLICK" href="[^"]+">(.+), </a> <span>@',$col,$title);
    
    //college website $web[0]
    preg_match('@(?<=target="_blank" rel="nofollow">)(.*)(?=<\/a>)@',$col,$web);
    
    
    //infra $infra[0]
    preg_match_all('@(?<=<h3  uniqueattr="NATIONAL_INSTITUTE_PAGE/Wiki_Infrastructure / Teaching Facilities">)[\s\S]*(?=<\/ul>
				<\/div>)@',$col,$it);
	var_dump($it);
	

	preg_match_all('@[A-Z]+(.*)(?=<\/li>)@',$it[0],$infra);

        $cour=implode(",",$title[1]);
        //var_dump($cour);
	    $inf=implode(",",$infra[0]);
//	echo "course" .$cour ."infrastr <br>" .$inf ;
	
//	CS50::query("INSERT INTO data2 (cname, cadd, year, courses, infra, web) VALUES  (?,?,?,?,?,?)",$match[2][$i],$add[0],$year[0],$cour,$inf,$web[0]);
    
  /*  echo "college name   :   " .$match[2][$i] . "<br>" ." address " .$add[0] ;
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
    
    echo   "<br>". "<br>". "<br>" . "<br>". "<br>";*/
    
    
    }
}
else
{
    echo "failed";
}










?>