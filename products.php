<div class="row">
    <div class="col-sm-2" style="color:white;padding:0px 5px 0px 15px">
        <h6 style="font-size:25px">Product's Table</h6>
    </div>
    <div class="col-sm-1">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#new_product">+ADD PRODUCT</button>
    </div>

    <div class="offset-sm-5 col-sm-4">
        <input name="search_product" type="search" class="form-control" placeholder="Search for products">

    </div>
</div>
<br>
<div style="height:65vh;background-color:rgba(255,255,255,0.6);overflow-y:scroll;padding:5px;">


    <table class="table">
        <thead>
            <tr>
                <th>Product Category</th>
                <th>Product Name</th>
                <th>Barcode</th>
                <th>List Price</th>
                <th>Selling Price</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="product_table">
            <?php
            $sql = 'SELECT * FROM product_tb WHERE product_status != "removed" ORDER BY product_category, product_name';
            $ctr=0;
            foreach($pdo->query($sql) as $row){

                //string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = "," )


                echo '<tr>';
                echo '<td>'.$row['product_category'].'</td>';
                echo '<td>'.$row['product_name'].'</td>';
                echo '<td>'.$row['barcode'].'</td>';
                echo '<td>&#8369;'.number_format($row['product_list_price'],2,'.',',').'</td>';
                echo '<td>&#8369;'.number_format($row['product_selling_price'],2,'.',',').'</td>';
                echo '<td>';

                echo '<form method="post">';
                echo '<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#product'.$ctr.'">edit</button> ';
                echo '<input type="hidden" name="hidden_barcode" value="'.$row['barcode'].'">';
                echo '<button type="submit" name="remove_product" class="btn btn-sm btn-danger">remove</button>';
                echo '</form>';


                echo '</td>';
                echo '</tr>';


            ?>

            <form method="post">
                <div class="modal fade" id="product<?php echo $ctr; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="register_user">BARCODE : <?php echo $row['barcode']; ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input list="barcodes" class="form-control user_form" name="barcode" value="<?php echo $row['barcode']; ?>" maxlength="11" autocomplete="off" readonly>
                                <datalist id="barcodes">
                                    <?php
                $sql = 'SELECT DISTINCT * FROM product_tb ORDER BY barcode';
                foreach($pdo->query($sql) as $row1){
                    echo '<option value="'.$row1['barcode'].'">TAKEN</option>';
                }
                                    ?>
                                </datalist>

                                <input list="category" class="form-control user_form" name="product_category" value="<?php echo $row['product_category']; ?>" autocomplete="off">
                                <datalist id="category">
                                    <?php
                $sql = 'SELECT DISTINCT product_category FROM product_tb';
                foreach($pdo->query($sql) as $row1){
                    echo '<option>'.$row1['product_category'].'</option>';
                }
                                    ?>
                                </datalist>

                                <label>Product Name</label>
                                <input list="products" class="form-control user_form" name="product_name" value="<?php echo $row['product_name']; ?>" autocomplete="off">
                                <datalist id="products">
                                    <?php
                $sql = 'SELECT DISTINCT * FROM product_tb ORDER BY product_name';
                foreach($pdo->query($sql) as $row1){
                    echo '<option>'.$row1['product_name'].'</option>';
                }
                                    ?>
                                </datalist>


                                <label>List Price:</label>
                                <input name_id="list<?php echo $ctr; ?>" type="number" min="0" max="999999" class="form-control user_form" name="list_price" step="0.01" value="<?php echo $row['product_list_price']; ?>">
                                <label>Selling Price: (TAXRATE <?php echo ($hardware['tax_rate']*100) ?>%)</label>
                                <input name_id="selling<?php echo $ctr; ?>" readonly type="number" min="0" max="999999" class="form-control user_form" name="selling_price" step="0.01" value="<?php echo $row['product_selling_price']; ?>">


                            </div>
                            <div class="modal-footer">

                                <button type="reset" class="btn">RESET</button>
                                <button type="submit" name="edit_product" class="btn btn-success">Edit</button>


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
    <div class="modal fade" id="new_product" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="register_user">ADD NEW PRODUCT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input list="barcodes" class="form-control user_form" name="barcode" placeholder="Enter barcode" maxlength="11" autocomplete="off">
                    <datalist id="barcodes">
                        <?php
                        $sql = 'SELECT DISTINCT * FROM product_tb ORDER BY barcode';
                        foreach($pdo->query($sql) as $row){
                            echo '<option value="'.$row['barcode'].'">TAKEN</option>';
                        }
                        ?>
                    </datalist>

                    <input list="category" class="form-control user_form" name="product_category" placeholder="Product Category" autocomplete="off">
                    <datalist id="category">
                        <?php
                        $sql = 'SELECT DISTINCT product_category FROM product_tb';
                        foreach($pdo->query($sql) as $row){
                            echo '<option>'.$row['product_category'].'</option>';
                        }
                        ?>
                    </datalist>

                    <label>Product Name</label>
                    <input list="products" class="form-control user_form" name="product_name" autocomplete="off">
                    <datalist id="products">
                        <?php
                        $sql = 'SELECT DISTINCT * FROM product_tb ORDER BY product_name';
                        foreach($pdo->query($sql) as $row){
                            echo '<option>'.$row['product_name'].'</option>';
                        }
                        ?>
                    </datalist>


                    <label>List Price:</label>
                    <input name_id="list<?php echo $ctr; ?>" type="number" min="0" max="999999" class="form-control user_form" name="list_price" step="0.01" placeholder="0.00">
                    <label>Selling Price: (TAXRATE <?php echo ($hardware['tax_rate']*100) ?>%)</label>                    
                    <input name_id="selling<?php echo $ctr; ?>" type="number" readonly min="0" max="999999" class="form-control user_form" name="selling_price" step="0.01" placeholder="0.00">


                </div>
                <div class="modal-footer">

                    <button type="reset" class="btn">RESET</button>
                    <button type="submit" name="add_product" class="btn btn-success">ADD</button>


                </div>
            </div>
        </div>
    </div>
</form>


