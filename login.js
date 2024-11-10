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
        body: `email=${encodeURIComponent(email)}&senha=${encodeURIComponent(senha)}`
    })
    .then(response => response.text())
    .then(data => {
        if (data.startsWith('success:')) {
            const userType = data.split(':')[1];
            if (userType === 'aluno') {
                window.location.href = 'telahome.html'; // Redireciona para a tela do aluno
            } else if (userType === 'professor') {
                window.location.href = 'telahome.html'; // Redireciona para a tela do professor
            } else {
                alert('Tipo de usuário desconhecido.');
            }
        } else {
            alert('Usuário ou senha incorretos.');
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
});
