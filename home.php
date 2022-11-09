<div class="row">
    <div class="col-sm-12" style="padding:10px">
        <div class="col-sm-12" style="background-color:rgba(0,0,0,0.7);height:45px;color:white;padding:5px 25px 5px 25px">
            <p style="font-size:24px;float:left"><?php echo $hardware['hardware_name']; ?></p>
            <p  id="p_date" style="font-size:24px;float:right"></p>
        </div>


        <div class="col-sm-12 admin_panel" style="background-color:rgba(0,0,0,0.7);height:120px;padding:15px 30px 15px 15px;margin-top:5px">
            <div class="row">
                <div class="col-sm-1">
                    <button type="button" data-toggle="modal" data-target="#settings">
                        <img src="res/admin1.png" style="width:90px;height:90px">
                    </button>
                </div>

                <div class="col-sm-2" style="color:white">
                    <?php echo $user['user_lastname'].', '.$user['user_firstname']; ?><br>
                    <?php echo $user['access_type']; ?><br>
                    <?php echo 'TAX Rate: '.($hardware['tax_rate']*100).'%'; ?>
                </div>

                <div class="offset-sm-2 col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <button id="btn_accounts" type="button" class="btn_admin btn btn-link">
                        <img src="res/staff.png" style="width:50px;height:50px"><br>
                        Accounts
                    </button>
                </div>

                <div class="col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <button id="btn_transaction"type="button" class="btn_admin btn btn-link">
                        <img src="res/sales.png" style="width:50px;height:50px"><br>
                        Transactions
                    </button>
                </div>

                <div class="col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <button id="btn_products" type="button" class="btn_admin btn btn-link">
                        <img src="res/inventory.png" style="width:50px;height:50px"><br>
                        Products
                    </button>
                </div>

                <div class="col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <button id="btn_customers" type="button" class="btn_admin btn btn-link">
                        <img src="res/log.png" style="width:50px;height:50px"><br>
                        Customer
                    </button>
                </div>

                <div class="col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <button id="btn_discount" type="button" class="btn_admin btn btn-link">
                        <img src="res/transactions.png" style="width:50px;height:50px"><br>
                        Discount
                    </button>
                </div>

                <div class="col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <button id="btn_pos" type="button" class="btn_admin btn btn-link">
                        <img src="res/pos.png" style="width:50px;height:50px"><br>
                        Open POS
                    </button>
                </div>

                <div class="col-sm-1" style="background-color:rgba(255,255,255,0.6);text-align:center">
                    <form method="post">
                        <button type="submit" name="logout_btn" class="btn_admin btn btn-link">
                            <img src="res/logout.png" style="width:50px;height:50px"><br>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>


        </div>

        <div class="col-sm-12 admin_panel" style="background-color:rgba(0,0,0,0.7);margin-top:5px;height:75vh;padding:15px">

            <div id="accounts_div">
                <?php require 'accounts.php'; ?>
            </div>

            <div id="transaction_div">
                <?php require 'transactions.php'; ?>
            </div>

            <div id="products_div">
                <?php require 'products.php'; ?>
            </div>

            <div id="discount_div">
                <?php require 'discount.php'; ?>
            </div>

            <div id="customers_div">
                <?php require 'customers.php'; ?>
            </div>



        </div>

        <div id="pos_div">
            <?php require 'pos.php'; ?>
        </div>
    </div>
</div>

<?php if($user['user_no'] == 'USER0000001'){ ?>

<form method="post">
    <div class="modal fade" id="settings" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="register_user">GENERAL SETTINGS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                
                    <label>TAX RATE PERCENTAGE: (1-100 only)</label>
                    <input type="number" min="0" max="100" class="form-control user_form" name="edit_tax_rate" step="1" value="<?php echo $hardware['tax_rate']*100; ?>">
                    


                </div>
                <div class="modal-footer">

                    <button type="reset" class="btn">RESET</button>
                    <button type="submit" name="settings" class="btn btn-success">EDIT</button>


                </div>
            </div>
        </div>
    </div>
</form>

<?php } ?>



