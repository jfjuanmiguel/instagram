<!DOCTYPE html>
<html lang="en">
<head>
    <title>Instagram API Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Instagram Users</h2>
    <form id="form" name="form">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Media</th>
                <th>Follows</th>
                <th>Followed By</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($users as $user)
                {
                    echo "<tr>";
                    echo "    <td><a href='https://www.instagram.com/{$user->user_name}' target='_blank'>{$user->user_name}</a></td>";
                    echo "    <td>{$user->user_media}</td>";
                    echo "    <td>{$user->user_follows}</td>";
                    echo "    <td>{$user->user_followedby}</td>";
                    echo "    <td>";
                    echo "        <button type='button' class='btn btn-default' id='btn_update'>Update</button>";
                    echo "    </td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $users[0]->user_id;?>">
        <input type="hidden" name="user_token" id="user_token" value="<?php echo $users[0]->user_token;?>">
    </form>
</div>

<script>
    $(document).ready(function(){
        $("#btn_update").click(function(){

            var data = $("#form").serialize();

            $.ajax({
                url: "updateUser",
                type: "POST",
                data: data,
                success: function(res) {
                    switch (res) {
                        case '0':
                            alert("The user data was updated");
                            window.location.href = "showUsers";
                            break;
                        case '-1':
                            alert("Troubles...");
                            break;
                    }
                }
            });

        });
    });

</script>

</body>
</html>