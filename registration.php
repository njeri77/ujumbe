<?php
// Connects to your Database
require('connect.php');
//This code runs if the form has been submitted

if (isset($_POST['submit'])) {
//This makes sure they did not leave any fields blank
if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] )
{
    die('You did not complete all of the required fields');
}
// checks if the username is in use
if (!get_magic_quotes_gpc())
{
    $_POST['username'] = addslashes($_POST['username']);
}
    $usercheck = $_POST['username'];

    $check = mysql_query("SELECT username FROM users WHERE username = '$usercheck'")   or die(mysql_error());
    $check2 = mysql_num_rows($check);

    //if the name exists it gives an error
    if ($check2 != 0)
    {
        die('Sorry, the username '.$_POST['username'].' is already in use.');
    }
    //  this makes sure both passwords entered match
    if ($_POST['pass'] != $_POST['pass2'])
    {
        die('Your passwords did not match. ');
    }
    // here we encrypt the password and add slashes if needed
    $_POST['pass'] = md5($_POST['pass']);
    if (!get_magic_quotes_gpc())
    {
        $_POST['pass'] = addslashes($_POST['pass']);
        $_POST['username'] = addslashes($_POST['username']);
    }
    // now we insert it into the database
    $insert = "INSERT INTO users ( username, password, fname, lname, usertype_id)  VALUES ('".$_POST['username']."', '".$_POST['pass']."','".$_POST['fname']."', '".$_POST['lname']."', '".$_POST['usertype_id']."')";
    $add_member = mysql_query($insert);

    ?>
    <h1>Registered</h1>
    <p>Thank you, you have registered - you may now login</a>.
    </p>


    <?php
}
else
{
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <center>
            <br>PERSON DETAILS </br>
            <table border="100">
        </center>
        <table border="10">
            <tr>
                <td>First Name:</td>
                <td> <input type="Text"name ="fname" maxlenghth="60" </td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td> <input type="Text"name ="lname" maxlenghth="60" </td>
            </tr>

            <tr>
                <td>Username:</td>
                <td>  <input type="text" name="username" maxlength="60">  </td>
            </tr>
            <tr>
                <td>Usertype ID:</td>
                <td>                    <select name="usertype_id">
                    <option value="1">Student</option>
                    <option value="2">Staff</option>
                    <option value="3">Admin</option
                    </select></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td>  <input type="password" name="pass" maxlength="10">  </td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
                <td>  <input type="password" name="pass2" maxlength="10">  </td>
            </tr>
            <tr>
                <th colspan=2><input type="submit" name="submit"  value="Register"></th></tr>
        </table>
    </form>
<?php  } ?>