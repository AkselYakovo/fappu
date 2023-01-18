<?php
require'./fun.php';
// ~ CREATE, READ, UPLOAD & DELETE FOR FAPPU LANDING PAGE ~

// CREATE: New Reclaim..
if ( isset($_POST['__PUT']) && isset($_POST['__RECLAIM']) && isset($_POST['__ID']) ) {
    $sale_id = strtoupper(clean_txt($_POST['__ID']));
    $email = strtolower(clean_txt($_POST['__EMAIL']));

    $record_exists = false;
    $reclaim_exists = false;
    $is_not_recent = false;
    
    // Check If Sale Data Exists..
    $exists = $main_conn->query("SELECT * 
                                 FROM _SALES
                                 WHERE `USER_EMAIL` = '$email' AND `SALE_ID` = '$sale_id'");
    
    if ( $exists && $exists->fetch_row()[0] ) {
        $record_exists = true;
    }

    if ( $record_exists ) {
        $exists_reclaim_query = "SELECT COUNT(*) FROM _RECLAIMS WHERE `USER_EMAIL` = '$email' AND `ORDER_ID` = '$sale_id'";
        $exists_reclaim = $main_conn->query($exists_reclaim_query);

        if ( $exists_reclaim && $exists_reclaim->fetch_row()[0] ) {
            $reclaim_exists = true;
        }

        if ( $reclaim_exists ) {
            $today = date('Y-m-d');

            $diff_date_query = "SELECT `DATE` FROM _RECLAIMS WHERE `ORDER_ID` = '$sale_id' ORDER BY `DATE` DESC LIMIT 1";
            $results = $main_conn->query($diff_date_query);
            $results = $results->fetch_array();

            $last_reclaim_date = new DateTime($results[0]);
            $today_date = new DateTime($today);

            $diff = date_diff($today_date , $last_reclaim_date);
            if ( $diff && $diff->format('%d') > 3 ) {
                $is_not_recent = true;
            }
            else {
                echo "too soon";
            }
        }

        elseif ( !$reclaim_exists ) {
            $new_reclaim_id = getReclaimID();
            $info = $main_conn->query(" SELECT * FROM _SALES WHERE `SALE_ID` = '$sale_id'");
            $info = $info->fetch_array();
            $account_id = $info['ACCOUNT_ID'];
            $date = date('Y-m-d');
            $new_reclaim_query = "INSERT INTO _RECLAIMS VALUES ('$new_reclaim_id', '$email', '$account_id', '$sale_id', '$date', 0)";
            $new_reclaim = $main_conn->query($new_reclaim_query);

            // if ($new_reclaim)
                // echo 'exito';
            // else 
                // print_r($new_reclaim);
        }

        if ( $is_not_recent ) {
            $new_reclaim_id = getReclaimID();
            $info = $main_conn->query("SELECT * FROM _SALES WHERE `SALE_ID` = '$sale_id'");
            $info = $info->fetch_array();
            $sitecode = $info['SITE_CODE'];
            $account_id = $info['ACCOUNT_ID'];
            $date = date('Y-m-d');
            $new_reclaim_query = "INSERT INTO _RECLAIMS VALUES ('$new_reclaim_id', '$email', '$account_id', '$sale_id', '$date', 0)";
            $new_reclaim = $main_conn->query($new_reclaim_query);

            // if ($new_reclaim)
                // echo 'exito MAN';
            // else 
                // print_r($new_reclaim);
        }
    }
}

// CREATE: New Message..
if ( isset($_POST['__PUT']) && isset($_POST['__MESSAGE']) ) {
    $message = clean_txt($_POST['__MSG']);
    $email = strtolower(clean_txt($_POST['__EMAIL']));
    $cat = strtoupper(clean_txt($_POST['__CAT']));
    $today = date('Y-m-d');
    
    // flags..
    $sale_exists = false;
    $on_diff_day = false;

    if( !in_array($cat, __CATEGORIES__) ) {
        die();
        // throw new Exception("Category Isn't Correct.", 1);
    }

    // Check If Sale Data Exists..
    $exists = $main_conn->query("SELECT * 
                                 FROM _SALES
                                 WHERE `USER_EMAIL` = '$email'");
    
    if ( $exists && $exists->fetch_row()[0] ) 
    {
        $sale_exists = true;
    }

    $results = $main_conn->query(" SELECT * FROM _MESSAGES 
                                   WHERE `USER_EMAIL` = '$email' AND `DATE` = '$today' ");

    if ( !$results->fetch_row() ) {
        $on_diff_day = true;
    }

    echo "SALE: $sale_exists \n DIFFDAY: $on_diff_day \n";

    print_r($results);


    if ( $sale_exists && $on_diff_day ) {
        $new_message_query = "INSERT INTO _MESSAGES 
                              VALUES(NULL, '$today', '$email', '$message', '$cat')";
    
        $main_conn->query($new_message_query);
    }
    
}


// CREATE: New User Teased..
if ( isset($_POST['__USER_QUEUE']) && isset($_POST['__FOR_WEBSITE']) && isset($_POST['__EMAIL']) ) {
    echo "Info received!";
}




// READ: Query Websites Offered..
if ( isset($_POST['__PULL']) && isset($_POST['__CARD']) && isset($_POST['__QUERY']) ) {
    $q = strtoupper(clean_txt($_POST['__QUERY']));
    
    $new_query = "SELECT W.`SITE_CODE` AS `SITE_CODE`, W.`SITE_TITLE` AS `SITE_TITLE`, W.`SITE_URL` AS `SITE_URL`,
                  W.`ORIGINAL_PRICE` AS `ORIGINAL_PRICE`, W.`OFFER_PRICE` AS `OFFER_PRICE`,
                  CHILD.`CHILDREN` AS `CHILDREN`
                  FROM _WEBSITES W
                  INNER JOIN _WEBSITES_CHILDREN CHILD
                  ON W.`SITE_CODE` = CHILD.`SITE_CODE`
                  WHERE W.`SITE_CODE` LIKE '%$q%'";

    $result = $main_conn->query($new_query);
    $internal_index = $result->num_rows;
    if ($result) 
        $result = $result->fetch_all(MYSQLI_ASSOC);
    else
        $result = array(0 => 'false');
    
    echo json_encode($result);
}


?>