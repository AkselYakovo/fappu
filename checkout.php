<?php
require_once("./fun.php");

$website = ( isset($_GET['W']) AND $_GET['W'] != '') ? $_GET['W'] : 'false';
$website = clean_txt($website);

$website_info_query = "SELECT * FROM _WEBSITES WHERE `SITE_CODE` = '$website'";
$results = $main_conn->query($website_info_query);
$website_info;
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
        if ( $website_info != NULL ) {
            $website_info = $results->fetch_assoc();
        }

        else {
            echo '
                <script type="text/javascript">
                    window.close();
                    setTimeout( function() {
                        location = "https://www.example.com";
                    }, 1250 );
                </script>';
        } ?>
</head>
<body>
    <?php echo $website_info['SITE_CODE'] ?>
</body>
</html>