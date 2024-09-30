document.querySelector('.cadastroPform').addEventListener('submit', (event) => {
    event.preventDefault();

    const nome = document.querySelector('.nome').value;
    const username = document.querySelector('.username').value;
    const email = document.querySelector('.email').value;
    const telefone = document.querySelector('.telefone').value;
    const endereco = document.querySelector('.endereco').value;
    const cpf = document.querySelector('.cpf').value;
    const senha = document.querySelector('.senha').value;

    if (!nome || !username || !email || !telefone || !endereco || !cpf || !senha) {
        return alert('Preencha todos os campos.');
    }

    fetch('cadastroProfessor.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `nome=${nome}&username=${username}&email=${email}&telefone=${telefone}&endereco=${endereco}&cpf=${cpf}&senha=${senha}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data === 'success' ? 'Cadastro realizado com sucesso!' : data);
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
});
