<?php
include_once '_header.php';
require_once 'database.php';
require_once 'pet.php';
require_once 'userList.php';
require_once 'addPet.php';

if(!$_SESSION){
    header('Location: login.php');

}
?>

<header>
    <a href="logout.php">Logout</a>
    <p>Welcome <?= $_SESSION['first_name'] ?></p>
</header>


<?php
if ($_SESSION['admin'] == 0) {
?>
    <h1>User Interface</h1>
    <form method="POST" class="add_pet">
        <div class="input_pets_user">
            <input placeholder="Choose your pet's name" name="pet_name">
            <select name="pet_type">
                <option value="Dog">Dog</option>
                <option value="Puppy">Puppy</option>
                <option value="Cat">Cat</option>
                <option value="Kitten">Kitten</option>
                <option value="Hamster">Hamster</option>
                <option value="Rabbit">Rabbit</option>
                <option value="Goldfish">Goldfish</option>
            </select>

        </div>
        <button type="submit" name="submit">Add</button>
    </form>
    <?php

    $types = array('Dog', 'Puppy', 'Cat', 'Kitten', 'Hamster', 'Rabbit', 'Goldfish');

    if (!empty($_POST['pet_name']) && in_array($_POST['pet_type'], $types)) {

        $fields = $_POST;
        $pet = new AddPet($fields['pet_name'], $fields['pet_type'], $_SESSION['id']);
        $database = new Database;

        $database->addPet($pet);
    }
    $database = new Database;
    $pets = $database->getPets($_SESSION['id']);
    ?>
    <div class="pets_container">
        <?php

        foreach ($pets as $pet) {
        ?>
            <div class="pets_user">
                Name : <?= $pet->name ?><br>
                Type : <?= $pet->petType ?><br>
                <?= "<a href='userInterface.php?id=" . $pet->id . "'><i class='fas fa-times'></i></a>" ?>
            </div>
        <?php
        }

        if ($_GET) {
            $database = new Database;
            $database->deletePet($_GET['id']);
            header('Location: userInterface.php');
        }
        ?>
    </div><?php
        } else if ($_SESSION['admin'] == 1) {
            ?>
    <h1>Admin Interface</h1>
    <h2>Users</h2>
    <div class="card_container">
        <?php
            $database = new Database;
            $users = $database->getUsers();

            foreach ($users as $user) {
                if ($user->admin == 1) {
                    $user->admin = "Yes";
                } else {
                    $user->admin = "No";
                }
                $database = new Database;
                $pets = $database->getPets($user->id);
        ?>
            <div class="card_user">
                <p><span>Firstname : </span><?= $user->firstName ?><br>
                    <span>Lastname : </span><?= $user->lastName ?><br>
                    <span>Email : </span><?= $user->email ?><br>
                    <span>Admin : </span><?= $user->admin ?><br>
                    <span>Pet :</span><?php foreach ($pets as $pet) {
                                            echo "<br>" . $pet->name . " (" . $pet->petType . ") ";

                                        ?>
                    <?php
                                        } ?>
                </p><br><br>
            </div>
    
<?php
            }
?></div>
<?php
        }
        include_once '_footer.php';

?>