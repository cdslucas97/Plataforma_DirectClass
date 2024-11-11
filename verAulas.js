document.addEventListener("DOMContentLoaded", function() {
    fetch("paginaCatalogo2.php?action=listarAulas")
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("aulas-container");
            container.innerHTML = "";

            if (data.length > 0) {
                data.forEach(aula => {
                    const aulaElement = document.createElement("div");
                    aulaElement.classList.add("aula");

                    aulaElement.innerHTML = `
                        <p>CPF do Professor: ${aula.CPFProfessor}</p>
                        <p>Data e Hora do Agendamento: ${aula.DataHoraAgendamento}</p>
                    `;
                    container.appendChild(aulaElement);
                });
            } else {
                container.innerHTML = "<p>Nenhuma aula agendada encontrada.</p>";
            }
        })
        .catch(error => {
            console.error("Erro ao carregar aulas agendadas:", error);
            alert("Ocorreu um erro ao carregar as aulas agendadas.");
        });
});
