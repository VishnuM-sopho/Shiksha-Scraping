<table   class="table table-striped">
   <thead>
        <tr>
    <th>Symbol</th>
    <th>Name</th>
    <th>Shares</th>
    <th>Price</th>
    <th>TOTAL</th>
 </tr>
    </thead>
    <tbody align="left">
        

    <?php
   
      
        //print("hello");
  

        foreach ($positions as $position)
        { $a=($position["shares"])*($position["price"]); 
            print("<tr>");
            print("<td>{$position["symbol"]}</td>
            <td>{$position["name"]}</td>
            <td>{$position["shares"]}</td>
            <td>\${$position["price"]}</td>
            
            <td>\${$a}</td>
            </tr>");
        }
   print("<tr>");
       print("<td>CASH</td>");
        print("<td></td>");
         print("<td></td>");
          print("<td></td>");
        print("<td colspan = \"4\" style=\"padding:5px\">\${$cash[0]["cash"]}</td>");
    print("</tr>");
    ?>

</tbody>
</table>
