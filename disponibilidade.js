document.getElementById('form-disponibilidade').addEventListener('submit', function(event) {
    const inicio = document.getElementById('horarioInicio').value;
    const fim = document.getElementById('horarioFim').value;

    if (fim <= inicio) {
        alert('O horário de término deve ser maior que o horário de início.');
        event.preventDefault();  // Impede o envio do formulário
    }
});
