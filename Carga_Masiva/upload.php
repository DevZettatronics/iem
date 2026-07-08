<?php
header('Content-Type: application/json');

$conn = new mysqli("216.70.112.239", "aulaiemueemedu_koddycontrol", "yQuGq7>~Q085Y%8uB8GF6qokr!BZpL-", "aulaiemueemedu_iem_productivo");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "mensaje" => "Error de conexión"]);
    exit;
}

$matricula = $_POST['matricula'] ?? '';
if (!$matricula) {
    echo json_encode(["status" => "error", "mensaje" => "Matrícula requerida"]);
    exit;
}

$baseDir = __DIR__ . "../../alumnos/core/app/repository/" . $matricula;
if (!is_dir($baseDir)) {
    mkdir($baseDir, 0777, true);
}

if (!empty($_FILES['files']['name'][0])) {
    foreach ($_FILES['files']['tmp_name'] as $index => $tmpName) {
        $fileName = basename($_FILES['files']['name'][$index]);
        $targetPath = $baseDir . "/" . $fileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $stmt = $conn->prepare("INSERT INTO repository (code_person, file, status) VALUES (?, ?, 1)");
            $stmt->bind_param("is", $matricula, $fileName);
            $stmt->execute();
            $stmt->close();
        }
    }
    echo json_encode(["status" => "success", "mensaje" => "✅ Archivos subidos correctamente"]);
} else {
    echo json_encode(["status" => "error", "mensaje" => "No se seleccionaron archivos"]);
}
?>
