document.addEventListener("DOMContentLoaded", function () {
    const disciplinaInput = document.getElementById("disciplina");
    const localidadeInput = document.getElementById("localidade");
    const aulaOnlineCheckbox = document.getElementById("aulaOnline");
    const buscarButton = document.getElementById("buscar");
    const errorMessage = document.getElementById("error-message");

    // Função para carregar as disciplinas via AJAX
    fetch('homepage.php')
        .then(response => response.json())
        .then(disciplinas => {
            disciplinas.forEach(disciplina => {
                const option = document.createElement("option");
                option.value = disciplina.IDDisciplina;
                option.textContent = disciplina.Nome;
                disciplinaInput.appendChild(option);
            });
        })
        .catch(error => console.error("Erro ao carregar disciplinas:", error));

    // Função para desabilitar ou habilitar o campo de localidade
    aulaOnlineCheckbox.addEventListener("change", function () {
        if (aulaOnlineCheckbox.checked) {
            localidadeInput.value = "";  // Limpa o campo de localidade se aula online for marcada
            localidadeInput.disabled = true;  // Desabilita o campo de localidade
        } else {
            localidadeInput.disabled = false;  // Habilita o campo de localidade
        }
    });

    // Função de validação dos campos
    function validateForm(event) {
        const disciplina = disciplinaInput.value.trim();
        const localidade = localidadeInput.value.trim();
        const aulaOnline = aulaOnlineCheckbox.checked;

        // Reseta a mensagem de erro
        errorMessage.style.display = "none";
        errorMessage.textContent = "";

        if (disciplina === "") {
            errorMessage.textContent = "Por favor, selecione uma disciplina.";
            errorMessage.style.display = "block";
            event.preventDefault();  // Impede o envio do formulário
            return false;
        }

        if (!aulaOnline && localidade === "") {
            errorMessage.textContent = "Por favor, preencha a localidade ou marque a opção de aula online.";
            errorMessage.style.display = "block";
            event.preventDefault();  // Impede o envio do formulário
            return false;
        }

        // Se tudo estiver correto, o formulário será enviado e a página será redirecionada
        const url = "paginaCatalogo.html?disciplina=" + encodeURIComponent(disciplina) + 
        "&localidade=" + encodeURIComponent(localidade) + 
        "&aulaOnline=" + aulaOnline;

        // Redireciona para a Página de Catálogo com os parâmetros da busca
        window.location.href = url;
    }

    // Adiciona o evento de clique no botão Buscar
    buscarButton.addEventListener("click", function (event) {
        validateForm(event);  // Executa a função de validação no clique do botão
    });
});
