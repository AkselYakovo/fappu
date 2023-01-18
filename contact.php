<?php 
// include_once('./fun.php');
// echo array_search('RECLAIMS', __CATEGORIES__);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="description" content="Contacto"> -->
    <!-- <meta name="keywords" content="Contacto"> -->
    <script src="./js/contacto.js" defer="defer" type="module"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Contacto  ||  Cuentas Fapu</title>
</head>
<body>
    <header class="header header--subtitleless">
            <h1 class="header__title">CUENTAS FAPU</h1>
            <div class="header__separator">
                <figure class="dot"></figure>
                <figure class="dot"></figure>
                <figure class="dot"></figure>
            </div>
            <h2 class="header__subtitle">
                <span class="emphazised">FAPU</span> ¡TE GARANTIZA UN MES<span class="emphazised">*</span> DE STREAMING DE TUS SITIOS PARA ADULTOS FAVORITOS!
            </h2>
            <div class="header__shadow"></div>
            <small class="header__terms">
                *LEER T&Eacute;RMINOS Y CONDICIONES.
            </small>
    </header>

    <?php if ( isset($_GET['message-received-confirmation']) ): ?>
    
    <div class="alert message-received-alert">
        <span class="alert__title">ATENCIÓN:</span>
        <p class="alert__text">
            <?php echo htmlentities("Nos pondremos en contacto contigo dentro de 1 - 3 días hábiles."); ?>
        </p>
    </div>

    <?php endif ?>

    <section class="document-card">
        <h2 class="document__heading">CONTACTO</h2>
        <form method="POST" autocomplete="off" enctype="www-application">
            <span class="row">
                <label for="cat">TOPIC:</label>
                <div class="form-selection-wrapper">
                    <input type="text" name="email__category" class="form-input" id="cat" value="" placeholder="SELECT TOPIC" data-display="" readonly>
                    <ul class="option-list" role="selection">
                        <li class="option" data-display="ACCOUNT">CUENTA</li>
                        <li class="option" data-display="RECLAIMS">RECLAMOS</li>
                        <li class="option" data-display="OTHER">OTROS</li>
                    </ul>

                    <svg class="arrow" width="23" height="12" viewBox="0 0 23 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.8091 11.3398C11.1957 11.7092 11.8043 11.7092 12.1909 11.3398L22.2544 1.72297C22.9064 1.09987 22.4654 0 21.5635 0H1.43651C0.53462 0 0.0935912 1.09987 0.745629 1.72297L10.8091 11.3398Z" fill="#646464"/>
                    </svg>

                </div>
            </span>
            <span class="row">
                <label for="email">EMAIL ADDRESS:</label>
                <input type="email" name="user__email" class="form-input" id="email" placeholder="EMAIL ADDRESS">
            </span>
            <span class="row">
                <label for="msg">MESSAGE:</label>
                <textarea name="user__msg" id="msg" placeholder="Your message here..." max="140"></textarea>
            </span>
            
            <button type="submit" class="button md">ENVIAR</button>

            <input type="hidden" name="user__info" value="<?php echo $_SERVER['SERVER_ADDR'] ?>">
        </form>
        
    </section>

    <!-- Footer Begins.. -->
    <?php require_once('./footer.php'); ?>
    <!-- Footer Ends.. -->
</body>
</html>