<!DOCTYPE html>
<html lang="fr">
<body class="bg-light">
    <?php echo view('sidebar.php');
  date_default_timezone_set("africa/Bujumbura");
  ?>
<main id="main" class="main">
    <div class="container-fluid py-4">

        <!-- Filtres colorés -->
        <div class="row mb-4 g-2">
            <div class="col">
                <div class="btn-group w-100" role="group">
                    <button class="btn btn-primary text-white fw-bold py-3">
                        <i class="bi bi-fire fs-4 me-2"></i>FAVORIS
                    </button>
                    <button class="btn btn-primary fw-bold py-3">
                        <i class="bi bi-cup-fill fs-4 me-2"></i>PRESSION
                    </button>
                    <button class="btn btn-primary text-white fw-bold py-3">
                        <i class="bi bi-trophy-fill fs-4 me-2"></i>BOUTEILLES
                    </button>
                    <button class="btn btn-primary fw-bold py-3">
                        <i class="bi bi-cup-straw fs-4 me-2"></i>SOFTS
                    </button>
                </div>
            </div>
        </div>

        <!-- Grille des produits -->
        <div class="row g-3 mb-4" style="max-height: 500px; overflow-y: auto;">
            <?php echo $produits; ?>
        </div>

        <!-- Panier -->
        <div class="row">
            <input type="hidden" id="cartData" value="">
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4 bg-light">
                    <div class="card-body p-4">
                        <div class="row align-items-center mb-3">
                            <div class="col">
                                <h4 class="mb-0">
                                    <i class="bi bi-basket3-fill text-dark me-2"></i>
                                    Panier
                                </h4>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-warning btn-sm rounded-pill">
                                    <i class="bi bi-trash3 me-2"></i>Vider
                                </button>
                            </div>
                        </div>

                        <!-- Liste des articles -->
                        <div class="bg-dark bg-opacity-10 rounded-4 p-3 mb-3" id="cartItems">
                            <p class="text-center">Votre panier est vide</p>
                        </div>

                        <!-- Total et validation -->
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">TOTAL</h3>
                            </div>
                            <div class="col-auto">
                                <h2 class="text-warning fw-bold mb-0" id="total">0,00 BIF</h2>
                            </div>
                        </div>

                        <hr class="bg-white bg-opacity-25 my-3">

                        <div class="row g-2 w-100" style="float: right;">
                            <div class="col-3">
                                <button class="btn btn-outline-danger w-100 py-3 rounded-pill">
                                    <i class="bi bi-x-lg me-2"></i>Annuler
                                </button>
                            </div>
                            <div class="col-3">
                                <button class="btn btn-success w-100 py-3 rounded-pill fw-bold" onclick="save_commande()">
                                    <i class="bi bi-check-lg me-2"></i>VALIDER
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Bootstrap JS (optionnel, pour les interactions) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Style supplémentaire minimal -->
<style>
    .hover-scale {
        transition: all 0.2s;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,.15) !important;
    }
    .bg-purple {
        background-color: purple;
    }
</style>
</body>
</html>

<script>
    function addToCart(idProduit, puVente, descProduit, qteStock)
    {
        if($('#cartData').val()!=""){ 
            if($('#cartData').val().includes(`"idProduit":${idProduit}`)){
                //modifier la quantité si le produit existe déjà dans le panier
                let cart = JSON.parse($('#cartData').val());
                cart = cart.map(item => {
                    if(item.idProduit === idProduit){
                        if(item.qte + 1 > qteStock){
                            alert("Quantité en stock insuffisante !");
                            return item;
                        }
                        return { idProduit, qte: item.qte + 1, puVente, descProduit, qteStock };
                    }
                    return item;
                });
                $('#cartData').val(JSON.stringify(cart));
            }
            else{
                let cart = JSON.parse($('#cartData').val());
                cart.push({ idProduit, qte: 1, puVente, descProduit, qteStock });
                $('#cartData').val(JSON.stringify(cart));
            }
        } else {

            if(qteStock <= 0){
                alert("Produit en rupture de stock !");
                return;
            }
        
            $('#cartData').val(JSON.stringify([{ idProduit, qte: 1, puVente, descProduit, qteStock }]));
        }
        getListCart();    
    }

    function getListCart()
    {
        let cart = $('#cartData').val()!="" ? JSON.parse($('#cartData').val()) : [];
        console.log(cart);
        let html='';
        let total=0;
        if(cart.length === 0){
            $('#cartItems').html('<p class="text-center">Votre panier est vide</p>');
            $('#total').text('0 BIF');
            return;
        }
        else
        {
            cart.forEach(item => {
            total=total+(item.qte * item.puVente);
            html += `<div class="row align-items-center mb-2">
                <div class="col">
                    <span class="fw-bold">${item.descProduit}</span>
                    <span class="text-warning ms-2">x${item.qte}</span>
                </div>
                <div class="col-auto">
                    <span class="fw-bold">${(item.qte * item.puVente).toLocaleString('fr-FR')} BIF</span>
                </div>
                <div class="col-auto">
                    <button class="btn btn-link text-danger p-0 ms-2" onclick="removeFromCart(${item.idProduit})">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </div>
            </div>`
            });
            $('#cartItems').html(html);
            $('#total').text(total.toLocaleString('fr-FR') + ' BIF');
        }
    }

    function removeFromCart(idProduit)
    {
        let cart = JSON.parse($('#cartData').val());
        cart = cart.map(item => {
            if(item.idProduit === idProduit){
                if(item.qte - 1 <= 0){
                    return null; // Supprimer l'article du panier si la quantité atteint 0
                }
                else
                {
                    return { idProduit, qte: item.qte - 1, puVente: item.puVente, descProduit: item.descProduit, qteStock: item.qteStock };
                }                
            }
            return item;
        });
        cart = cart.filter(item => item !== null); // Supprimer les articles marqués pour suppression
        $('#cartData').val(JSON.stringify(cart));
        getListCart();
    }

    function save_commande()
    {
        let cart = $('#cartData').val()!="" ? JSON.parse($('#cartData').val()) : [];
        if(cart.length === 0){
            alert("Votre panier est vide !");
            return;
        }
        cart=JSON.stringify(cart);
        $.ajax({
            url: '/ventes/save_commande',
            method: 'POST',
            data: { cart },
            datatype: 'json',
            success: function(response){
                alert("Commande enregistrée avec succès !");
                $('#cartData').val("");
                window.location.reload();
            },
            error: function(){
                alert("Une erreur est survenue lors de l'enregistrement de la commande.");
            }
        });
    }

</script>