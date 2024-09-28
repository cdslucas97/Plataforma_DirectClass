// Função para habilitar/desabilitar o campo de localidade ao marcar o checkbox
function toggleLocalidadeHomepage() {
    var checkbox = document.getElementById("aulaOnline");
    var localidadeField = document.getElementById("localidade");
    if (checkbox.checked) {
        localidadeField.disabled = true;
        localidadeField.value = ""; // Limpa o campo quando aula online é marcada
    } else {
        localidadeField.disabled = false;
    }
}

// Validação para a página de homepage
function validarFormHomepage() {
    var disciplina = document.getElementById("disciplina").value;
    var localidade = document.getElementById("localidade").value;
    var aulaOnline = document.getElementById("aulaOnline").checked;
    var errorMessage = document.getElementById("error-message");

    if (!disciplina) {
        errorMessage.innerHTML = "Por favor, preencha a disciplina.";
        errorMessage.style.display = "block";
        return false;
    }

    if (!aulaOnline && !localidade) {
        errorMessage.innerHTML = "Por favor, preencha a localidade ou marque a opção de aula online.";
        errorMessage.style.display = "block";
        return false;
    }

    errorMessage.style.display = "none";
    return true;
}

// Associar as funções aos eventos de formulário e checkbox
document.getElementById("aulaOnline").addEventListener("change", toggleLocalidadeHomepage);
document.getElementById("searchForm").onsubmit = validarFormHomepage;
