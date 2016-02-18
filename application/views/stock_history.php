<h2>{currentStock}</h2>

<form id="stock" action="/history" method="post">   
    <select name="stockSelector" onchange='if(this.value != 0) { this.form.submit(); }'>
        {stocks}
            <option value={Code}>{Name}</option>
        {/stocks}
    </select> 
 </form>

{move_panel}

{trans_panel}