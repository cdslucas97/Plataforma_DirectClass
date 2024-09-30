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
    const filtrarButton = document.querySelector('.btn-filtrar');
    const professorContainer = document.getElementById('professor-container');

    // Carregar disciplinas ao carregar a página
    fetch('paginaCatalogo.php?loadDisciplinas=true')
        .then(response => response.json())
        .then(disciplinas => {
            disciplinas.forEach(disciplina => {
                const option = document.createElement('option');
                option.value = disciplina.IDDisciplina;
                option.textContent = disciplina.Nome;
                disciplinaSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Erro ao carregar disciplinas:', error));    

    // Função para habilitar/desabilitar o campo de localidade com base na seleção de aula online
    aulaOnlineCheckbox.addEventListener('change', function () {
        if (this.checked) {
            localidadeInput.disabled = true;
            localidadeInput.value = '';
        } else {
            localidadeInput.disabled = false;
        }
    });

    // Função de validação e filtragem
    filtrarButton.addEventListener('click', function () {
        const disciplina = disciplinaSelect.value.trim();
        const localidade = localidadeInput.value.trim();
        const conteudo = conteudoSelect.value.trim();
        const precoMin = precoMinInput.value.trim();
        const precoMax = precoMaxInput.value.trim();
        const horarioInicio = horarioInicioInput.value.trim();
        const horarioFim = horarioFimInput.value.trim();
        const aulaOnlineChecked = aulaOnlineCheckbox.checked;

        // Resetando a mensagem de erro
        errorMessage.style.display = 'none';
        errorMessage.textContent = '';

        // Validação dos campos
        if (disciplina === '') {
            errorMessage.textContent = 'Por favor, selecione uma disciplina.';
            errorMessage.style.display = 'block';
            return;
        }
        
        if (!aulaOnlineChecked && localidade === '') {
            errorMessage.textContent = 'Por favor, preencha a localidade ou marque a opção de aula online.';
            errorMessage.style.display = 'block';
            return;
        }
        
        // Validação opcional para preço mínimo e máximo (se for obrigatório)
        if (precoMin !== '' && isNaN(precoMin)) {
            errorMessage.textContent = 'Por favor, insira um preço mínimo válido.';
            errorMessage.style.display = 'block';
            return;
        }
        
        if (precoMax !== '' && isNaN(precoMax)) {
            errorMessage.textContent = 'Por favor, insira um preço máximo válido.';
            errorMessage.style.display = 'block';
            return;
        }        
        
        let diasSelecionados = [];
        diasCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                diasSelecionados.push(checkbox.value);
            }
        });

        const filtros = {
            disciplina: disciplina,
            localidade: localidade,
            aulaOnline: aulaOnlineChecked,
            precoMin: precoMin,
            precoMax: precoMax,
            horarioInicio: horarioInicio,
            horarioFim: horarioFim,
            diasSemana: diasSelecionados.join(',')
        };

        // Enviar a requisição para o PHP com os filtros
        fetch('paginaCatalogo.php?' + new URLSearchParams(filtros))
            .then(response => response.json())
            .then(data => {
                professorContainer.innerHTML = '';  // Limpa a lista anterior
                if (data.length > 0) {
                    data.forEach(professor => {
                        professorContainer.innerHTML += `
                            <a href="paginaItemCatalogo.php?professor_id=${professor.IDProfessor}" class="professor-card">
                                <img src="professor.jpg" alt="Foto do Professor">
                                <div class="professor-info">
                                    <h3>${professor.Nome}</h3>
                                    <p>Preço: R$ ${professor.PrecoHora} / hora</p>
                                    <p>Disponibilidade: ${professor.Disponibilidade}</p>
                                </div>
                            </a>
                        `;
                    });
                } else {
                    professorContainer.innerHTML = '<p>Nenhum professor encontrado com esses filtros.</p>';
                }
            })
            .catch(error => {
                console.error('Erro ao buscar professores:', error);
                professorContainer.innerHTML = '<p>Erro ao carregar professores. Tente novamente mais tarde.</p>';
            });
    });
});
