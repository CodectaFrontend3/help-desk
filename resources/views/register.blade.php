<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="style/register.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="form-contenedor">
        <h2 class="form-titulo">Registrar</h2>
        <form action="{{ url('/api/register') }}" method="POST">
            @csrf
            <div class="campos-group">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" placeholder="Nombre del usuario" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="Correo" required>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" placeholder="Contraseña" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Contraseña" required>
                </div>
                <br>
            </div>
            <div class="button-submit">
                <button type="submit">Registrar</button>
            </div>
        </form>

        @if (isset($error))
            <div class="error-message">
                {{ $error }}
            </div>
        @endif
    </div>
</body>
</html>
