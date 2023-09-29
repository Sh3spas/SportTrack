<?php include_once __ROOT__ . "/views/header.php"; ?>

<div class="formulaire">
    <h1 class="Sous_titre">
        Ajouter des enregistrements
    </h1>
    <form method="post" enctype="multipart/form-data">
        <p>Inserrez un nouveau fichier :</p>
        <input type='text' name="filename" id="filename">
        <input type="file" accept=".json" name="file"><br>
        <input type="submit" name="submit" value="Envoyer">
    </form>
</div>

<script>
    // Ce script permet de récupérer le nom de l'activité et le présemplir dans le formulaire
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.querySelector('input[type="file"]');
        const filenameInput = document.getElementById('filename');

        fileInput.addEventListener('change', function () {
            const selectedFile = fileInput.files[0];

            if (selectedFile) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    try {
                        const jsonData = JSON.parse(event.target.result);
                        const description = jsonData.activity.description;
                        filenameInput.value = description;
                    } catch (error) {
                        console.error("Erreur lors de la lecture du fichier JSON :", error);
                    }
                };

                reader.readAsText(selectedFile);
            }
        });
    });
</script>


<?php include_once __ROOT__ . "/views/footer.php"; ?>
