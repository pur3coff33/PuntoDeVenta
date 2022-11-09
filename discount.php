<div class="row">
  <div class="col-sm-2" style="color:white;padding:0px 5px 0px 15px">
        <h6 style="font-size:25px">Discount's Table</h6>
    </div>
    <div class="col-sm-1">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_discount">+ADD DISCOUNT</button>
    </div>
   
    <div class="offset-sm-5 col-sm-4">
        <input name="search_discount" type="search" class="form-control" placeholder="Search for Discount">

    </div>
</div>
<br>
<div style="height:65vh;background-color:rgba(255,255,255,0.6);overflow-y:scroll;padding:5px;">


    <table class="table">
        <thead>
            <tr>
                <th>Discount Code</th>
                <th>Discount Name</th>
                <th>Price Off</th>

                <th></th>
            </tr>
        </thead>
        <tbody id="discount_table">
            <?php
            $sql = 'SELECT * FROM discount_tb WHERE discount_status != "removed" AND discount_code !="NONE" ORDER BY discount_code';
            foreach($pdo->query($sql) as $row){

                echo '<tr>';
                echo '<td>'.$row['discount_code'].'</td>';
                echo '<td>'.$row['discount_name'].'</td>';
                echo '<td>'.($row['discounted_price']*100).'%</td>';
                echo '<td>';

                echo '<form method="post">';
                echo '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#discount'.$ctr.'">edit</button> ';
                echo '<input type="hidden" name="hidden_discount_code" value="'.$row['discount_code'].'">';
                echo '<button type="submit" name="remove_discount" class="btn btn-sm btn-danger">remove</button>';
                echo '</form>';


                echo '</td>';
                echo '</tr>';


            ?>

            <form method="post">
                <div class="modal fade" id="discount<?php echo $ctr; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="register_user">DISCOUNT CODE: <?php echo $row['discount_code']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="discount_code" value="<?php echo $row['discount_code']; ?>">

                                <label>Discount Name:</label>
                                <input class="form-control user_form" name="discount_name" value="<?php echo $row['discount_name']; ?>" autocomplete="off">

                                <label>Discount Percentage: (0-100 only)</label>
                                <input type="number" min="0" max="100" class="form-control user_form" name="discount_percentage" step="1" value="<?php echo $row['discounted_price']*100; ?>">


                            </div>
                            <div class="modal-footer">

                                <button type="reset" class="btn">RESET</button>
                                <button type="submit" name="edit_discount" class="btn btn-success">Edit</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <?php
                $ctr++;
            }
            ?>
        </tbody>


    </table>
</div>

<form method="post">
    <div class="modal fade" id="new_discount" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="register_user">ADD NEW DISCOUNT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label>Discount Code:</label>
                    <input list="discount_codes" class="form-control user_form" name="discount_code" placeholder="Discount Code" maxlength="11" autocomplete="off">
                    <datalist id="discount_codes">
                        <?php
                        $sql = 'SELECT DISTINCT * FROM discount_tb ORDER BY discount_code';
                        foreach($pdo->query($sql) as $row){
                            echo '<option value="'.$row['discount_code'].'">TAKEN</option>';
                        }
                        ?>
                    </datalist>

                    <label>Discount Name:</label>
                    <input class="form-control user_form" name="discount_name" placeholder="Discount Name" autocomplete="off">

                    <label>Discount Percentage: (0-100 only)</label>
                    <input type="number" min="0" max="100" class="form-control user_form" name="discount_percentage" step="0.01" placeholder="0">


                </div>
                <div class="modal-footer">

                    <button type="reset" class="btn">RESET</button>
                    <button type="submit" name="add_discount" class="btn btn-success">ADD</button>


                </div>
            </div>
        </div>
    </div>
</form>


