<div class="row">
    <div class="col-sm-2" style="color:white;padding:0px 5px 0px 15px">
        <h6 style="font-size:25px">Transaction's Table</h6>
    </div>
    <div class="col-sm-1">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#sales_count">SALES COUNT</button>
    </div>

    <div class="col-sm-1">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#today_sales">TODAY'S SALE</button>
    </div>

    <div class="offset-sm-4 col-sm-4">
        <input name="search_transactions" type="search" class="form-control" placeholder="Search for transactions.">

    </div>
</div>
<br>
<div style="height:65vh;background-color:rgba(255,255,255,0.6);overflow-y:scroll;padding:5px;">


    <table class="table">
        <thead>
            <tr>
                <th>Transaction No.</th>
                <th>Cashier</th>
                <th>Customer</th>
                <th>Discount</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="transactions_table">
            <?php

            $sql = 'SELECT * FROM transaction_rl join user_tb, customer_tb,discount_tb WHERE user_tb.user_no=transaction_rl.user_no AND customer_tb.customer_no=transaction_rl.customer_no AND discount_tb.discount_code=transaction_rl.discount_code AND transaction_rl.transaction_status != "" ORDER BY transaction_date DESC, transaction_no DESC';

            foreach($pdo->query($sql) as $row){

                if($row['transaction_status'] == 'SUCCESS'){
                    $transaction_status='GREEN';
                }else{
                    $transaction_status='MAROON';
                }

                echo '<tr>';
                echo '<td>'.$row['transaction_no'].'</td>';
                echo '<td>'.$row['user_lastname'].', '.$row['user_firstname'].'</td>';
                echo '<td>'.$row['customer_lastname'].', '.$row['customer_firstname'].'</td>';
                echo '<td>'.($row['discounted_price']*100).'%</td>';
                echo '<td>&#8369;'.number_format($row['total_price'], 2, '.',',').'</td>';
                echo '<td>'.date('F d, Y', strtotime($row['transaction_date'])).'</td>';
                echo '<td style="font-style:italic;font-weight:bold;color:'.$transaction_status.'">'.$row['transaction_status'].'</td>';
                echo '<td><button type="button" data-toggle="modal" data-target="#transaction'.$row['transaction_no'].'" class="btn btn-sm btn-success">view</button></td>';

                echo '</tr>';

            ?>

            <div class="modal fade" <?php echo 'id="transaction'.$row['transaction_no'].'"'; ?> tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="register_user">transaction no: <?php echo $row['transaction_no']; ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">


                            <?php 

                $sql = 'SELECT * FROM invoice_rl join transaction_rl, product_tb WHERE transaction_rl.transaction_no = invoice_rl.transaction_no and product_tb.barcode=invoice_rl.barcode AND invoice_rl.transaction_no ="'.$row['transaction_no'].'"';

                $no_discount = 0;
                foreach($pdo->query($sql) as $product){

                    echo '<p>'.$product['product_name'].' x '.$product['quantity'].' = &#8369;'.number_format($product['total_product_price'],2,'.',',').'</p>';

                    $no_discount += $product['total_product_price'];

                }

                if($product['discount_code'] == 'NONE'){
                    echo '<p style="text-align:center">TOTAL PRICE: &#8369;'.number_format($product['total_price'],2,'.',',').'</p>';
                }else{

                    echo '<p style="text-align:center">TOTAL NO DISCOUNT PRICE: &#8369;'.number_format($no_discount,2,'.',',').'</p>';
                    echo '<p style="text-align:center">TOTAL '.($row['discounted_price']*100).'% DISCOUNTED PRICE: &#8369;'.number_format($product['total_price'],2,'.',',').'</p>';

                }



                            ?>




                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-sm form-control" data-dismiss="modal">CLOSE</button>

                        </div>
                    </div>
                </div>
            </div>

            <?php

            }

            ?>


        </tbody>


    </table>
</div>

<div class="modal fade" id="sales_count" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="register_user">SALES REPORT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">


                <?php 

                $sql = 'SELECT * FROM transaction_rl';
                $number_of_success = 0;
                $number_of_voided = 0;
                $total_transaction = 0;
                $networth=0;
                $tax=0;

                foreach($pdo->query($sql) as $row){
                    if($row['transaction_status'] == 'SUCCESS'){
                        $number_of_success++;
                        $networth += $row['total_price'];

                        $sql = 'SELECT * FROM invoice_rl join product_tb WHERE product_tb.barcode = invoice_rl.barcode AND transaction_no = "'.$row['transaction_no'].'" ';
                        foreach($pdo->query($sql) as $row1){
                            $tax+=$row1['tax'];
                        }

                    }else if($row['transaction_status'] == 'VOIDED'){
                        $number_of_voided++;
                    }

                    $total_transaction++;
                }




                echo '<label>SUCCESS COUNT:</label>';
                echo '<h1 style="color:green">'.$number_of_success.'</h1>';
                echo '<br>';
                echo '<label>VOID COUNT:</label>';
                echo '<h1 style="color:maroon">'.$number_of_voided.'</h1>';
                echo '<br>';
                echo '<label>TOTAL TRANSACTION:</label>';
                echo '<h1>'.$total_transaction.'</h1>';
                echo '<br>';
                echo '<label>TAX:</label>';
                echo '<h2>&#8369;'.number_format($tax,2,'.',',').'</h2>';
                echo '<br>';
                echo '<label>TOTAL INCOME (TAX Included):</label>';
                echo '<h1>&#8369;'.number_format($networth,2,'.',',').'</h1>';

                ?>




            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-sm form-control" data-dismiss="modal">CLOSE</button>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="today_sales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $hardware['hardware_name']; ?> - SALES REPORT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align:center">

                <h1>TODAY SALES</h1>
                <?php echo date('F d, Y'); ?>
                <div style="height:350px;overflow-y:scroll;margin-top:15px">
                    <table class="table">
                        <tr>
                            <th>Transaction#</th>
                            <th>Cashier</th>
                            <th>Customer</th>
                            <th>Total Price</th>   
                            <th>Status</th>
                        </tr>

                        <?php

                        $sql1 = 'SELECT * FROM transaction_rl join user_tb ,customer_tb WHERE user_tb.user_no=transaction_rl.user_no AND customer_tb.customer_no=transaction_rl.customer_no AND transaction_date = "'.date('Y-m-d').'" ORDER BY transaction_date DESC, transaction_no DESC';

                        $t_void_count = 0;
                        $t_success_count=0;
                        $t_total = 0;
                        $t_networth = 0;

                        foreach($pdo->query($sql1) as $today_row){

                            echo '<tr>';
                            echo '<td>'.$today_row['transaction_no'].'</td>';
                            echo '<td>'.$today_row['user_lastname'].', '.$today_row['user_firstname'].'</td>';
                            echo '<td>'.$today_row['customer_lastname'].', '.$today_row['customer_firstname'].'</td>';
                            echo '<td>&#8369;'.number_format($today_row['total_price'],2,'.',',').'</td>';
                            if($today_row['transaction_status'] == 'SUCCESS'){
                                $transaction_status='GREEN';
                            }else{
                                $transaction_status='MAROON';
                            }
                            echo '<td style="font-style:italic;font-weight:bold;color:'.$transaction_status.'">'.$today_row['transaction_status'].'</td>';

                            echo '</tr>';

                            if($today_row['transaction_status'] == 'SUCCESS'){
                                $t_success_count++;
                                $t_networth += $today_row['total_price'];


                            }else if($today_row['transaction_status'] == 'VOIDED'){
                                $t_void_count++;
                            }

                            $t_total++;


                        }


                        ?>


                    </table>
                </div>
                <div style="margin-top:15px">
                    <label>VOIDED: <?php echo $t_void_count; ?> | </label>
                    <label>SUCCESS: <?php echo $t_success_count; ?> | </label>
                    <label>TOTAL SALES: <?php echo $t_total; ?> | </label>
                    <label>TOTAL INCOME:&#8369;<?php echo number_format($t_networth,2,'.',','); ?></label>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary form-control" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>



