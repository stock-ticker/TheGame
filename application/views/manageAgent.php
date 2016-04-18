<div class="container">
    <h1>Agent Management</h1>
    
    <p>The local database is automatically periodically synced with the BSX server. Resync manually?</p>
    <form name="sync" method="post" action="/manageagent/bsxSync">
    <input type="submit" value="SYNC"/>
    </form>
    
    <p>Update registration information:</p>
    <form name="register" method="post" action="/manageagent/registerAgent">
    Team ID: <input type="text" name="team" required></input><br/>
    Name: <input type="text" name="name" required></input><br/>
    Password: <input type="text" name="password" required></input><br/>
    <input type="submit" value="REGISTER"/>
    </form>
</div>