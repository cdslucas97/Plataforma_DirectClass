document.addEventListener('DOMContentLoaded', function() {
    const aulaOnlineCheckbox = document.getElementById('aulaOnline');
    const localidadeInput = document.getElementById('localidade');
    const errorMessage = document.getElementById('error-message');
    
    aulaOnlineCheckbox.addEventListener('change', function() {
        if (this.checked) {
            localidadeInput.disabled = true;
            localidadeInput.value = '';
        } else {
            localidadeInput.disabled = false;
        }
    });
    
    document.querySelector('.btn-filtrar').addEventListener('click', function(event) {
        const disciplina = document.getElementById('disciplina').value;
        const localidade = document.getElementById('localidade').value;

        if (disciplina === '' || (!aulaOnlineCheckbox.checked && localidade === '')) {
            errorMessage.textContent = "Por favor, preencha a disciplina e a localidade ou marque a opção de aula online.";
            errorMessage.style.display = 'block';
            event.preventDefault();
        } else {
            errorMessage.style.display = 'none';
        }
    });
});
