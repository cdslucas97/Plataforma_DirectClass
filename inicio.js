document.getElementById('loginButton').addEventListener('click', function(event) {
    event.preventDefault(); // Evita o redirecionamento padrão do link
    window.location.href = "login.html"; // Redireciona para a página de login
});

document.getElementById('cadastroButton').addEventListener('click', function(event) {
    event.preventDefault(); // Evita o redirecionamento padrão do link
    window.location.href = "CadastroAluno.html"; // Redireciona para a página de cadastro
});
