<h2>Administer Accounts:</h2>
<div class="col-sm-12">
    <h3>Delete Users:</h3>
    <form id="Selector" action="/manageAccn/deleteUser" method="post">   
        <select name="deleteUser" required>
            <option disabled selected>Select User to Delete</option>
            {deleteUser}
                <option value={userID} name="deleteUser">{userID}</option>
            {/deleteUser}
        </select>
        <input type="submit" value="Submit"/>
    </form>
    <h3>Create Users:</h3>
    <form name="create" method="post" action="/manageAccn/createUser">
    Name: <input type="text" name="name" required></input><br/>
    UserID: <input type="text" name="userid" required></input><br/>
    Password: <input type="password" name="password" required></input><br/>
    <select name="selectPrivilege" required>
            <option disabled selected>Select Privilege</option>
            <option value="user" name="privilege">user</option>
            <option value="admin" name="privilege">admin</option>
    </select>
    <input type="submit" value="Submit"/>
    </form>
    <h3>Edit User:</h3>
    <form id="Selector" action="/manageAccn/editUser" method="post">   
        <select name="editUser" required>
            <option disabled selected>Select User to Edit</option>
            {deleteUser}
                <option value={userID} name="userList">{userID}</option>
            {/deleteUser}
        </select><br/>
        New Name: <input type="text" name="name" required></input><br/>
        New Password: <input type="password" name="password" required></input><br/>
        <select name="selectPrivilege" required>
            <option disabled selected>Select New Privilege</option>
            <option value="user" name="privilege">user</option>
            <option value="admin" name="privilege">admin</option>
        </select><br/>
        <input type="submit" value="Submit"/>
    </form>
</div>

