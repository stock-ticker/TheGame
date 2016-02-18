 <form id="stock" action="/stockHistory/index" method="post">   
    <select name="stockSelector" onchange='if(this.value != 0) { this.form.submit(); }'>
        {stocks}
            <option value={Code}>{Name}</option>
        {/stocks}
    </select> 
 </form>

<div>
     <table>       
        {transactions}
            <tr>
                <td>{Player}</td>
                <td>{Trans}</td>
                <td>{Quantity}</td>
                <td>{DateTime}</td>
            </tr>
        {/transactions}
     </table>
</div>

 <div>
     <table>       
        {movements}
            <tr>
                <td>{Action}</td>
                <td>{Amount}</td>
                <td>{DateTime}</td>
            </tr>
        {/movements}
     </table>
</div>