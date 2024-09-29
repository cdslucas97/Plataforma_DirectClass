document.addEventListener("DOMContentLoaded", function () {
    const disciplinaInput = document.getElementById("disciplina");
    const localidadeInput = document.getElementById("localidade");
    const aulaOnlineCheckbox = document.getElementById("aulaOnline");
    const buscarButton = document.getElementById("buscar");

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

        if (disciplina === "") {
            alert("Por favor, preencha a disciplina.");
            event.preventDefault();  // Impede o envio do formulário
            return false;
        }

        if (!aulaOnline && localidade === "") {
            alert("Por favor, preencha a localidade ou marque a opção de aula online.");
            event.preventDefault();  // Impede o envio do formulário
            return false;
        }

        // Se tudo estiver correto, o formulário será enviado e a página será redirecionada
        window.location.href = "paginaCatalogo.html";  // Redireciona para a página de catálogo
        return true;
    }

    // Adiciona o evento de clique no botão Buscar
    buscarButton.addEventListener("click", function (event) {
        validateForm(event);  // Executa a função de validação no clique do botão
    });
});
