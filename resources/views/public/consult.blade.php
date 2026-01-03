<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Vehículo | HEAVY GLASS</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 12px;
        }

        .brand {
            font-weight: 700;
            letter-spacing: 1px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-lg">

                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0 brand">
                        <i class="fas fa-car me-2"></i>
                        HEAVY GLASS
                    </h4>
                    <small>Consulta el estado de tu vehículo</small>
                </div>

                <div class="card-body p-4">

                    <p class="text-muted text-center mb-4">
                        Ingresa el <strong>número de proforma</strong> o la
                        <strong>placa del vehículo</strong>
                    </p>

                    {{-- ERRORES --}}
                    @if ($errors->any())
                        <div class="alert alert-danger text-center">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('public.search') }}" method="GET">

                        <div class="mb-3">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-lg text-center"
                                   placeholder="Ej: ABC1234 o 25"
                                   value="{{ old('search') }}"
                                   required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-1"></i>
                                Consultar estado
                            </button>
                        </div>

                    </form>

                </div>

                <div class="card-footer text-center text-muted small">
                    Consulta disponible 24/7 • Sistema HEAVY GLASS
                </div>

            </div>

        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
