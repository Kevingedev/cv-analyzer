document.addEventListener('DOMContentLoaded', function() {
    // Selecciona el alert por ID
    const alert = document.getElementById('alert-message');
    
    if (alert) {
      // Establece un temporizador para eliminar el alert después de 4 segundos
      setTimeout(function() {
        alert.remove(); // Elimina el alert del DOM
      }, 4000); // 4 segundos
    }
});

  // CODIGO PARA HABILITAR EL BOTON CUANDO SE AGREGUE UN DOCUMENTO

