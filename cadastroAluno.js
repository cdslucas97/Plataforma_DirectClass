document.querySelector('.BotaoEnvio').addEventListener('click', () => {
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
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nome, username, email, telefone, endereco, cpf, senha })
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Erro ao cadastrar.');
    })
    .then(data => {
        alert('Cadastro realizado com sucesso!');
        // Aqui você pode redirecionar ou realizar outra ação
    })
    .catch(error => {
        console.error(error);
        alert('Erro no cadastro. Tente novamente.');
    });
});