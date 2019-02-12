<div class="container generalDisplay shadow-lg p-3bg-white mt-3 mb-3 rounded text-center">
    <h1 class="title">Bienvenue sur le site de JCP Pellets !</h1>
    <p class="homeDisplay">Ici nous vous proposons une gamme de produits basée sur une énergie renouvelable naturelle. En effet nous vous présentons des pellets 100% naturels et 100% bois ne contenant aucun additif chimique.</p>
    <p>Du compost, en passant par les litières pour animaux, jusqu'aux sacs de petit bois de chauffage, notre choix varié répondra parfaitement à vos besoins.</p>
    <p>N'attendez plus ! Découvrez dès maintenant nos produits en cliquant sur 'Produits' dans la barre située en haut de votre écran, ou appuyez directement sur le bouton ci-dessous !</p>
    <a href="views/products.php" class="btn btn-primary buttonProducts btn-lg" tabindex="-1" role="button" aria-disabled="true">Tous nos produits</a>
    <?php
    if(isset($success) && COUNT($success) > 0){
        foreach ($success as $isOk){
            ?>
            <div class="toast toastRegister" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                <div class="toast-header success">
                    <img src="../assets/img/logoJCP.png" class="logoToast rounded mr-2" alt="logo JCP">
                    <strong class="mr-auto">Succès !</strong>
                </div>
                <div class="toast-body success">
                    <?= $isOk; ?>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>