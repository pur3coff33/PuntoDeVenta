<div class="row">
    <div class="col-sm-2" style="color:white;padding:0px 5px 0px 15px">
        <h6 style="font-size:25px">Account's Table</h6>
    </div>

    <div class="offset-sm-6 col-sm-4">
        <input name="search_account" type="search" class="form-control" placeholder="Search account on the database." >

    </div>
</div>
<br>
<div style="height:65vh;background-color:rgba(255,255,255,0.6);overflow-y:scroll;padding:5px;">


    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Access Type</th>
                <th>Username</th>
                <th>User#</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="account_table">
            <?php    

            $searched = '';
            if(isset($_COOKIE['searched'])){
                $searched = $_COOKIE['searched'];

            }

            $sql='SELECT * FROM user_tb WHERE user_status != "removed" ORDER BY access_type, user_lastname, user_firstname';
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
                        echo '<button class="btn btn-sm btn-danger" name="delete_btn" type="submit">remove</button>';
                        echo '</form>';
                    }


                ?>

            </td>

            <?php


                    echo '</tr>';

                }
            }
            ?>



        </tbody>


    </table>
</div>
