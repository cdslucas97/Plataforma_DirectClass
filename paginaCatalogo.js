document.addEventListener('DOMContentLoaded', function () {
    const aulaOnlineCheckbox = document.getElementById('aulaOnline');
    const localidadeInput = document.getElementById('localidade');
    const disciplinaSelect = document.getElementById('disciplina');
    const conteudoSelect = document.getElementById('conteudo');
    const precoMinInput = document.getElementById('preco-min');
    const precoMaxInput = document.getElementById('preco-max');
    const horarioInicioInput = document.getElementById('horario-inicio');
    const horarioFimInput = document.getElementById('horario-fim');
    const diasCheckboxes = document.querySelectorAll('.disponibilidade-checkboxes input[type="checkbox"]');
    const errorMessage = document.getElementById('error-message');
    const filtrarButton = document.querySelector('.btn-filtrar');

    // Função para habilitar/desabilitar o campo de localidade com base na seleção de aula online
    aulaOnlineCheckbox.addEventListener('change', function () {
        if (this.checked) {
            localidadeInput.disabled = true; // Desabilita localidade
            localidadeInput.value = ''; // Limpa o valor da localidade
        } else {
            localidadeInput.disabled = false; // Habilita localidade se desmarcar aula online
        }
    });

    // Função de validação dos campos antes de filtrar
    filtrarButton.addEventListener('click', function (event) {
        const disciplina = disciplinaSelect.value.trim();
        const localidade = localidadeInput.value.trim();
        const conteudo = conteudoSelect.value.trim();
        const precoMin = precoMinInput.value.trim();
        const precoMax = precoMaxInput.value.trim();
        const horarioInicio = horarioInicioInput.value.trim();
        const horarioFim = horarioFimInput.value.trim();
        const aulaOnlineChecked = aulaOnlineCheckbox.checked;

        // Verifica se a disciplina foi selecionada
        if (disciplina === '') {
            errorMessage.textContent = "Por favor, selecione uma disciplina.";
            errorMessage.style.display = 'block';
            event.preventDefault(); // Impede o envio do formulário
            return;
        }

        // Verifica se o campo de localidade foi preenchido ou se aula online foi marcada
        if (!aulaOnlineChecked && localidade === '') {
            errorMessage.textContent = "Por favor, preencha a localidade ou marque a opção de aula online.";
            errorMessage.style.display = 'block';
            event.preventDefault(); // Impede o envio do formulário
            return;
        }

        // Se tudo estiver correto, oculta a mensagem de erro e atualiza a URL
        errorMessage.style.display = 'none';

        // Construa a URL com os parâmetros de filtro
        let url = `paginaCatalogo.php?disciplina=${encodeURIComponent(disciplina)}&localidade=${encodeURIComponent(localidade)}&aulaOnline=${aulaOnlineChecked}`;

        if (conteudo !== '') {
            url += `&conteudo=${encodeURIComponent(conteudo)}`;
        }

        if (precoMin !== '') {
            url += `&precoMin=${encodeURIComponent(precoMin)}`;
        }

        if (precoMax !== '') {
            url += `&precoMax=${encodeURIComponent(precoMax)}`;
        }

        if (horarioInicio !== '') {
            url += `&horarioInicio=${encodeURIComponent(horarioInicio)}`;
        }

        if (horarioFim !== '') {
            url += `&horarioFim=${encodeURIComponent(horarioFim)}`;
        }

        // Adicionar dias de disponibilidade marcados à URL
        let diasDisponiveis = [];
        diasCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                diasDisponiveis.push(checkbox.nextElementSibling.textContent.trim());
            }
        });

        if (diasDisponiveis.length > 0) {
            url += `&dias=${encodeURIComponent(diasDisponiveis.join(','))}`;
        }

        // Redireciona para a nova URL com os parâmetros
        window.location.href = url;
    });

    // Verifica se a página foi carregada com aula online já marcada e desabilita o campo de localidade
    if (aulaOnlineCheckbox.checked) {
        localidadeInput.disabled = true; // Desabilita o campo de localidade se o checkbox de aula online estiver marcado
    }
});
