USE directclass;

-- INSERT INTO Disciplina (Nome) VALUES 
-- ('Matemática'),
-- ('Física'),
-- ('Química'),
-- ('Biologia'),
-- ('História'),
-- ('Geografia'),
-- ('Inglês'),
-- ('Português');


-- Inserindo Professores
INSERT INTO Professor (Nome, PrecoHora, Localidade, AulaOnline, HorarioInicio, HorarioFim) VALUES
('Carlos Silva', 50, 'São Paulo', 1, '08:00', '12:00'),
('Maria Oliveira', 40, 'Rio de Janeiro', 0, '10:00', '14:00'),
('Pedro Santos', 60, 'São Paulo', 1, '09:00', '13:00'),
('Joana Souza', 35, 'Curitiba', 0, '14:00', '18:00'),
('Lucas Lima', 55, 'Porto Alegre', 1, '08:30', '12:30'),
('Ana Costa', 45, 'Belo Horizonte', 1, '13:00', '17:00'),
('Beatriz Martins', 48, 'Brasília', 0, '07:00', '11:00'),
('Felipe Albuquerque', 52, 'Salvador', 1, '09:00', '13:00'),
('Carla Mendes', 42, 'Recife', 0, '14:00', '18:00'),
('Ricardo Borges', 58, 'Florianópolis', 1, '10:00', '15:00'),
('Patrícia Almeida', 37, 'Manaus', 0, '08:00', '12:00'),
('Thiago Cardoso', 50, 'Belém', 1, '13:00', '17:00'),
('Fernanda Rocha', 43, 'Fortaleza', 0, '07:30', '11:30'),
('Gabriel Araujo', 53, 'São Paulo', 1, '09:30', '13:30'),
('Juliana Nunes', 38, 'São Luís', 0, '08:00', '12:00');

-- Relacionando os professores às disciplinas (ProfessorDisciplina)
INSERT INTO ProfessorDisciplina (IDProfessor, IDDisciplina) VALUES
(1, 1), -- Carlos Silva ensina Matemática
(2, 2), -- Maria Oliveira ensina Física
(3, 3), -- Pedro Santos ensina Química
(4, 4), -- Joana Souza ensina Biologia
(5, 5), -- Lucas Lima ensina História
(6, 6), -- Ana Costa ensina Geografia
(7, 7), -- Beatriz Martins ensina Inglês
(8, 8), -- Felipe Albuquerque ensina Português
(9, 1), -- Carla Mendes ensina Matemática
(10, 2), -- Ricardo Borges ensina Física
(11, 3), -- Patrícia Almeida ensina Química
(12, 4), -- Thiago Cardoso ensina Biologia
(13, 5), -- Fernanda Rocha ensina História
(14, 6), -- Gabriel Araujo ensina Geografia
(15, 7); -- Juliana Nunes ensina Inglês

-- Inserindo Disponibilidade dos Professores
INSERT INTO Disponibilidade (IDProfessor, DiaSemana) VALUES
(1, 'Segunda'),
(1, 'Quarta'),
(1, 'Sexta'),
(2, 'Terça'),
(2, 'Quinta'),
(3, 'Segunda'),
(3, 'Quarta'),
(4, 'Terça'),
(4, 'Quinta'),
(5, 'Sexta'),
(5, 'Domingo'),
(6, 'Segunda'),
(6, 'Quarta'),
(7, 'Quinta'),
(7, 'Sexta'),
(8, 'Sábado'),
(8, 'Domingo'),
(9, 'Segunda'),
(9, 'Terça'),
(10, 'Quarta'),
(10, 'Quinta'),
(11, 'Sexta'),
(11, 'Domingo'),
(12, 'Segunda'),
(12, 'Terça'),
(13, 'Quarta'),
(13, 'Sexta'),
(14, 'Quinta'),
(14, 'Sábado'),
(15, 'Domingo'),
(15, 'Segunda');
