<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Player</th>
                        <th>Cash</th>
                    </tr>
                </thead>
                <tbody>
                {players_panel}
                    <tr>
                        <td>{Player}</td>
                        <td>{Cash}</td>
                    </tr>
                {/players_panel}
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Category</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                {stocks_panel}
                    <tr>
                        <td>{Name}</td>
                        <td>{Code}</td>
                        <td>{Category}</td>
                        <td>{Value}</td>
                    </tr>
                {/stocks_panel}
                </tbody>
            </table>
        </div>
    </div>
</div>