<form action="sell.php" method="post">
    <fieldset>
        <div class="form-group">
            <select  class="form-control" name="symbol">
                
                <option disabled selected name="">Symbol</option>
                <?php               
	                foreach ($stocks as $symbol)	
                    {   
                        echo("<option name='$symbol'>" . $symbol . "</option>");
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="submit">Sell</button>
        </div>
    </fieldset>
</form>