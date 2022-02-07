<?php
include_once '_header.php';
require_once 'user.php';
require_once 'database.php';
?>
<h1>Register</h1>
<?php
if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['first_name']) && !empty($_POST['last_name'])) {
    if ($_POST['password'] !== $_POST['password2']) {
        echo '<p class="error">Passwords don\'t match</p>';
    } else {
        $fields = $_POST;
        $user = new User($fields['email'], $fields['password'], $fields['first_name'], $fields['last_name']);

        $database = new Database;
        $checkEmail = $database->checkMail($user);
        if ($checkEmail) {
            echo 'LESGO';
            $database = new Database;

            $database->saveUser($user);
        } else {
            echo '<p class="error">Email is already taken.</p>';
        }
    }
} else if (isset($_POST['submit'])) {
    echo '<p class="error">Please fill all fields</p>';
}
?>
<form action="" method="post" class=register>
    <div>
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password2" placeholder="Confirm password">
        <input type="text" name="first_name" placeholder="First name">
        <input type="text" name="last_name" placeholder="Last name">
    </div>
    <button type="submit" name="submit">Register </button>
</form>
<p class="link">Already have an account? Log in <a href="login.php">here</a></p>

<?php

include_once '_footer.php';

?>