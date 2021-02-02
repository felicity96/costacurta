<?php $contatti = get_contacts(); ?>

<footer class="bg-color page">

    <div class="row py-4 justify-content-around">
        <div class="col-lg-4">
            <a href="../public/index.php" class="d-inline-block">
                <img src="../public/images/logo2.svg" alt="logo" class="d-inline-block align-top logo-footer pb-5">
            </a>
        </div>
        <div class="col-lg-3">
            <p class="footer-title pb-3 footer-border">Contatti</p>
            <div class="py-4">
                <i class="fas fa-at"></i><p class="d-inline-block pl-4 mb-0"><?php echo $contatti[0]['cont_value']; ?></p>
            </div>
            <div>
                <i class="fas fa-phone"></i><p class="d-inline-block pl-4 mb-0"><?php echo $contatti[1]['cont_value']; ?></p>
            </div>
        </div>
        <div class="col-lg-4">
            <p class="footer-title pb-3 footer-border">Gli studi</p>
            <?php footer_study(); ?>
        </div>
    </div>
    <p class="privacy text-center pt-3 d-flex align-items-center justify-content-center"><a href="../public/index.php">www.andreacostacurta.it</a> © 2021 - P.IVA 03207300249 - <a href="https://www.iubenda.com/privacy-policy/56078482" class="iubenda-white iubenda-embed" title="Privacy Policy ">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src="https://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script></p>
    <div>
        <a role="button" class="login-btn" href="../public/index.php?login">Login</a>
    </div>
</footer>