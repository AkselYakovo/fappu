<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Compra Tus Cuentas Porno A Un Increible Precio!">
    <script src="./js/form.js" defer="defer"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Reclamar Servicio  ||  Cuentas Fapu</title>
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

    <?php if ( isset($_GET) && !isset($_GET['show_completion_dialog']) ): ?>

        <div class="alert">
            <img src="./css/svg/alert_ico.svg" alt="alert icon" class="alert__ico" draggable="false">
            <span class="alert__title">ATENCI&Oacute;N:</span>
            <p class="alert__text">Si nos haz contactado en los &uacute;ltimos 7 d&iacute;as, evita volver a hacerlo.
        </div>
    
    <?php elseif ( $_GET['show_completion_dialog'] ): ?>

        <div class="alert alert--error">
            <img src="./css/svg/alert_ico_alt.svg" alt="alert icon" class="alert__ico" draggable="false">
            <span class="alert__title">ATENCI&Oacute;N:</span>
            <p class="alert__text">Ten paciencia, podemos tardar hasta tres d&iacute;as h&aacute;biles para responder a tu reclamo.
        </div>
    
    <?php endif; ?>

    <section class="document-card">
        <h2 class="document__heading">RECLAMAR SERVICIO</h2>
        <form action="" method="POST" autocomplete="off">

            <span class="row">
                <label for="id__order">ORDER ID:</label>
                <input type="text" name="order__id" class="form-input" id="id__order" placeholder="ID ORDER" autofocus>
            </span>

            <span class="row">
                <label for="email">EMAIL ADDRESS:</label>
                <input type="email" name="user__email" class="form-input" id="email" placeholder="EMAIL ADDRESS">
            </span>
            
            <span class="row row-single check_statement">
                <input type="checkbox" name="email__agreement" id="email__option">
                <span class="checkbox-figure checkbox-figure--checked"></span>
                <label for="email__option" style="max-width: initial;">NO HE ENVIADO UN CORREO EN LOS &Uacute;LTIMOS 7 D&Iacute;AS.</label>
            </span>
            
            <button id="send" class="button md">ENVIAR</button>
            
            <input type="hidden" name="XAX" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>">

        </form>
        
    </section>

    <!-- Footer Begins.. -->
    <?php require_once('./footer.php'); ?>
    <!-- Footer Ends.. -->
</body>
</html>