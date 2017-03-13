<?php 
 require_once('../mysqli_connect.php');



if ($_SERVER["REQUEST_METHOD"] == "POST")
    { // $_POST['web'] ='http://www.shiksha.com/b-tech/colleges/b-tech-colleges-agartala';
        preg_match_all('@(http://www.shiksha.com/b-tech/colleges/b-tech-colleges-)@',$_POST['web'],$tst);
        
         if(strcmp("http://www.shiksha.com/b-tech/colleges/b-tech-colleges-",$tst[1][0])==0)
        
        {mysqli_query($dbc,"TRUNCATE TABLE data");




preg_match_all('@http://www.shiksha.com/b-tech/colleges/b-tech-colleges-(\w*)@',$_POST["web"],$city);

//adding the regex to find number of colleges
//$data= file_get_contents($_POST["web"]);
$url=$_POST["web"];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$data = curl_exec($ch);
curl_close($ch);







//$data=file_get_contents('http://www.shiksha.com/b-tech/colleges/b-tech-colleges-hyderabad');
$city1="@(?i)" .$city[1][0] . " \((\d*)@" ;
#echo "<br> 1" .$city1;
preg_match_all($city1,$data,$no);

# $no[1][0] consist of the number of colleges in that city


$t=(int) $no[1][0] ;
$p=(int) $t/30;
$p=(int) $p+1;

#for loop for cycling thhrough pages
for($j=1;$j<=$p;$j++)
{   #current citty page link
   
    $page=$tst[1][0] .$city[1][0] ."-" .$j;
     
     //$data= file_get_contents($page);
$url=$page;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$data = curl_exec($ch);
curl_close($ch);

if (preg_match_all('@(?<=<h2 class="tuple-clg-heading">)<a href="(.*)" target="_blank">(.+)</a>@',$data,$match))
{   //match[1][] contains links
    //match[2][] contains names of colleges
    

    #for loop for individual colleges
    for($i=0;$i<30;$i++)
    {  
       //for number of colleges in a page
       //if it is less than 30 we need to break
       if(($match[1][$i])==NULL)
    break;
   
   
   // $col = file_get_contents($match[1][$i])  ; 
    $url=$match[1][$i];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$col = curl_exec($ch);
curl_close($ch);


  #YEAR
  //established $year[0]
   $year[0]=0;
   preg_match('@Established (.*) @',$col,$yr);
   preg_match('@[0-9]+@',$yr[0],$year);
   
   
   if($year[0]==NULL)
   $year[0] =0;
   

      #ADDRESS 
      //$addweb[1]=address
      //$addweb[2]=website
        $addweb[1]=0;
       preg_match('#(?s)\s*"address"\s*:\s*"(.*\s*)",\s*"email"\s+:\s+"[^"]*",\s*"url"\s:\s"(.*)",\s*"telephone"#',$col,$addweb);
      
     
       if($addweb[0]==NULL)
       $addweb[0]=0;
       if($addweb[1]==NULL)
       $addweb[1]=0;
      
      
      #/TITLE                 
    //courses offered $title[1]
   preg_match_all('@(?<=<li class="li-dropdown">)<a class="li-dropdown-a" value="[^"]+">([A-Za-z\s.()-]*)@',$col,$title);
   
    
   #INFRASTRUCTURE
    preg_match_all('@(?<=<h2 class="head-1 gap">Infrastructure / Facilities</h2>
<div class="gap">)(?s)(.*)(?=<script>)@',$col,$it);
	//var_dump($it);
				
    preg_match_all('@<a class="[^"]+">(.*)(<span|</a>)@',$it[0][0],$infra)		;	
//	var_dump($infra[1]);
	
	
    #to convert array to string (college courses in one string)
        $cour=implode(",",$title[1]);
        //var_dump($cour);
	    $inf=implode(",",$infra[1]);

    $query=("INSERT INTO data (cname, cadd, year, courses, infra, web) VALUES  (?,?,?,?,?,?)");
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt,"ssisss",$match[2][$i],$addweb[1],$year[0],$cour,$inf,$addweb[2]);
    mysqli_stmt_execute($stmt);
   
   
     $affected_rows = mysqli_stmt_affected_rows($stmt);

         
    #to test the no of rows inputted
     /*   if($affected_rows == 1){

            echo 'Student Entered' .$i . "<br>";

             mysqli_stmt_close($stmt);
        }else {
            echo 'Error Occurred<br />';
            echo mysqli_error($dbc);
            mysqli_stmt_close($stmt);
           // mysqli_close($dbc);
                }

        */
        
 
    
    }
    echo "data entered";
}
else
{
    echo "failed to get college name and link";
}

}




}
else
{echo "wrong link entered";

// sleep for 10 seconds
//sleep(5);

//Redirect('https://vishnum21998-vishnum1998.cs50.io/input.php', false);
}
}
?>