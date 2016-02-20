<h1>{selectedPlayer}</h1>
<h2>Player Cash: ${playerCash}</h2>

<form id="playerSelector" action="/profile" method="post">   
    <select name="playerSelector" onchange='if(this.value != 0) { this.form.submit(); }'>
        <option disabled selected>select Player</option>
        {players}
            <option value={Name}>{Name}</option>
        {/players}
    </select> 
 </form>



<div class="col-sm-6">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Stock</th>
                <th>Transaction</th>
                <th>Quantity</th>
                <th>DateTime</th>
             </tr>
        </thead>
        <tbody>
            {transactions}
                <tr>
                    <td>{Stock}</td>
                    <td>{Trans}</td>
                    <td>{Quantity}</td>
                    <td>{DateTime}</td>
                </tr>
            {/transactions}
        </tbody>
        
     </table>
</div>

<div class="col-sm-6">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Stock</th>
                <th>Quantity</th>
             </tr>
        </thead>
        <tbody>
            {holdings}
                <tr>
                    <td>{Stock}</td>
                    <td>{Quantity}</td>
                </tr>
            {/holdings}
        </tbody>
        
     </table>
</div>