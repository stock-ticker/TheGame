<div class="col-sm-6">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Player</th>
                <th>Transaction</th>
                <th>Quantity</th>
                <th>DateTime</th>
             </tr>
        </thead>
        <tbody>
            {transactions}
                <tr>
                    <td>{Player}</td>
                    <td>{Trans}</td>
                    <td>{Quantity}</td>
                    <td>{DateTime}</td>
                </tr>
            {/transactions}
        </tbody>
        
     </table>
</div>