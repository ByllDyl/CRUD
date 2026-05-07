<?php
    include('config.php');

    $sql = mysqli_query($conn, "SELECT * FROM residents");

?>


<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD operations</title> 
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="container" >
        <button class = "add" id="add">ADD +</button>
        <form action="action.php" method="post">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Voter?</th>
                    <th>Action</th>
                </tr>

                <?php
                    $no =1;
                    while ($user = mysqli_fetch_assoc($sql)):
                ?>

                <tr>
                    <td><?=  $no++ ?></td>
                    <td><?=  $user['first_name'] ?></td>
                    <td><?=  $user['last_name'] ?></td>
                    <td><?=  $user['gender'] ?></td>
                    <td><?=  $user['voter'] ?></td>
                    <td>
                        <button type="button" class="edit" data-id="<?= isset($user['id']) ? $user['id'] : '' ?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name'] ?>" data-gender="<?= $user['gender'] ?>" data-voter="<?= $user['voter'] ?>">EDIT</button> 
                        <button type="submit" name="delete_id" value="<?= isset($user['id']) ? $user['id'] : '' ?>" class="delete" onclick="return confirm('Are you sure you want to delete this resident?');">DELETE</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </form>
    </div>

    <div class="modal-container" id="main-modal">
        <div class="modal" id="modal-edit">
            <form action="action.php" method="post">
                <input type="hidden" name="user_id" id="edit-id">
                <h2>Edit User</h2>
                <div class="row-input">
                    <input type="text" name="firstName" id="edit-fname" placeholder="First Name" required>
                    <input type="text" name="lastName" id="edit-lname" placeholder="Last Name" required>
                </div>
                <div class="row-input">
                    <select name="Gender" id="edit-gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select name="Voter" id="edit-voter">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel">Cancel</button>
                    <button type="submit" name="edit_user" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
        <div class="modal" id="modal-add">
            <form action="action.php" method="post">
                <h2>Add User</h2>
                <div class="row-input">
                    <input type="text" name="firstName" placeholder="First Name" required>
                    <input type="text" name="lastName" placeholder="Last Name" required>
                </div>
                <div class="row-input">
                    <select name="Gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <select name="Voter">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select> 
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel">Cancel</button>
                    <button type="submit" name="add_user" class="btn-save">Save User</button>
                </div>
            </form>
        </div>
    </div>


    <script src="script.js?v=2"></script>
</body>
</html>