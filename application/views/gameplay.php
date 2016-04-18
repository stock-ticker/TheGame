<div class="user">
    <div class="col-sm-12">
        <h2>{player}</h2>
    </br>
    Cash: {cash}</br>
    </div>
</div>

<div class="holdings col-sm-6">
    <table class="table table-striped">
        <thead>
              <tr>
                  <th>Stock</th>
                  <th>Code</th>
                  <th>Value</th>
                  <th>Quantity Owned</th>
                  <th>Buy Stock</th>
                  <th>Sell Stock</th>
             </tr>
        </thead>
        <tbody>
            {holdings}
                <tr>
                    <td>{Stock}</td>
                    <td>{Code}</td>
                    <td>{Value}</td>
                    <td>{Quantity}</td>
                    <td>
                        <form name="buy" method="post" action="/gameplay/submit">
                        <input type="hidden" name="stock"value="{Code}">
                        <input type="hidden" name="action"value="buy">
                        <input type="submit" value="BUY"/>
                        </form>
                    </td>
                    <td>
                        <form name="sell" method="post" action="/gameplay/submit">
                        <input type="hidden" name="stock"value="{Code}">
                        <input type="hidden" name="action"value="sell">
                        <input type="submit" value="SELL"/>
                        </form>
                    </td>
                </tr>
            {/holdings}
        </tbody>
        
     </table>
</div>

<form>
    <div class="marketboard col-sm-6">
        <div class ="countdown"></div>
        <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Code</th>
                        <th>Cost</th>
                        <th>Selector</th>
                    </tr>
                </thead>
                <tbody>
                {marketboard}
                    <tr>
                        <td>{stock}</td>
                        <td>{code}</td>
                        <td>{cost}</td>
                        <td> <input type="radio" name="selected" value ={radio}></td>
                    </tr>
                {/marketboard}
                </tbody>
        </table>
    </div>
    <div class="col-sm-6"></div>
    <div class="col-sm-2">
    Quantity:<input type="text" id="quantity" name="quantity" size ="10">
    </div>
    <div class="col-sm-2">
    <input class="btn btn-primary" onclick="buyStock()" value="Buy">
    </div>
    <div class="col-sm-2">
    <input class="btn btn-success" onclick="sellStock()" value="Sell">
    </div>
</form>
    
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
        
        
        function updateStatus(){
            $.ajax({
               
            })
        }
    </script>