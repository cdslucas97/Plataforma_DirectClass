document.getElementById('formCadastro').addEventListener('submit', (event) => {
    event.preventDefault();

    const nome = document.getElementById('nome').value;
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;
    const endereco = document.getElementById('endereco').value;
    const cpf = document.getElementById('cpf').value;
    const senha = document.getElementById('senha').value;

    if (!nome || !username || !email || !telefone || !endereco || !cpf || !senha) {
        return alert('Preencha todos os campos.');
    }

    fetch('cadastroAluno.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `nome=${encodeURIComponent(nome)}&username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}&telefone=${encodeURIComponent(telefone)}&endereco=${encodeURIComponent(endereco)}&cpf=${encodeURIComponent(cpf)}&senha=${encodeURIComponent(senha)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Exibe a mensagem de sucesso ou erro vinda do PHP
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert('Ocorreu um erro ao tentar realizar o cadastro.');
    });
});

document.querySelector('.BotaoRedirecionamento').addEventListener('click', () => {
    window.location.href = 'cadastroProfessor.html';
});