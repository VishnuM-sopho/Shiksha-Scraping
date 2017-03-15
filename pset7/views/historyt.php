<table class="table table-striped">

    <thead>
        <tr>
            <th>Transaction</th>
            <th>Date/Time</th>
            <th>Symbol</th>
            <th>Shares</th>
            <th>Price</th>
        </tr>
    </thead>

    <tbody align="left">
        

    <?php
   
      
        //print("hello");
  

        foreach ($positions as $position)
        { //$a=($position["shares"])*($position["price"]); 
            print("<tr>");
            print("<td>{$position["tran"]}</td>
            <td>{$position["time"]}</td>
            <td>{$position["symbol"]}</td>
            <td>{$position["shares"]}</td>
            <td>\${$position["price"]}</td>
           
            </tr>");
        }
 
    ?>

</tbody>
</table>