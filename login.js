document.getElementById('loginButton').addEventListener('click', () => {
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    if (!email || !senha) {
        return alert('Preencha todos os campos.');
    }

    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${email}&senha=${senha}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data === 'success' ? 'Login bem-sucedido!' : 'Usuário ou senha incorretos.');
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
});
