<?php 
require 'database.php';
$pdo = Database::letsconnect();

if(isset($_POST['ok_btn'])){
    $sql = 'UPDATE user_tb SET access_type = "'.$_POST['access_type'].'" where user_no ="'.$_POST['hidden_user_no'].'"';
    $pdo->query($sql);

}
if(isset($_POST['delete_btn'])){
    $sql = 'DELETE FROM user_tb WHERE user_no ="'.$_POST['hidden_user_no'].'"';
    $pdo->query($sql);
}


if(isset($_POST['resign_btn'])){
    $sql = 'UPDATE user_tb SET access_type = "" where user_no ="'.$_POST['hidden_user_no'].'"';
    $pdo->query($sql);
}


$searched = '';
if(isset($_COOKIE['searched'])){
    $searched = $_COOKIE['searched'];

}

$sql='SELECT * FROM user_tb WHERE user_lastname like "'.$searched.'%" OR user_firstname like "'.$searched.'%" ORDER BY access_type, user_lastname, user_firstname';
foreach($pdo->query($sql) as $row){

    if($row['user_no'] != 'USER0000001'){


        echo '<tr>';

        echo '<td>'.$row['user_lastname'].', '.$row['user_firstname'].'</td>';
        if($row['access_type'] != '')
            echo '<td>'.$row['access_type'].'</td>';
        else{
            echo '<form method="post" id="access_type">';
            echo '<input type="hidden" name="hidden_user_no" value="'.$row['user_no'].'">';
            echo '<td class="d-none d-sm-table-cell">
                            <input required type="radio" name="access_type" value="Administrator">Admin
                            <input required type="radio" name="access_type" value="Staff">Staff
                            <button type="submit" name="ok_btn" class="btn btn-sm btn-success">OK</button>
                    </td>';
            echo '</form>';
        }
        echo '<td>'.$row['user_name'].'</td>';
        echo '<td>'.$row['user_no'].'</td>';

?>
<td>

    <?php 

        if($row['access_type'] != ''){

            echo '<form method="post">';

            echo '<input type="hidden" name="hidden_user_no" value="'.$row['user_no'].'">';
            echo '<button name="resign_btn" type="submit" class="btn btn-sm btn-danger">resign</button>';

            echo '</form>';

        }
        else{
            echo '</form>';
            echo '<form method="post">';
            echo '<input type="hidden" name="hidden_user_no" value="'.$row['user_no'].'">';
            echo '<td>
                            <button class="btn btn-sm btn-danger" name="delete_btn" type="submit">delete
                                </button>
                          </td>';
            echo '</form>';
        }


    ?>

</td>

<?php


        echo '</tr>';

    }
}
?>

<script>
    $(document).ready(function(){

        $('#access_type').validate({
            submitHandler:function(form){

                $.ajax({
                    url:'account_tbody.php',
                    type:"POST",
                    datatype:'json', 
                    data:{hidden_user_no:$('[name="hidden_user_no"]').val(),
                          access_type:$('[name="access_type"]').val(),

                         }, //end data 

                    success:function(msg){
              
                        location.reload();


                    } //end sucess

                }); //end ajax

            }

        });


    });


</script>
