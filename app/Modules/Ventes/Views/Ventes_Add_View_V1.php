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
            <!-- Grimbergen -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card h-auto border-0 shadow-sm rounded-4 hover-scale" style="cursor: pointer; transition: all 0.2s;" onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 1rem 2rem rgba(0,0,0,.15)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2">GRIMBERGEN</h6>
                        <h4 class="text-warning fw-bold mb-2">3,80 €</h4>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i>24 en stock
                        </span>
                    </div>
                </div>
            </div>

            <!-- Leffe -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card h-auto border-0 shadow-sm rounded-4 hover-scale" style="cursor: pointer;">
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2">LEFFE</h6>
                        <h4 class="text-danger fw-bold mb-2">4,00 €</h4>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i>18 en stock
                        </span>
                    </div>
                </div>
            </div>

            <!-- Jupiler -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card border-0 shadow-sm rounded-4 hover-scale" style="cursor: pointer;">
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2">JUPILER</h6>
                        <h4 class="text-primary fw-bold mb-2">2,80 €</h4>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i>42 en stock
                        </span>
                    </div>
                </div>
            </div>

            <!-- Picon -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card border-0 shadow-sm rounded-4 hover-scale" style="cursor: pointer;">
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2">PICON BIÈRE</h6>
                        <h4 class="text-info fw-bold mb-2">4,50 €</h4>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i>12 en stock
                        </span>
                    </div>
                </div>
            </div>

            <!-- Chimay -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card border-0 shadow-sm rounded-4 hover-scale" style="cursor: pointer;">
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2">CHIMAY BLEUE</h6>
                        <h4 class="fw-bold mb-2" style="color: purple;">5,50 €</h4>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>3 en stock
                        </span>
                    </div>
                </div>
            </div>

            <!-- Vedett -->
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card border-0 shadow-sm rounded-4 hover-scale" style="cursor: pointer;">
                    <div class="card-body text-center p-3">
                        <h6 class="fw-bold mb-2">VEDETT</h6>
                        <h4 class="text-success fw-bold mb-2">4,50 €</h4>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>5 en stock
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panier -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-4 bg-dark text-white">
                    <div class="card-body p-4">
                        <div class="row align-items-center mb-3">
                            <div class="col">
                                <h4 class="mb-0">
                                    <i class="bi bi-basket3-fill text-warning me-2"></i>
                                    Panier - TABLE 4
                                </h4>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-outline-light btn-sm rounded-pill">
                                    <i class="bi bi-trash3 me-2"></i>Vider
                                </button>
                            </div>
                        </div>

                        <!-- Liste des articles -->
                        <div class="bg-white bg-opacity-10 rounded-4 p-3 mb-3">
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <span class="fw-bold">Grimbergen</span>
                                    <span class="text-warning ms-2">x2</span>
                                </div>
                                <div class="col-auto">
                                    <span class="fw-bold">7,60 €</span>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-link text-danger p-0">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row align-items-center mb-2">
                                <div class="col">
                                    <span class="fw-bold">Leffe</span>
                                    <span class="text-warning ms-2">x3</span>
                                </div>
                                <div class="col-auto">
                                    <span class="fw-bold">12,00 €</span>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-link text-danger p-0">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <span class="fw-bold">Jupiler</span>
                                    <span class="text-warning ms-2">x1</span>
                                </div>
                                <div class="col-auto">
                                    <span class="fw-bold">2,80 €</span>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-link text-danger p-0">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Total et validation -->
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">TOTAL</h3>
                            </div>
                            <div class="col-auto">
                                <h2 class="text-warning fw-bold mb-0">22,40 €</h2>
                            </div>
                        </div>

                        <hr class="bg-white bg-opacity-25 my-3">

                        <div class="row g-2">
                            <div class="col">
                                <button class="btn btn-outline-light w-100 py-3 rounded-pill">
                                    <i class="bi bi-x-lg me-2"></i>Annuler
                                </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-warning w-100 py-3 rounded-pill fw-bold">
                                    <i class="bi bi-check-lg me-2"></i>VALIDER LA COMMANDE
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