<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>HEAVY GLASS | Centro de Colisiones Vehiculares</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0f0f0f, #1f1f1f);
            color: #ffffff;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero h1 span {
            color: #dc3545;
        }

        .btn-login {
            background-color: #dc3545;
            border: none;
        }

        .btn-login:hover {
            background-color: #bb2d3b;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #dc3545;
        }

        footer {
            background-color: #000;
            color: #aaa;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top">
        <div class="container">
            <span class="navbar-brand fw-bold">HEAVY GLASS</span>

            <a href="<?php echo e(route('login')); ?>" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Acceso al sistema
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">
                Gestión Integral de <span>Colisiones Vehiculares</span>
            </h1>

            <p class="lead mt-4">
                Plataforma web para la recepción, evaluación, reparación y control administrativo
                de vehículos siniestrados en el taller <strong>HEAVY GLASS</strong>.
            </p>

            <div class="mt-5">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-lg btn-login px-5 py-3">
                    <i class="fas fa-user-lock"></i> Ingresar al sistema
                </a>
            </div>
            <div class="row justify-content-center mt-5">
                <div class="col-md-6 text-center">
                    <a href="<?php echo e(route('public.consult')); ?>" class="btn btn-primary btn-lg w-100 py-3 shadow">
                        <i class="fas fa-car-side fa-lg me-2"></i>
                        Consultar estado de mi vehículo
                    </a>
                    <p class="text-muted mt-2">
                        Consulte el estado de su vehículo usando su proforma o placa
                    </p>
                </div>
            </div>


        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-5 bg-dark">
        <div class="container">
            <div class="row text-center g-4">

                <div class="col-md-3">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-car-crash"></i>
                    </div>
                    <h5>Ingreso Vehicular</h5>
                    <p class="text-muted">
                        Registro detallado de vehículos, daños y evidencias fotográficas.
                    </p>
                </div>

                <div class="col-md-3">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h5>Órdenes de Trabajo</h5>
                    <p class="text-muted">
                        Asignación de trabajos por tipo y control de estado de reparación.
                    </p>
                </div>

                <div class="col-md-3">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <h5>Proformas</h5>
                    <p class="text-muted">
                        Generación de proformas claras y estructuradas para el cliente.
                    </p>
                </div>

                <div class="col-md-3">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <h5>Pagos</h5>
                    <p class="text-muted">
                        Control de cobros, pagos y registro histórico de transacciones.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-3">
        <div class="container text-center">
            <small>
                © <?php echo e(date('Y')); ?> HEAVY GLASS — Sistema de Gestión de Centro de Colisiones Vehiculares
                <br>
                Proyecto de Titulación
            </small>
        </div>
    </footer>

</body>

</html>
<?php /**PATH C:\laragon\www\TitulacionHeavy-respaldo\resources\views/landing.blade.php ENDPATH**/ ?>