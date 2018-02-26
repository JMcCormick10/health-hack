<?php

    require_once '../redirect.php';

    //grab  user id, username
    $id = $userId->user_id;
    $list_id = $userId->list_id;

    //db
    require_once "../Models/Database.php";
    $dbConn = new Database();
    $db = $dbConn->getDbFromAWS();

    //include groceryList DAO
    require_once "../Models/GroceryListDAO.php";
    $gListConn = new GroceryListDAO();
    $gLists = $gListConn->populateGroceryLists($db);
    $userList = $gListConn->populateUserListId($db);
    //$updateUserListId = $gListConn->updateUserListId($db);

    //create an empty var for the grocery list options
    $grocery_list__options = "";
    $grocery_list__options_err = "";
    $grocery_list__options_success = "";
    $list_id = "";

    //once the user submits run the following code
    if(isset($_POST['grocery_list__submit'])) {


        $list_id = $_POST['grocery_lists'];

        //create a new grocery list class object and set the value
        require_once '../Models/GroceryList.php';

        $g_list = new GroceryList();
        $g_list->setListId($list_id);
        $g_list->setUserId($id);

        $gListConn->userSelectList($db, $g_list);

        //check for validation
        if(!isset($_POST['grocery_lists'])) {
            $grocery_list__options_err = "please choose a grocery list";
        }
        if(isset($_POST['grocery_lists'])) {
            $grocery_list__options_success = "Thank you for selecting a list";
        }
        header('Location: ../GroceryList');
    }

    //include the header
    require_once "../Common Views/Header.php";

    //include the sidebar
    require_once "../Common Views/sidebar.php";

?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
        <div class="col-md-5 ">
            <h1 class="light-grey padding-top-75">Grocery Lists</h1>
            <p>Please select a grocery list from the following options and press submit. This list will be your main outlining diet for your journey with us here at Health Hack.. </p>
        </div>
        <div class="feature col-md-10 col-sm-12 col-12">
            <form action="" method="post" id="grocery_list__options">
               <div id="grocery_list__options_err">
                   <span class="badge badge-danger"><?php echo $grocery_list__options_err; ?></span>
                   <span class="badge badge-success"><?php echo $grocery_list__options_success; ?></span>
               </div>

                <div class="row">
                    <?php
                    //loop through the products from the products table to create their own radio btns
                    foreach($gLists as $gL) {
                        ?><div class="grocery_lists col-md-4 col-sm-6 col-12 row">
                            <p class="grocery_list__titles col-md-12"><?php echo $gL->list_name; ?></p>
                            <div class="grocery_list__details col-md-12">
                                <p><?php echo $gL->list_details; ?></p>
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-primary">
                                        <input type="radio" name="grocery_lists" value="<?php echo $gL->list_id; ?>" required>Select List
                                    </label>
                                </div>
                            </div>
                        </div><?php
                    }
                    ?>
                </div>
                <div id="grocery_list__submission">
                    <input type="submit" id="" name="grocery_list__submit" value="Submit List" class="formSubmit">
                </div>
            </form>
        </div>
        <div class="row col-12">
            <a href="index.php" class="btn btn-info btn-lg offset-md-1">
                <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
            </a>
        </div>
    </div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>