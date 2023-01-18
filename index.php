<?php
require_once("./fun.php");
$main_conn = new mysqli('localhost', 'root', '', 'test');

$websites_listing_query = "SELECT `w`.`SITE_CODE` AS `SITE_CODE`, `w`.`SITE_TITLE` AS `SITE_TITLE`,
                           `w`.`SITE_URL` AS `SITE_URL`, `w`.`ORIGINAL_PRICE` AS `ORIGINAL_PRICE`,
                           `w`.`OFFER_PRICE` AS `OFFER_PRICE`, 
                           CHILD.`CHILDREN` AS `CHILDREN`,
                           `AVAILABLE`.`IS_AVAILABLE`
                           FROM `_WEBSITES` AS `w`
                           INNER JOIN `_WEBSITES_CHILDREN` AS `CHILD`
                           ON `w`.`SITE_CODE` = `CHILD`.`SITE_CODE`
                           LEFT OUTER JOIN ( SELECT `SITE_CODE`,

                                        CASE
                                            WHEN COUNT(*) IS NULL THEN 0
                                            WHEN COUNT(*) IS NOT NULL THEN 1
                                        END AS `IS_AVAILABLE`

                                        FROM `_ACCOUNTS`
                                        WHERE `N_SOLD` < `N_AVAILABLE` AND 
                                        `ACCESS_STATE` = 1
                                        GROUP BY `SITE_CODE`) AS `AVAILABLE`

                           ON `w`.`SITE_CODE` = `AVAILABLE`.`SITE_CODE`
                           LIMIT 1";

$websites_listing = $main_conn->query($websites_listing_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Buy premium porn accounts!">
    <script src="./js/carrousel.js" defer="defer" type="module"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Fappu | Premium Adult Streaming Accounts</title>
</head>
<body>
    <header class="header">
        <h1 class="header__title">FAPPU ACCOUNTS</h1>
        <div class="header__separator">
            <figure class="dot"></figure>
            <figure class="dot"></figure>
            <figure class="dot"></figure>
        </div>
        <h2 class="header__subtitle">
            <span class="emphazised">FAPPU</span> GUARANTEES A MONTH<span class="emphazised">*</span> OF STREAMING IN YOUR FAVORITE STREAMING WEBSITES!
        </h2>
        <div class="header__shadow"></div>
        <small class="header__terms">
            *READ TERMS OF SERVICE.
        </small>
    </header>

    
    <div class="toolbar__search" >
        <input type="text" name="query" class="toolbar__input" placeholder="SEARCH YOUR FAVORITE WEBSITE!">
        <figure class="toolbar__icon">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.283 10.809H11.5067L11.2316 10.5437C12.1945 9.4235 12.7743 7.9692 12.7743 6.38715C12.7743 2.85948 9.91482 0 6.38715 0C2.85948 0 0 2.85948 0 6.38715C0 9.91482 2.85948 12.7743 6.38715 12.7743C7.9692 12.7743 9.4235 12.1945 10.5437 11.2316L10.809 11.5067V12.283L15.7222 17.1863L17.1863 15.7222L12.283 10.809ZM6.38715 10.809C3.94038 10.809 1.96528 8.83392 1.96528 6.38715C1.96528 3.94038 3.94038 1.96528 6.38715 1.96528C8.83392 1.96528 10.809 3.94038 10.809 6.38715C10.809 8.83392 8.83392 10.809 6.38715 10.809Z"/>
            </svg>  
        </figure>
    </div>
    
    <main class="content">

    <?php foreach($websites_listing as $website): ?>
    
    <?php if ( $website['IS_AVAILABLE'] ): ?>

    <div class="card" data-display="<?php echo $website['SITE_TITLE'] ?>">
        
    <?php elseif ( !$website['IS_AVAILABLE']): ?>

    <div class="card card--unavailable" data-display="<?php echo $website['SITE_TITLE'] ?>">

    <?php endif ?>

        <div class="card__carrousel">
            <div class="carrousel__pictures">
                <?php for($i = 1; $i <= 3; $i++): ?>
                <figure>
                    <img src="<?php echo "../fappu_admin/assets/thumbs/" . strtolower($website['SITE_CODE']) . "/blur/" . $website['SITE_TITLE'] . "_$i.jpg"; ?>" 
                    alt="<?php echo $website['SITE_TITLE'] . " Promotional Picture #$i" ?>" 
                    data-display="<?php echo "../fappu_admin/assets/thumbs/" . strtolower($website['SITE_CODE']) . "/" . $website['SITE_TITLE'] . "_$i.jpg"; ?>">
                </figure>
                <?php endfor; ?>
            </div>
            <div class="carrousel__controls">
                <figure class="carrousel__control carrousel__control--active" data-display="1"></figure>
                <figure class="carrousel__control" data-display="2"></figure>
                <figure class="carrousel__control" data-display="3"></figure>
            </div>
        </div>

        <div class="card__content"> 
            <header class="content__header">
                <h2 class="content__sitecode"><?php echo $website['SITE_CODE']; ?></h2>
                <span class="content__link"><?php echo $website['SITE_URL']; ?></span>
            </header>
            <div class="content__price">
                <h3 class="content__subtitle">ORIGINAL_PRICE:</h3>
                <span class="content__montlyprice">$<?php echo $website['ORIGINAL_PRICE']; ?>.00 MXN/MONTH</span>
            </div>
            <div class="content__price content__price--emphazised">
                <h3 class="content__subtitle">OUR PRICE:</h3>
                <span class="content__montlyprice">$<?php echo $website['OFFER_PRICE']; ?>.00 MXN/MONTH</span>
            </div>

            <?php if ( $website['IS_AVAILABLE'] ): ?>

            <button class="content__buybutton" type="button">BUY</button>
            
            <?php elseif ( !$website['IS_AVAILABLE']): ?>
                
            <button class="content__buybutton disabled" type="button">BUY</button>

            <?php endif ?>


            <div class="content__slidders">
                <figure class="content__slidder content__slidder--active"></figure>
                <figure class="content__slidder"></figure>
            </div>
        </div>
        
        <div class="card__subsites">
            <small class="subsites__subtitle">SUBSITES INCLUDED:</small>

            <div class="subsites__screens">

            <?php $screens = getScreensCollection($main_conn, $website['SITE_CODE']);  ?>
            
            <?php foreach($screens as $screen): ?>

                <figure class="subsites__screen" id="testy">
                    <img class="screen__picture" src="<?php echo "../fappu_admin/assets/screens/" . $website['SITE_CODE'] . "/blur/$screen.jpg"; ?>" alt="<?php echo $screen; ?> Included Website Picture"
                    data-display="<?php echo "../fappu_admin/assets/screens/" . $website['SITE_CODE'] . "/$screen.jpg"; ?>" draggable="false">
                    <figure class="subsite__logo">
                        <img src="<?php echo "../fappu_admin/assets/subsites_logos/" . $website['SITE_CODE'] . "/blur/$screen.png"; ?>" alt="<?php echo "$screen LOGO"; ?>"
                        data-display="<?php echo "../fappu_admin/assets/subsites_logos/" . $website['SITE_CODE'] . "/$screen.png"; ?>" draggable="false">
                    </figure>
                </figure>

            <?php endforeach ?>

            <?php            ?>

            </div>
        </div>
        <figure class="card__status"></figure>
    </div>

    <?php endforeach ?>

    </main>

    <div class="card__loader hidden">LOADING...</div>
    
    <div id="modal" class="modal" style="background-image: url('');">
        <div class="modal__content">
            <h4 class="content__heading">DO YOU WANT YOUR XXX?</h4>
            <p class="content__note">
                LEAVE US YOUR E-MAIL &amp; WE'LL CONTACT YOU WHEN &apos;<span class="website">PLACEHOLDER</span>&apos; IS AVAILABLE AGAIN!
            </p>
            <form method="post" autocomplete="off">
                <input class="white-input" type="text" name="user_email" placeholder="AWESOME_USER@MAIL.COM">
                <button type="submit" class="white md">SEND</button>
            </form>
        </div>
    </div>
    <div id="modal-overlay" class="modal--inactive"></div>

    <?php require_once('./footer.php'); ?>

</body>
</html>