<h2>{currentStockName}</h2>

<form id="stock" action="/history" method="post">   
    <select name="stockSelector" onchange='if(this.value != 0) { this.form.submit(); }'>
              <option disabled selected>Select Stock</option>
        {stocks}
            <option value={Code}>{Name}</option>
        {/stocks}
    </select> 
 </form>

<div class="container">
    <div class="row">
        {move_panel}
    </div>
    <div class="row">
        {trans_panel}
    </div>
</div>


