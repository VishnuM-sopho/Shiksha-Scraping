<?php

    // configuration
    require("../includes/config.php"); 
    
     $rows=CS50::query("SELECT tran,time,symbol,shares,price from history WHERE userid = ?",$_SESSION["id"]);
    
$positions = [];
foreach ($rows as $row)
{
    
    {
        $positions[] = [
           "tran" => $row["tran"],
                "time" => $row["time"],
                "symbol" => $row["symbol"],
                "shares" => $row["shares"],
                "price" => $row["price"]
                
              
        ];
    }
}
render("historyt.php", ["positions" => $positions,  "title" => "History"]);
?>