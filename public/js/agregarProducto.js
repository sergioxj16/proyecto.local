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


function validarPrecio() {
    let precioInput = document.getElementById('precio');
    let precio = precioInput.value;

    // Expresión regular para comprobar que el precio tiene más de dos decimales
    let regex = /^\d+(\.\d{1,2})?$/;

    if (!regex.test(precio)) {
        document.getElementById('errorPrecio').style.display = 'block';
        return false;  // No se envía el formulario
    } else {
        document.getElementById('errorPrecio').style.display = 'none';
        return true;  // Se permite el envío del formulario
    }
}

function borrarFormulario() {
    document.getElementById('formularioSubida').reset(); // Resetea todos los campos del formulario
}

// Borrar el formulario después de un envío exitoso
