<?php
require_once("./fun.php");

$website = ( isset($_GET['W']) AND $_GET['W'] != '') ? $_GET['W'] : 'false';
$website = clean_txt($website);

$website_info_query = "SELECT * FROM _WEBSITES WHERE `SITE_CODE` = '$website'";
$results = $main_conn->query($website_info_query);
$website_info = $results->fetch_assoc();
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlentities("PREPARANDO COMPRA: <<$website>>") ?>
    </title>
    <?php
        if ( $website_info ) {
            // $website_info = $results->fetch_assoc();
            print_r($website_info);
        }

        else {
            echo '
                <script type="text/javascript">
                    window.close();
                    setTimeout( function() {
                        // location = history.back();
                        history.back();
                    }, 1250 );
                </script>';
        } ?>
</head>
<body>
    <!-- Body -->
</body>
</html>