<div class="row">
     <div class="col-sm-2" style="color:white;padding:0px 5px 0px 15px">
        <h6 style="font-size:25px">Customer's Table</h6>
    </div>
    <div class="col-sm-1">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_customer">+ADD CUSTOMER</button>
    </div>
   
    <div class="offset-sm-5 col-sm-4">
        <input name="search_customer" type="search" class="form-control" placeholder="Search for Customer">

    </div>
</div>
<br>
<div style="height:65vh;background-color:rgba(255,255,255,0.6);overflow-y:scroll;padding:5px;">


    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Customer#</th>
                <th>Address</th>
                <th>Date Added</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="customer_table">
            <?php
            $sql = 'SELECT * FROM customer_tb WHERE customer_status != "removed" and customer_no != "CT000000001" ORDER BY customer_lastname, customer_firstname';
            $ctr=0;
            foreach($pdo->query($sql) as $row){

                echo '<tr>';

                echo '<td>'.$row['customer_lastname'].' , '.$row['customer_firstname'].'</td>';
                echo '<td class="d-none d-sm-none d-md-table-cell">'.$row['customer_no'].'</td>';
                echo '<td class="d-none d-sm-none d-md-table-cell">'.$row['customer_city'].', '.$row['customer_barangay'].', '.$row['customer_street'].'</td>';
                echo '<td class="d-none d-sm-table-cell">'.date('F d, Y', strtotime($row['customer_date_added'])).'</td>';

                echo '<td>';
                echo '<form method="post">';
                echo '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#customer'.$ctr.'">edit</button> ';
                echo '<input type="hidden" name="hidden_customer_no" value="'.$row['customer_no'].'">';
                echo '<button type="submit" name="remove_customer" class="btn btn-sm btn-danger">remove</button>';
                echo '</form>';
                echo '</td>';

                echo '</tr>';


            ?>

            <form method="post">
                <div class="modal fade" id="customer<?php echo $ctr; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="register_user">CUSTOMER NO : <?php echo $row['customer_no']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="customer_no" value="<?php echo $row['customer_no']; ?>">
                                <input required type="text" name="lastname" class="form-control user_form" value="<?php echo $row['customer_lastname']; ?>" pattern="[A-Z][A-Z a-z]{2,}" title="You must input a character and begin with capital letter. Any symbols are not allowed.">
                                <input required type="text" name="firstname" class="form-control user_form" value="<?php echo $row['customer_firstname']; ?>" pattern="[A-Z][A-Z a-z]{2,}" title="You must input a character and begin with capital letter. Any symbols are not allowed.">
                                <input type="text" name="middlename" class="form-control user_form" value="<?php echo $row['customer_middlename']; ?>" pattern="[A-Z][A-Z a-z]{2,}" title="You must input a character and begin with capital letter. Any symbols are not allowed.">
                                <label style="font-size:14px">Customer Address</label>
                                <select readonly name="city" class="form-control user_form">
                                    <?php
                $sql = 'SELECT * FROM tb_city ORDER BY city_name';
                foreach($pdo->query($sql) as $row1){
                    if($row['customer_city'] == $row1['city_name']){
                        echo '<option selected>'.$row1['city_name'].'</option>';
                    }
                    echo '<option>'.$row1['city_name'].'</option>';
                }
                                    ?>
                                </select>
                                <select required name="barangay" class="form-control user_form">
                                    <option value="">--Choose Barangay--</option>
                                    <?php

                $sql = 'SELECT * FROM tb_barangay ORDER BY barangay_name';
                foreach($pdo->query($sql) as $row1){
                    if($row['customer_barangay'] == $row1['barangay_name']){
                        echo '<option selected>'.$row1['barangay_name'].'</option>';
                    }
                    echo '<option>'.$row1['barangay_name'].'</option>';
                }

                                    ?>
                                </select>
                                <input required type="text" name="street" class="form-control user_form" value="<?php echo $row['customer_street']; ?>">

                            </div>
                            <div class="modal-footer">

                                <button type="reset" class="btn">RESET</button>
                                <button type="submit" name="edit_customer" class="btn btn-success">Edit</button>

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
    <div class="modal fade" id="new_customer" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="register_user">ADD NEW CUSTOMER</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input required type="text" name="lastname" class="form-control user_form" placeholder="Last Name" pattern="[A-Z][A-Z a-z]{2,}" title="You must input a character and begin with capital letter. Any symbols are not allowed.">
                    <input required type="text" name="firstname" class="form-control user_form" placeholder="First Name" pattern="[A-Z][A-Z a-z]{2,}" title="You must input a character and begin with capital letter. Any symbols are not allowed.">
                    <input type="text" name="middlename" class="form-control user_form" placeholder="Middle Name (Optional)" pattern="[A-Z][A-Z a-z]{2,}" title="You must input a character and begin with capital letter. Any symbols are not allowed.">
                    <label style="font-size:14px">Customer Address</label>
                    <select readonly name="city" class="form-control user_form">
                        <?php
                        $sql = 'SELECT * FROM tb_city ORDER BY city_name';
                        foreach($pdo->query($sql) as $row){
                            echo '<option>'.$row['city_name'].'</option>';
                        }
                        ?>
                    </select>
                    <select required name="barangay" class="form-control user_form">
                        <option value="">--Choose Barangay--</option>
                        <?php
                        $sql = 'SELECT * FROM tb_barangay ORDER BY barangay_name';
                        foreach($pdo->query($sql) as $row){
                            echo '<option>'.$row['barangay_name'].'</option>';
                        }


                        ?>
                    </select>
                    <input required type="text" name="street" class="form-control user_form" placeholder="Street">

                </div>
                <div class="modal-footer">

                    <button type="reset" class="btn">RESET</button>
                    <button type="submit" name="add_customer" class="btn btn-success">ADD</button>

                </div>
            </div>
        </div>
    </div>
</form>


