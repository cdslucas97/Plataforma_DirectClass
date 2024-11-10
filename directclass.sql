-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/11/2024 às 00:59
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `directclass`
--
CREATE DATABASE IF NOT EXISTS `directclass` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `directclass`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamento`
--

DROP TABLE IF EXISTS `agendamento`;
CREATE TABLE `agendamento` (
  `IDAgendamento` int(11) NOT NULL,
  `Data` date NOT NULL,
  `Hora` time NOT NULL,
  `ValorHora` decimal(10,2) DEFAULT NULL,
  `Justificativa` text DEFAULT NULL,
  `Presenca` tinyint(1) DEFAULT NULL,
  `IDProfessor` int(11) DEFAULT NULL,
  `IDAluno` int(11) DEFAULT NULL,
  `IDDisciplina` int(11) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `Local` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `agendamento`
--

TRUNCATE TABLE `agendamento`;
-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE `aluno` (
  `IDAluno` int(11) NOT NULL,
  `CPF` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `aluno`
--

TRUNCATE TABLE `aluno`;
-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudo`
--

DROP TABLE IF EXISTS `conteudo`;
CREATE TABLE `conteudo` (
  `IDConteudo` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `conteudo`
--

TRUNCATE TABLE `conteudo`;
--
-- Despejando dados para a tabela `conteudo`
--

INSERT INTO `conteudo` (`IDConteudo`, `Nome`, `Descricao`) VALUES
(1, 'Álgebra', 'Estudo das operações e suas propriedades'),
(2, 'Trigonometria', 'Relação entre os lados e ângulos dos triângulos'),
(3, 'Geometria', 'Estudo das formas e suas propriedades'),
(4, 'Cálculo', 'Estudo das taxas de variação e acumulação'),
(5, 'Probabilidade', 'Teoria das probabilidades e estatística'),
(6, 'Funções', 'Estudo das relações entre variáveis'),
(7, 'Equações', 'Resolução de equações e inequações'),
(8, 'Mecânica', 'Estudo do movimento dos corpos'),
(9, 'Termodinâmica', 'Estudo do calor e suas transformações'),
(10, 'Óptica', 'Estudo da luz e fenômenos ópticos'),
(11, 'Eletromagnetismo', 'Estudo dos fenômenos elétricos e magnéticos'),
(12, 'Relatividade', 'Estudo da teoria da relatividade'),
(13, 'Física Quântica', 'Estudo das partículas subatômicas'),
(14, 'Acústica', 'Estudo do som e suas propriedades'),
(15, 'Química Orgânica', 'Estudo dos compostos de carbono'),
(16, 'Química Inorgânica', 'Estudo dos compostos inorgânicos'),
(17, 'Físico-Química', 'Estudo dos princípios físicos na química'),
(18, 'Bioquímica', 'Estudo das substâncias químicas em organismos vivos'),
(19, 'Eletroquímica', 'Estudo das reações químicas e eletricidade'),
(20, 'Termoquímica', 'Estudo do calor nas reações químicas'),
(21, 'Cinética Química', 'Estudo da velocidade das reações químicas'),
(22, 'Genética', 'Estudo da hereditariedade e variação dos seres vivos'),
(23, 'Ecologia', 'Estudo das relações dos organismos com o ambiente'),
(24, 'Anatomia', 'Estudo da estrutura dos seres vivos'),
(25, 'Fisiologia', 'Estudo das funções dos organismos vivos'),
(26, 'Zoologia', 'Estudo dos animais'),
(27, 'Botânica', 'Estudo das plantas'),
(28, 'Microbiologia', 'Estudo dos microrganismos'),
(29, 'História Antiga', 'Estudo das primeiras civilizações'),
(30, 'História Medieval', 'Estudo da Idade Média'),
(31, 'História Moderna', 'Estudo da Idade Moderna'),
(32, 'História Contemporânea', 'Estudo dos tempos atuais'),
(33, 'História do Brasil', 'História do Brasil desde a colonização'),
(34, 'Revoluções', 'Estudo das principais revoluções históricas'),
(35, 'História das Religiões', 'Estudo das religiões ao longo da história'),
(36, 'Geografia Física', 'Estudo das características físicas da Terra'),
(37, 'Geografia Humana', 'Estudo das relações humanas com o espaço geográfico'),
(38, 'Cartografia', 'Estudo e produção de mapas'),
(39, 'Biomas', 'Estudo das regiões ecológicas do planeta'),
(40, 'Climatologia', 'Estudo do clima e sua influência'),
(41, 'Geopolítica', 'Estudo das relações políticas no espaço mundial'),
(42, 'Geografia Urbana', 'Estudo das cidades e do espaço urbano'),
(43, 'Gramática', 'Estudo das regras gramaticais em inglês'),
(44, 'Conversação', 'Prática de fala e conversação'),
(45, 'Vocabulário', 'Expansão do vocabulário em inglês'),
(46, 'Leitura', 'Prática de leitura e interpretação de textos'),
(47, 'Escrita', 'Desenvolvimento de habilidades de escrita'),
(48, 'Pronúncia', 'Estudo da pronúncia correta das palavras'),
(49, 'Inglês para Negócios', 'Estudo do inglês aplicado ao ambiente de negócios'),
(50, 'Gramática', 'Estudo das regras gramaticais em português'),
(51, 'Literatura', 'Análise de obras literárias em português'),
(52, 'Redação', 'Prática de escrita e composição de textos'),
(53, 'Ortografia', 'Estudo da ortografia correta das palavras'),
(54, 'Interpretação de Texto', 'Prática de interpretação de textos'),
(55, 'Semântica', 'Estudo do significado das palavras'),
(56, 'Fonética', 'Estudo dos sons da língua portuguesa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `conteudoagendamento`
--

DROP TABLE IF EXISTS `conteudoagendamento`;
CREATE TABLE `conteudoagendamento` (
  `IDConteudoAgendamento` int(11) NOT NULL,
  `IDConteudo` int(11) DEFAULT NULL,
  `IDAgendamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `conteudoagendamento`
--

TRUNCATE TABLE `conteudoagendamento`;
-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina`
--

DROP TABLE IF EXISTS `disciplina`;
CREATE TABLE `disciplina` (
  `IDDisciplina` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `disciplina`
--

TRUNCATE TABLE `disciplina`;
--
-- Despejando dados para a tabela `disciplina`
--

INSERT INTO `disciplina` (`IDDisciplina`, `Nome`) VALUES
(1, 'Matemática'),
(2, 'Física'),
(3, 'Química'),
(4, 'Biologia'),
(5, 'História'),
(6, 'Geografia'),
(7, 'Inglês'),
(8, 'Português');

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplinaconteudo`
--

DROP TABLE IF EXISTS `disciplinaconteudo`;
CREATE TABLE `disciplinaconteudo` (
  `IDDisciplina` int(11) NOT NULL,
  `IDConteudo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `disciplinaconteudo`
--

TRUNCATE TABLE `disciplinaconteudo`;
--
-- Despejando dados para a tabela `disciplinaconteudo`
--

INSERT INTO `disciplinaconteudo` (`IDDisciplina`, `IDConteudo`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(4, 22),
(4, 23),
(4, 26),
(4, 27),
(4, 28),
(5, 29),
(5, 30),
(5, 31),
(5, 32),
(5, 33),
(6, 36),
(6, 37),
(6, 38),
(6, 40),
(6, 41),
(7, 43),
(7, 44),
(7, 45),
(7, 46),
(7, 50),
(7, 52),
(8, 43),
(8, 50),
(8, 51),
(8, 52),
(8, 53),
(8, 54);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disponibilidade`
--

DROP TABLE IF EXISTS `disponibilidade`;
CREATE TABLE `disponibilidade` (
  `IDDisponibilidade` int(11) NOT NULL,
  `DiaSemana` varchar(10) DEFAULT NULL,
  `HorarioInicio` time DEFAULT NULL,
  `HorarioFim` time DEFAULT NULL,
  `IDProfessor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `disponibilidade`
--

TRUNCATE TABLE `disponibilidade`;
--
-- Despejando dados para a tabela `disponibilidade`
--

INSERT INTO `disponibilidade` (`IDDisponibilidade`, `DiaSemana`, `HorarioInicio`, `HorarioFim`, `IDProfessor`) VALUES
(1, 'Segunda', NULL, NULL, 1),
(2, 'Quarta', NULL, NULL, 1),
(3, 'Sexta', NULL, NULL, 1),
(4, 'Terça', NULL, NULL, 2),
(5, 'Quinta', NULL, NULL, 2),
(6, 'Segunda', NULL, NULL, 3),
(7, 'Terça', NULL, NULL, 3),
(8, 'Quarta', NULL, NULL, 4),
(9, 'Quinta', NULL, NULL, 4),
(10, 'Sexta', NULL, NULL, 5),
(11, 'Segunda', NULL, NULL, 6),
(12, 'Quarta', NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

DROP TABLE IF EXISTS `pagamento`;
CREATE TABLE `pagamento` (
  `IDPagamento` int(11) NOT NULL,
  `ValorTotal` decimal(10,2) NOT NULL,
  `DataPgto` date NOT NULL,
  `StatusPgto` varchar(50) DEFAULT NULL,
  `FormaPgto` varchar(50) DEFAULT NULL,
  `IDAluno` int(11) DEFAULT NULL,
  `IDProfessor` int(11) DEFAULT NULL,
  `IDAgendamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `pagamento`
--

TRUNCATE TABLE `pagamento`;
-- --------------------------------------------------------

--
-- Estrutura para tabela `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
CREATE TABLE `pessoa` (
  `CPF` varchar(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `Telefone` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Senha` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `pessoa`
--

TRUNCATE TABLE `pessoa`;
-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

DROP TABLE IF EXISTS `professor`;
CREATE TABLE `professor` (
  `IDProfessor` int(11) NOT NULL,
  `CPF` varchar(11) DEFAULT NULL,
  `AulaOnline` tinyint(1) DEFAULT 0,
  `Localidade` varchar(100) DEFAULT NULL,
  `HorarioInicio` time NOT NULL,
  `HorarioFim` time NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `PrecoHora` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `professor`
--

TRUNCATE TABLE `professor`;
--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`IDProfessor`, `CPF`, `AulaOnline`, `Localidade`, `HorarioInicio`, `HorarioFim`, `Nome`, `PrecoHora`) VALUES
(1, NULL, 1, 'São Paulo', '08:00:00', '12:00:00', 'Carlos Silva', 50.00),
(2, NULL, 0, 'Rio de Janeiro', '10:00:00', '14:00:00', 'Maria Oliveira', 40.00),
(3, NULL, 1, 'São Paulo', '09:00:00', '13:00:00', 'Pedro Santos', 60.00),
(4, NULL, 0, 'Curitiba', '14:00:00', '18:00:00', 'Joana Souza', 35.00),
(5, NULL, 1, 'Porto Alegre', '08:30:00', '12:30:00', 'Lucas Lima', 55.00),
(6, NULL, 1, 'Belo Horizonte', '13:00:00', '17:00:00', 'Ana Costa', 45.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `professordisciplina`
--

DROP TABLE IF EXISTS `professordisciplina`;
CREATE TABLE `professordisciplina` (
  `IDProfessor` int(11) NOT NULL,
  `IDDisciplina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `professordisciplina`
--

TRUNCATE TABLE `professordisciplina`;
--
-- Despejando dados para a tabela `professordisciplina`
--

INSERT INTO `professordisciplina` (`IDProfessor`, `IDDisciplina`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `professordisponibilidade`
--

DROP TABLE IF EXISTS `professordisponibilidade`;
CREATE TABLE `professordisponibilidade` (
  `IDProfessor` int(11) NOT NULL,
  `IDDisponibilidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tabela truncada antes do insert `professordisponibilidade`
--

TRUNCATE TABLE `professordisponibilidade`;
--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`IDAgendamento`),
  ADD KEY `IDProfessor` (`IDProfessor`),
  ADD KEY `IDAluno` (`IDAluno`),
  ADD KEY `IDDisciplina` (`IDDisciplina`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`IDAluno`),
  ADD KEY `CPF` (`CPF`);

--
-- Índices de tabela `conteudo`
--
ALTER TABLE `conteudo`
  ADD PRIMARY KEY (`IDConteudo`);

--
-- Índices de tabela `conteudoagendamento`
--
ALTER TABLE `conteudoagendamento`
  ADD PRIMARY KEY (`IDConteudoAgendamento`),
  ADD KEY `IDConteudo` (`IDConteudo`),
  ADD KEY `IDAgendamento` (`IDAgendamento`);

--
-- Índices de tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`IDDisciplina`);

--
-- Índices de tabela `disciplinaconteudo`
--
ALTER TABLE `disciplinaconteudo`
  ADD PRIMARY KEY (`IDDisciplina`,`IDConteudo`),
  ADD KEY `IDConteudo` (`IDConteudo`);

--
-- Índices de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD PRIMARY KEY (`IDDisponibilidade`),
  ADD KEY `FK_ProfessorDisponibilidade` (`IDProfessor`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`IDPagamento`),
  ADD KEY `IDAluno` (`IDAluno`),
  ADD KEY `IDProfessor` (`IDProfessor`),
  ADD KEY `IDAgendamento` (`IDAgendamento`);

--
-- Índices de tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`CPF`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`IDProfessor`),
  ADD KEY `CPF` (`CPF`);

--
-- Índices de tabela `professordisciplina`
--
ALTER TABLE `professordisciplina`
  ADD PRIMARY KEY (`IDProfessor`,`IDDisciplina`),
  ADD KEY `IDDisciplina` (`IDDisciplina`);

--
-- Índices de tabela `professordisponibilidade`
--
ALTER TABLE `professordisponibilidade`
  ADD PRIMARY KEY (`IDProfessor`,`IDDisponibilidade`),
  ADD KEY `IDDisponibilidade` (`IDDisponibilidade`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `IDAgendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `IDAluno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conteudo`
--
ALTER TABLE `conteudo`
  MODIFY `IDConteudo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `conteudoagendamento`
--
ALTER TABLE `conteudoagendamento`
  MODIFY `IDConteudoAgendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `IDDisciplina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `disponibilidade`
--
ALTER TABLE `disponibilidade`
  MODIFY `IDDisponibilidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `IDPagamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `IDProfessor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamento`
--
ALTER TABLE `agendamento`
  ADD CONSTRAINT `agendamento_ibfk_1` FOREIGN KEY (`IDProfessor`) REFERENCES `professor` (`IDProfessor`),
  ADD CONSTRAINT `agendamento_ibfk_2` FOREIGN KEY (`IDAluno`) REFERENCES `aluno` (`IDAluno`),
  ADD CONSTRAINT `agendamento_ibfk_3` FOREIGN KEY (`IDDisciplina`) REFERENCES `disciplina` (`IDDisciplina`);

--
-- Restrições para tabelas `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`CPF`) REFERENCES `pessoa` (`CPF`);

--
-- Restrições para tabelas `conteudoagendamento`
--
ALTER TABLE `conteudoagendamento`
  ADD CONSTRAINT `conteudoagendamento_ibfk_1` FOREIGN KEY (`IDConteudo`) REFERENCES `conteudo` (`IDConteudo`),
  ADD CONSTRAINT `conteudoagendamento_ibfk_2` FOREIGN KEY (`IDAgendamento`) REFERENCES `agendamento` (`IDAgendamento`);

--
-- Restrições para tabelas `disciplinaconteudo`
--
ALTER TABLE `disciplinaconteudo`
  ADD CONSTRAINT `disciplinaconteudo_ibfk_1` FOREIGN KEY (`IDDisciplina`) REFERENCES `disciplina` (`IDDisciplina`),
  ADD CONSTRAINT `disciplinaconteudo_ibfk_2` FOREIGN KEY (`IDConteudo`) REFERENCES `conteudo` (`IDConteudo`);

--
-- Restrições para tabelas `disponibilidade`
--
ALTER TABLE `disponibilidade`
  ADD CONSTRAINT `FK_ProfessorDisponibilidade` FOREIGN KEY (`IDProfessor`) REFERENCES `professor` (`IDProfessor`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `pagamento_ibfk_1` FOREIGN KEY (`IDAluno`) REFERENCES `aluno` (`IDAluno`),
  ADD CONSTRAINT `pagamento_ibfk_2` FOREIGN KEY (`IDProfessor`) REFERENCES `professor` (`IDProfessor`),
  ADD CONSTRAINT `pagamento_ibfk_3` FOREIGN KEY (`IDAgendamento`) REFERENCES `agendamento` (`IDAgendamento`);

--
-- Restrições para tabelas `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`CPF`) REFERENCES `pessoa` (`CPF`);

--
-- Restrições para tabelas `professordisciplina`
--
ALTER TABLE `professordisciplina`
  ADD CONSTRAINT `professordisciplina_ibfk_1` FOREIGN KEY (`IDProfessor`) REFERENCES `professor` (`IDProfessor`),
  ADD CONSTRAINT `professordisciplina_ibfk_2` FOREIGN KEY (`IDDisciplina`) REFERENCES `disciplina` (`IDDisciplina`);

--
-- Restrições para tabelas `professordisponibilidade`
--
ALTER TABLE `professordisponibilidade`
  ADD CONSTRAINT `professordisponibilidade_ibfk_1` FOREIGN KEY (`IDProfessor`) REFERENCES `professor` (`IDProfessor`),
  ADD CONSTRAINT `professordisponibilidade_ibfk_2` FOREIGN KEY (`IDDisponibilidade`) REFERENCES `disponibilidade` (`IDDisponibilidade`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
