document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('formularioSubida');
    const imgInput = document.getElementById('imagen');
    const imgPreview = document.getElementById('imgPreview');

    if (imgInput) {
        imgInput.addEventListener('change', event => {
            let file = event.target.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = e => {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Función para limpiar la vista previa al resetear el formulario
    form.addEventListener('reset', () => {
        imgPreview.src = "";
        imgPreview.classList.add('d-none');
    });
});
