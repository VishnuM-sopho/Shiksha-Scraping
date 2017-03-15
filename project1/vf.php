<?php 
 require_once('../mysqli_connect.php');



if ($_SERVER["REQUEST_METHOD"] == "POST")
    { //$_POST['web'] ='http://www.shiksha.com/b-tech/colleges/b-tech-colleges-chennai';
        preg_match_all('@(http://www.shiksha.com/b-tech/colleges/b-tech-colleges-)@',$_POST['web'],$tst);
          //  var_dump($tst);//
         if(strcmp("http://www.shiksha.com/b-tech/colleges/b-tech-colleges-",$tst[1][0])==0)
        
        {
            mysqli_query($dbc,"TRUNCATE TABLE dataf");


$count =0;


#for loop for cycling thhrough pages
for($j=1;;)
{   #current citty page link
   
     $page=$_POST["web"] ."-" .$j;
 
 #used for getting data from website with $page as URL 
    $url=$page;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $data = curl_exec($ch);
    curl_close($ch);

    #all college details individually stored in $col[0][i]
    preg_match_all('@(?s)<h2.*?Add to Compare@',$data,$col);
    //var_dump($col[0][1]);
    
    #match[1][$i] contains names of colleges
    #match[2][i] contains address
   ( preg_match_all('@(?<=<h2 class="tuple-clg-heading">)<a href="[^"]*" target="_blank">(.+)</a>\s*<p>[^a-z]\s*(.*)</p>@',$data,$match));
   {
    //var_dump($match);
        
        
    for($i=0;$i<30;$i++)
    {
        $count++;
    if(($match[1][$i])==NULL)
    break;
    #reviews $rev[1]
    preg_match('@revw-sec">\s*<span><b>(\d*)@',$col[0][$i],$rev);
    if($rev[1]==NULL)
    $rev[1]=0;
    
   #infra infra[0]
    preg_match_all('@(?<=<h3>)[a-zA-Z/.,\-\s]*(?=</h3>\n<p>)|(?<=<span><b>)[a-zA-Z\s/]*(?=</b>)@',$col[0][$i],$infra);
    $inf=implode(", ",$infra[0]);
     //var_dump($match[1][$i]);
    //var_dump($inf);
     $query=("INSERT INTO dataf (name, location,infra,review) VALUES  (?,?,?,?)");
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt,"ssss",$match[1][$i],$match[2][$i],$inf,$rev[1]);
    mysqli_stmt_execute($stmt);
    
    }
   
   }
    if(preg_match_all('@(ic_right-gry)@',$data)===1)
   { $j=$j+1;
    //echo "<br><br><br><br><br><br><br>" .$j ."<br><br><br>";
       
   }else
    {break;
    }
    }
    
    #after code runs outputting the number of colleges
    $count--;
    echo "Total colleges entered " .$count ;
    
    
    
    
print("    <table   id='t01'>        
   <thead>
        <tr>
   
    <th>Name</th>
    <th>Location</th>
    <th>Infrastructure / Facilities</th>
    <th>Reviews</th>
 </tr>
    </thead>
    <tbody >
    ");
    
     $result = mysqli_query($dbc,"SELECT * FROM dataf");
    

    while($row = mysqli_fetch_array($result))
      {
      //echo $row['name'] . " " . $row['location']. " " . $row['infra']. " " . $row['review']; //these are the fields that you have stored in your database table employee
      //echo "<br />";
      
      
      
      
      print("<tr>");
            print("<td style='border:1px solid black'>{$row['name']}</td>
            <td style='border:1px solid black'>{$row['location']}</td>
            <td style='border:1px solid black'>{$row['infra']}</td>
            <td style='border:1px solid black'>{$row['review']}</td>
            </tr>");
            
      
      
      
      
      }
      print(" </tbody> </table>
");

    }     
    else
    {
        echo "Wrong link entered";
    }
    
    }





?>