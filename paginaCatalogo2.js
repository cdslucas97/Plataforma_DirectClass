document.addEventListener("DOMContentLoaded", function() {
    // Carregar disciplinas
    fetch("paginaCatalogo2.php")
        .then(response => response.json())  // Garantir que a resposta seja JSON
        .then(data => {
            const select = document.getElementById("disciplina");
            select.innerHTML = "<option value=''>Selecione uma disciplina</option>";
            data.forEach(disciplina => {
                const option = document.createElement("option");
                option.value = disciplina.IDDisciplina;
                option.textContent = disciplina.Nome;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Erro ao carregar disciplinas:", error);
            alert("Ocorreu um erro ao carregar as disciplinas. Tente novamente mais tarde.");
        });

    // Adicionando evento para carregar os professores ao selecionar uma disciplina
    const selectDisciplina = document.getElementById("disciplina");
    selectDisciplina.addEventListener("change", function() {
        const disciplinaId = this.value;

        if (disciplinaId) {
            // Carregar professores para a disciplina selecionada
            fetch(`paginaCatalogo2.php?disciplinaId=${disciplinaId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar professores: ' + response.status);
                    }
                    return response.json(); // Converte a resposta para JSON
                })
                .then(professores => {
                    const container = document.getElementById("professor-container");
                    container.innerHTML = ""; // Limpa o container antes de adicionar os professores

                    if (professores.length > 0) {
                        professores.forEach(professor => {
                            const professorElement = document.createElement("div");
                            professorElement.classList.add("professor");

                            professorElement.innerHTML = `
                                <h3>${professor.Nome}</h3>
                                <p>Horário: ${professor.HorarioInicio} - ${professor.HorarioFim}</p>
                                <p>Preço por hora: R$ ${professor.PrecoHora}</p>
                                <p>CPF: ${professor.CPF}</p>
                                <button class="btn-comprar" data-professor-id="${professor.CPF}">Comprar</button>
                            `;
                            container.appendChild(professorElement);
                        });
                    } else {
                        container.innerHTML = "<p>Nenhum professor disponível para esta disciplina.</p>";
                    }

                    // Adiciona evento de clique para redirecionar para a página de pagamento
                    const buttonsComprar = document.querySelectorAll(".btn-comprar");
                    buttonsComprar.forEach(button => {
                        button.addEventListener("click", function() {
                            const professorId = this.getAttribute("data-professor-id");
                            // Redirecionar para a página de pagamento com o ID do professor na URL
                            window.location.href = `paginapagamento.html?professorId=${professorId}`;
                        });
                    });
                })
                .catch(error => {
                    console.error("Erro ao carregar professores:", error);
                    alert("Ocorreu um erro ao carregar os professores. Tente novamente mais tarde.");
                });
        } else {
            // Limpa o container de professores se nenhuma disciplina for selecionada
            document.getElementById("professor-container").innerHTML = "";
        }
    });
});
