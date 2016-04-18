<?php

?>
<div class="col-sm-12">
    <h2>Current account information:</h2>
    <ul>
        <li style="list-style-type: none">Name: {name}</li>
        <li style="list-style-type: none">ID: {ID}</li>
        <li style="list-style-type: none">Privileges: {privilege}</li>
    </ul>
    <h2>Change current information: </h2>
    <div class="col-sm-12">
        <h3>Note: you cannot change your user ID</h3>
        <form name="login" method="post" action="/Manageaccn/submit">
            
        Name:<input type="text" name="name"></input><br/>
        Current Password: <input type="password" name="oldPassword"></input><br/>
        New Password: <input type="password" name="newPassword"></input><br/>
        <input type="submit" value="Submit"/>
        </form>
    </div>
    <br/>
    {adminView}
</div>
