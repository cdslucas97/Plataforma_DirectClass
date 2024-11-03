document.querySelector('.formadepagamento').addEventListener('submit', (event) => {
    event.preventDefault();

    const numero = document.querySelector('.numero').value;
    const dataexpiracao = document.querySelector('.dataexpiracao').value;
    const cvv = document.querySelector('.cvv').value;
    

    if (!numero || !dataexpiracao || !cvv ) {
        return alert('Preencha todos os campos.');
    }

    fetch('paginapagamento.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `numero=${numero}&dataexpiracao=${dataexpiracao}&cvv=${cvv}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data === 'success' ? 'pagamento realizado com sucesso!' : data);
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
});
