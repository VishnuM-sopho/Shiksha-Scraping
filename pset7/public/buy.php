<?php


// configuration 
require("../includes/config.php");   

// if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    
    // if symbol or shares empty
    if (empty($_POST["symbol"]) || empty($_POST["shares"]))
    {
        // apologize
        apologize("Dont leave coloumns empty");
    }

    // if symbol is invalid
    if (lookup($_POST["symbol"]) === false)
    {
        // apologize
        apologize("Invalid stock symbol.");
    }

    // if shares is invalid (not a whole positive integer)
    if (preg_match("/^\d+$/", $_POST["shares"]) == false)
    {
        // apologize
        apologize("You must enter a whole, positive integer.");
    }

    // lookup the symbol 
$t = lookup($_POST["symbol"]);
 $price = $t["price"];
 $stock=$t["symbol"];
 //$result = CS50::query("SELECT shares FROM portfolio WHERE userid = ? AND symbol = ?", $_SESSION["id"], $_POST["symbol"]);
//$shares= $result[0]['shares'];
 $cost =$_POST["shares"]*$price;
    // calculate total cost (stock's price * shares)        

    // find out how much cash the user has, like...
    $result = CS50::query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);  
$cash= $result[0]['cash'];

    if ($cash < $cost)
    {
        // apologize
        apologize("You can't buy this.");
    }         

    // else if the user can afford the price
    else
    {
        // make the purchase
        CS50::query("UPDATE users set cash = cash - ? WHERE id = ? ",$cost,$_SESSION["id"]);
         CS50::query("INSERT INTO portfolio (userid, symbol, shares) VALUES (?,?,?) ON DUPLICATE KEY UPDATE shares = shares + ?",$_SESSION["id"], $stock, $_POST["shares"] ,  $_POST["shares"]);
        
        CS50:: query("INSERT INTO history (tran,userid, symbol, shares, price) VALUES(?, ?, ?, ?, ?)",'BUY',$_SESSION["id"], strtoupper($_POST['symbol']), $_POST["shares"],$price);  

        
        //redirect to index to show the table of shares
       redirect("/");  
    }
}    
else
{
    // render buy form
    render("buy_form.php", ["title" => "Buy Form"]);
}


?>