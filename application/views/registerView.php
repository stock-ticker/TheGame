<?php

?>

<form name="login" method="post" action="/register/submit" enctype="multipart/form-data">
    Name: <input type="text" name="name" required></input><br/>
    UserID: <input type="text" name="userid" required></input><br/>
    Password: <input type="password" name="password" required></input><br/>
    <input id="avatar" name="avatar" type="file" value="Upload Avatar">
<input type="submit" value="Submit"/>
</form>

