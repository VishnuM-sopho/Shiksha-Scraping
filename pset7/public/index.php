<?php

    // configuration
    require("../includes/config.php"); 
    
    $rows=CS50::query("SELECT symbol,shares,userid from portfolio WHERE userid = ?",$_SESSION["id"]);
    
$positions = [];
foreach ($rows as $row)
{
    $stock = lookup($row["symbol"]);
    if ($stock !== false)
    {
        $positions[] = [
           "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => $row["symbol"],
                
                "total" => $stock["price"] * $row["shares"]
        ];
    }
}

    $cash = CS50::query("SELECT cash FROM users WHERE id =?", $_SESSION["id"]);

    // render portfolio
 
  render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);

 
 ?>
