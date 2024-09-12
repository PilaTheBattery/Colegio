<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registro de Estudiante</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
                <label for="InstId" class="form-label">Institución</label>
                <select class="form-select" id="InstId" name="InstId" required>
                    <option value="">Seleccione una institución</option>
                    <?php foreach ($instituciones as $institucion): ?>
                        <option value="<?php echo $institucion['InstId']; ?>">
                            <?php echo htmlspecialchars($institucion['InstNomb']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="EstuCedu" class="form-label">Cédula</label>
                <input type="text" class="form-control" id="EstuCedu" name="EstuCedu" required>
            </div>
            <div class="mb-3">
                <label for="EstuNomb" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="EstuNomb" name="EstuNomb" required>
            </div>
            <div class="mb-3">
                <label for="EstuApel" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="EstuApel" name="EstuApel" required>
            </div>
            <div class="mb-3">
                <label for="EstuSexo" class="form-label">Sexo</label>
                <select class="form-select" id="EstuSexo" name="EstuSexo" required>
                    <option value="">Seleccione</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="EstuFechNaci" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="EstuFechNaci" name="EstuFechNaci" required>
            </div>
            <div class="mb-3">
                <label for="EstRepr" class="form-label">Representante</label>
                <input type="text" class="form-control" id="EstRepr" name="EstRepr" required>
            </div>
            <div class="mb-3">
                <label for="EstuDesc" class="form-label">Descripción</label>
                <textarea class="form-control" id="EstuDesc" name="EstuDesc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Estudiante</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
mysqli_close($connection);
?>