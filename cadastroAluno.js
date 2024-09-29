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

document.querySelector('.BotaoRedirecionamento').addEventListener('click', () => {
    window.location.href = 'cadastroProfessor.html';
});
