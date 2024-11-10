document.addEventListener("DOMContentLoaded", function() {
    fetch('perfil.php')
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao buscar dados do usuário.");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                document.getElementById("detalhes").innerHTML = `<p>${data.error}</p>`;
            } else {
                document.getElementById("detalhes").innerHTML = `
                    <p><strong>Nome:</strong> ${data.Nome}</p>
                    <p><strong>Username:</strong> ${data.Username}</p>
                    <p><strong>Tipo de Usuário:</strong> ${data.TipoUsuario}</p>
                `;
            }
        })
        .catch(error => {
            document.getElementById("detalhes").innerHTML = `<p>Erro: ${error.message}</p>`;
            console.error("Erro:", error);
        });
});
