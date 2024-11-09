document.addEventListener('DOMContentLoaded', function () {
    // Seleciona elementos do DOM
    const aulaOnlineCheckbox = document.getElementById('aulaOnline'); // Checkbox de aula online
    const localidadeInput = document.getElementById('localidade'); // Campo de texto para localidade
    const disciplinaSelect = document.getElementById('disciplina'); // Select para escolher disciplina
    const conteudoSelect = document.getElementById('conteudo'); // Select para escolher conteúdo
    const precoMinInput = document.getElementById('preco-min'); // Input de preço mínimo
    const precoMaxInput = document.getElementById('preco-max'); // Input de preço máximo
    const horarioInicioInput = document.getElementById('horario-inicio'); // Input de horário de início
    const horarioFimInput = document.getElementById('horario-fim'); // Input de horário de fim
    const diasCheckboxes = document.querySelectorAll('.disponibilidade-checkboxes input[type="checkbox"]'); // Checkbox para dias da semana
    const filtrarButton = document.querySelector('.btn-filtrar'); // Botão para aplicar os filtros
    const professorContainer = document.getElementById('professor-container'); // Contêiner para exibir professores
    const errorMessage = document.getElementById('error-message'); // Mensagem de erro
    const logoLink = document.querySelector('.btn-logo'); // Link da logo, usado para limpar sessionStorage

    // Função para carregar as disciplinas ao abrir a página
    fetch('paginaCatalogo.php?loadDisciplinas=true')
        .then(response => response.json()) // Recebe a resposta em JSON
        .then(disciplinas => {
            // Para cada disciplina recebida, cria um <option> no select de disciplinas
            disciplinas.forEach(disciplina => {
                const option = document.createElement('option');
                option.value = disciplina.IDDisciplina;
                option.textContent = disciplina.Nome;
                disciplinaSelect.appendChild(option);
            });
            loadFiltersFromSession(); // Carrega filtros salvos no sessionStorage ao carregar as disciplinas
        })
        .catch(error => console.error('Erro ao carregar disciplinas:', error)); // Log de erro em caso de falha

    // Evento para carregar conteúdos quando uma disciplina é selecionada
    disciplinaSelect.addEventListener('change', function () {
        const disciplinaId = disciplinaSelect.value;
        if (disciplinaId) {
            conteudoSelect.innerHTML = '<option>Selecione o conteúdo</option>'; // Resetar opções de conteúdo

            // Chama o PHP para obter os conteúdos da disciplina selecionada
            fetch(`paginaCatalogo.php?disciplina_id=${disciplinaId}`)
                .then(response => response.json()) // Recebe resposta em JSON
                .then(conteudos => {
                    // Para cada conteúdo recebido, cria um <option> no select de conteúdos
                    conteudos.forEach(conteudo => {
                        const option = document.createElement('option');
                        option.value = conteudo.IDConteudo;
                        option.textContent = conteudo.Nome;
                        conteudoSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao carregar conteúdos:', error)); // Log de erro
        } else {
            conteudoSelect.innerHTML = '<option>Selecione o conteúdo</option>'; // Resetar conteúdo se nenhuma disciplina for selecionada
        }
    });

    // Habilita/desabilita o campo de localidade com base na seleção de aula online
    aulaOnlineCheckbox.addEventListener('change', function () {
        if (this.checked) {
            localidadeInput.disabled = true; // Desabilita campo localidade se aula online estiver marcada
            localidadeInput.value = ''; // Limpa valor do campo localidade
        } else {
            localidadeInput.disabled = false; // Habilita campo localidade
        }
    });

    // Função para carregar filtros salvos no sessionStorage
    function loadFiltersFromSession() {
        // Recupera cada filtro do sessionStorage
        disciplinaSelect.value = sessionStorage.getItem("disciplina") || ''; // Disciplina
        conteudoSelect.value = sessionStorage.getItem("conteudo") || ''; // Conteúdo
        localidadeInput.value = sessionStorage.getItem("localidade") || ''; // Localidade
        aulaOnlineCheckbox.checked = sessionStorage.getItem("aulaOnline") === "true"; // Aula online
        precoMinInput.value = sessionStorage.getItem("precoMin") || ''; // Preço mínimo
        precoMaxInput.value = sessionStorage.getItem("precoMax") || ''; // Preço máximo
        horarioInicioInput.value = sessionStorage.getItem("horarioInicio") || ''; // Horário de início
        horarioFimInput.value = sessionStorage.getItem("horarioFim") || ''; // Horário de fim

        // Recupera dias da semana selecionados
        const diasSelecionados = sessionStorage.getItem("diasSemana") ? sessionStorage.getItem("diasSemana").split(",") : [];
        diasCheckboxes.forEach(checkbox => {
            checkbox.checked = diasSelecionados.includes(checkbox.value); // Marca os checkboxes dos dias selecionados
        });

        // Desabilita o campo de localidade se "Aula Online" estiver marcada
        if (aulaOnlineCheckbox.checked) {
            localidadeInput.disabled = true;
        }
    }

    // Função de validação e envio dos filtros para o PHP
    filtrarButton.addEventListener('click', function () {
        // Coleta os valores de cada campo
        const disciplina = disciplinaSelect.value.trim();
        const conteudo = conteudoSelect.value.trim();
        const localidade = localidadeInput.value.trim();
        const precoMin = precoMinInput.value.trim();
        const precoMax = precoMaxInput.value.trim();
        const horarioInicio = horarioInicioInput.value.trim();
        const horarioFim = horarioFimInput.value.trim();
        const aulaOnlineChecked = aulaOnlineCheckbox.checked;

        // Reseta a mensagem de erro
        errorMessage.style.display = 'none';
        errorMessage.textContent = '';

        // Validação de disciplina
        if (disciplina === '') {
            errorMessage.textContent = 'Por favor, selecione uma disciplina.';
            errorMessage.style.display = 'block';
            return;
        }

        // Validação de localidade se aula online não estiver marcada
        if (!aulaOnlineChecked && localidade === '') {
            errorMessage.textContent = 'Por favor, preencha a localidade ou marque a opção de aula online.';
            errorMessage.style.display = 'block';
            return;
        }

        // Validação de preços mínimos e máximos
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

        // Coleta dias da semana selecionados
        let diasSelecionados = [];
        diasCheckboxes.forEach(function (checkbox) {
            if (checkbox.checked) {
                diasSelecionados.push(checkbox.value);
            }
        });

        // Salva filtros no sessionStorage para manter dados entre recarregamentos de página
        sessionStorage.setItem("disciplina", disciplina);
        sessionStorage.setItem("conteudo", conteudo);
        sessionStorage.setItem("localidade", localidade);
        sessionStorage.setItem("aulaOnline", aulaOnlineChecked);
        sessionStorage.setItem("precoMin", precoMin);
        sessionStorage.setItem("precoMax", precoMax);
        sessionStorage.setItem("horarioInicio", horarioInicio);
        sessionStorage.setItem("horarioFim", horarioFim);
        sessionStorage.setItem("diasSemana", diasSelecionados.join(','));

        // Cria o objeto de filtros para enviar para o PHP
        const filtros = {
            disciplina: disciplina,
            conteudo: conteudo,
            localidade: localidade,
            aulaOnline: aulaOnlineChecked,
            precoMin: precoMin,
            precoMax: precoMax,
            horarioInicio: horarioInicio,
            horarioFim: horarioFim,
            diasSemana: diasSelecionados.join(',')
        };

        // Envia os filtros para o PHP usando fetch e URLSearchParams
        fetch('paginaCatalogo.php?' + new URLSearchParams(filtros))
            .then(response => response.json())
            .then(data => {
                // Limpa o contêiner de professores antes de exibir novos resultados
                professorContainer.innerHTML = '';
                
                // Exibe os professores ou uma mensagem caso não haja resultados
                if (data.length > 0) {
                    data.forEach(professor => {
                        professorContainer.innerHTML += `
                            <a href="paginaItemCatalogo.php?professor_id=${professor.IDProfessor}" class="professor-card">
                                <img src="professor.jpg" alt="Foto do Professor">
                                <div class="professor-info">
                                    <h3>${professor.Nome}</h3>
                                    <p>Preço: R$ ${professor.PrecoHora} / hora</p>
                                    <p>Horário: ${professor.HorarioInicio} - ${professor.HorarioFim}</p>
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

    // Limpa sessionStorage ao clicar na logo
    logoLink.addEventListener('click', function () {
        sessionStorage.clear();
    });
});
