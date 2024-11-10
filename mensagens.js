document.getElementById('mensagemForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const destinatarioCpf = document.getElementById('destinatarioCpf').value;
    const conteudo = document.getElementById('conteudo').value;

    fetch('mensagens.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `destinatario_cpf=${encodeURIComponent(destinatarioCpf)}&conteudo=${encodeURIComponent(conteudo)}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        document.getElementById('mensagemForm').reset(); // Limpa o formulário após o envio
        carregarMensagens(); // Carrega mensagens após o envio
    })
    .catch(error => {
        console.error('Erro:', error);
    });
});

// Função para carregar mensagens recebidas
function carregarMensagens() {
    fetch('mensagens.php')
    .then(response => response.json())
    .then(mensagens => {
        const mensagensList = document.getElementById('mensagensList');
        mensagensList.innerHTML = ''; // Limpa a lista de mensagens

        mensagens.forEach(mensagem => {
            const mensagemDiv = document.createElement('div');
            mensagemDiv.className = 'mensagem';
            mensagemDiv.innerHTML = `
                <strong>De: ${mensagem.remetente_cpf}</strong>
                <p>${mensagem.conteudo}</p>
                <small>${new Date(mensagem.data_envio).toLocaleString()}</small>
            `;
            mensagensList.appendChild(mensagemDiv);
        });
    })
    .catch(error => {
        console.error('Erro ao carregar mensagens:', error);
    });
}

// Carrega mensagens ao iniciar a página
window.onload = carregarMensagens;
