
const imagenes = document.querySelectorAll('.item img');
const modal = document.getElementById('modal');
const imgGrande = document.getElementById('imgGrande');
const cerrar = document.querySelector('.cerrar');

imagenes.forEach(img => {
    img.addEventListener('click', () => {
        modal.style.display = "block";
        imgGrande.src = img.src;
    });
});

cerrar.onclick = () => modal.style.display = "none";

modal.onclick = () => modal.style.display = "none";
