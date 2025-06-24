// Efecto smooth scroll para los enlaces
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
// Manejo del formulario de contacto y modal de éxito
document.querySelector('.contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Mostrar el modal
    const modal = document.getElementById('successModal');
    modal.style.display = 'flex';
    
    // Ocultar el modal al hacer clic en la X
    document.querySelector('.close-modal').addEventListener('click', function() {
        modal.style.display = 'none';
        resetForm();
    });
    
    // Ocultar el modal al hacer clic fuera del contenido
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
            resetForm();
        }
    });
    
    // Resetear automáticamente después de 5 segundos
    setTimeout(() => {
        if (modal.style.display === 'flex') {
            modal.style.display = 'none';
            resetForm();
        }
    }, 5000);
    
    // Función para resetear el formulario
    function resetForm() {
        const form = document.querySelector('.contact-form');
        form.reset();
        
        // Resetear clases de validación si las tienes
        form.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('.error-message').forEach(el => {
            el.remove();
        });
    }
});
