<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestor de Archivos</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>📂 Subir Archivos de Alumno</h2>
        <form id="uploadForm" enctype="multipart/form-data">
            <label for="matricula">Matrícula:</label>
            <input type="text" id="matricula" name="matricula" required placeholder="Ej: 12345">

            <div id="dropArea">
                <div class="icon"></div>
                <p>Drag & Drop</p>
                <span>o haz click para seleccionar archivos</span>
                <input type="file" id="fileInput" name="files[]" multiple hidden>
            </div>

            <ul id="fileList"></ul>

            <button type="submit">Subir Archivos</button>
        </form>
    </div>

    <script>
        const dropArea = document.getElementById("dropArea");
        const fileInput = document.getElementById("fileInput");
        const fileList = document.getElementById("fileList");
        const form = document.getElementById("uploadForm");

        let filesArray = [];

        dropArea.addEventListener("click", () => fileInput.click());
        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("hover");
        });
        dropArea.addEventListener("dragleave", () => dropArea.classList.remove("hover"));
        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("hover");
            handleFiles(e.dataTransfer.files);
        });
        fileInput.addEventListener("change", (e) => handleFiles(e.target.files));

        function handleFiles(files) {
            for (let file of files) {
                filesArray.push(file);
            }
            renderFileList();
        }

        function renderFileList() {
            fileList.innerHTML = "";
            filesArray.forEach((file, index) => {
                const li = document.createElement("li");
                li.textContent = file.name;
                const removeBtn = document.createElement("button");
                removeBtn.textContent = "✖";
                removeBtn.onclick = () => {
                    filesArray.splice(index, 1);
                    renderFileList();
                };
                li.appendChild(removeBtn);
                fileList.appendChild(li);
            });
        }

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const matricula = document.getElementById("matricula").value.trim();
            if (!matricula) {
                Swal.fire("Error", "Debe ingresar una matrícula", "error");
                return;
            }

            const formData = new FormData();
            formData.append("matricula", matricula);
            filesArray.forEach(file => formData.append("files[]", file));

            const response = await fetch("upload.php", { method: "POST", body: formData });
            const result = await response.json();

            Swal.fire(result.status === "success" ? "Éxito" : "Error", result.mensaje, result.status);

            if (result.status === "success") {
                filesArray = [];
                renderFileList();
                form.reset();
            }
        });
    </script>
</body>
</html>

