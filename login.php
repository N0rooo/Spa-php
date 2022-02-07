<?php
include_once '_header.php';
?>

<h1>Login</h1>


<?php

require_once  'loginUser.php';
require_once 'database.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $fields = $_POST;

    $user = new LoginUser($fields['email'], $fields['password']);
    $database = new Database;

    $login = $database->login($user);

    if ($login == true) {
        echo "FirstName : " . $_SESSION['first_name'] . "<br>";
        echo "Admin : " . $_SESSION['admin'] . "<br>";
    } else {
        echo '<p class="error">Information doesn\'t match</p>';

    }
} else if (isset($_POST['submit'])) { 
    echo '<p class="error">Please fill all fields</p>';
}
?>

<form action="" method="post" class="login">
    <div>
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
    </div>
    <button type="submit" name="submit">Login</button>
</form>
<p class="link">Do not have an account yet ? Register <a href="index.php">here</a></p>
<?php
include_once '_footer.php';

?>
