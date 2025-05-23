<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información del Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            padding: 20px;
            border: 1px solid #eee;
            max-width: 600px;
            margin: auto;
            background-color: #f9f9f9;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        p {
            margin: 8px 0;
            line-height: 1.5;
        }
        .label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Datos del Usuario</h2>
        <p><span class="label">Nombre:</span> {{ $user->name }}</p>
        <p><span class="label">Email:</span> {{ $user->email }}</p>
        <p><span class="label">Creado el:</span> {{ $user->created_at->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>