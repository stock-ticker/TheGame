<div class="user">
    <div class="col-sm-12">
        {player}
    </br>
    Equity: {equity}</br>
    Cash: {cash}</br>
    </div>
</div>

<div class="holdings col-sm-6">
    <table class="table table-striped">
        <thead>
              <tr>
                  <th>Name</th>
                  <th>Value</th>
                  <th>Held</th>
                  <th>Equity</th>
             </tr>
        </thead>
        <tbody>
            {holdings}
                <tr>
                    <td>{Name}</td>
                    <td>{Value}</td>
                    <td>{Held}</td>
                    <td>{Equity}</td>
                </tr>
            {/holdings}
        </tbody>
        
     </table>
</div>

<form>
    <div class="marketboard col-sm-6">
        <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Code</th>
                        <th>Cost</th>
                        <th>Last Change</th>
                        <th>Selector</th>
                    </tr>
                </thead>
                <tbody>
                {marketboard}
                    <tr>
                        <td>{stock}</td>
                        <td>{code}</td>
                        <td>{cost}</td>
                        <td>{action}</td>
                        <td>{radio}</td>
                    </tr>
                {/marketboard}
                </tbody>
        </table>
    </div>
    <div class="col-sm-6"></div>
    <div class="col-sm-6">
    Quantity:<input type="text" id="quantity" name="quantity" size ="10">
    <input class="btn btn-primary" onclick="buyStock()" value="Buy">
    <input class="btn btn-success" onclick="sellStock()" value="Sell">
    </div>
</form>
<div class="col-sm-6"></div>
<div class ="price col-sm-6">Expected Cost:
    
    <script type="text/javascript">
        function buyStock() 
        {
            //Check to see if player has adequate funds before making call to server
            
            alert("Insufficient Cash for purchase, please adjust quantity.");
        }
        
        function sellStock()
        {
            //Check to see if player has adequate stocks before making call to server
            alert("Quantity to be sold is greater than  quantity owned, please adjust Quantity");
        }
        
        function getExpected()
        {
            //Provides an expected cost based on stock selected and quantity entered asynchronously
        }
        
    </script>
</div>