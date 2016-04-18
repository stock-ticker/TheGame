<div class="user">
    <div class="col-sm-12">
        <h2>{response}</h2>
        <h2>{player}</h2>
    </br>
    <h4>Cash: {cash}</h4>
    <h4>Current Game state: {gameState}</h4>
    </div>
</div>

<div class="holdings col-sm-6">
    <h3>Your Stocks</h3>
    <table class="table table-striped">
        <thead>
              <tr>
                  <th>Stock</th>
                  <th>Code</th>
                  <th>Value</th>
                  <th>Quantity Owned</th>
                  <th>Buy 10 Stock</th>
                  <th>Sell 10 Stocks</th>
                  <th>Stock History</th>
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
                        <form name="buy" method="post" action="/gameplay/index">
                        <input type="hidden" name="stock"value="{Code}">
                        <input type="hidden" name="action"value="buy">
                        <input type="submit" value="BUY"/>
                        </form>
                    </td>
                    <td>
                        <form name="sell" method="post" action="/gameplay/index">
                        <input type="hidden" name="stock"value="{Code}">
                        <input type="hidden" name="action"value="sell">
                        <input type="submit" value="SELL"/>
                        </form>
                    </td>
                    <td>
                        <form name="sell" method="post" action="/gameplay/index">
                        <input type="hidden" name="stock"value="{Code}">
                        <input type="hidden" name="action"value="history">
                        <input type="submit" value="HISTORY"/>
                        </form>
                    </td>
                </tr>
            {/holdings}
        </tbody>
        
     </table>
</div>
<div class="row">  
        {move_panel}
 </div>