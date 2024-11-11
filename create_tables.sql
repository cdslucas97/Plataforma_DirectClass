CREATE DATABASE IF NOT EXISTS directclass;
USE directclass;

CREATE TABLE IF NOT EXISTS Pessoa (
    CPF CHAR(11) PRIMARY KEY,
    Username VARCHAR(30),
    Nome VARCHAR(100) NOT NULL,
    Telefone VARCHAR(15),
    Email VARCHAR(100),
    Senha VARCHAR(100),
    Endereco VARCHAR(50),
    TipoUsuario ENUM('aluno', 'professor', 'admin')
);

CREATE TABLE IF NOT EXISTS Aluno (
    IDAluno INT AUTO_INCREMENT PRIMARY KEY,
    CPF VARCHAR(11),
    FOREIGN KEY (CPF) REFERENCES Pessoa(CPF)
);

CREATE TABLE IF NOT EXISTS Professor (
    IDProfessor INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(255),
    HorarioInicio TIME,
    HorarioFim TIME,
    PrecoHora DECIMAL(10, 2),
    Localidade VARCHAR(255),
    AulaOnline ENUM('Sim', 'Não'),
    DisciplinaID INT,
    CPF VARCHAR(11),
    FOREIGN KEY (CPF) REFERENCES Pessoa(CPF)
);

CREATE TABLE IF NOT EXISTS Disponibilidade (
    IDDisponibilidade INT AUTO_INCREMENT PRIMARY KEY,
    DiaSemana VARCHAR(10),
    HorarioInicio TIME,
    HorarioFim TIME
);

CREATE TABLE IF NOT EXISTS ProfessorDisponibilidade (
    IDProfessor INT,
    IDDisponibilidade INT,
    PRIMARY KEY (IDProfessor, IDDisponibilidade),
    FOREIGN KEY (IDProfessor) REFERENCES Professor(IDProfessor),
    FOREIGN KEY (IDDisponibilidade) REFERENCES Disponibilidade(IDDisponibilidade)
);

CREATE TABLE IF NOT EXISTS Disciplina (
    IDDisciplina INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS Conteudo (
    IDConteudo INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Descricao TEXT
);

CREATE TABLE IF NOT EXISTS DisciplinaConteudo (
    IDDisciplina INT,
    IDConteudo INT,
    PRIMARY KEY (IDDisciplina, IDConteudo),
    FOREIGN KEY (IDDisciplina) REFERENCES Disciplina(IDDisciplina),
    FOREIGN KEY (IDConteudo) REFERENCES Conteudo(IDConteudo)
);

CREATE TABLE IF NOT EXISTS ProfessorDisciplina (
    IDProfessor INT,
    IDDisciplina INT,
    PRIMARY KEY (IDProfessor, IDDisciplina),
    FOREIGN KEY (IDProfessor) REFERENCES Professor(IDProfessor),
    FOREIGN KEY (IDDisciplina) REFERENCES Disciplina(IDDisciplina)
);

CREATE TABLE IF NOT EXISTS Agendamento (
    IDAgendamento INT AUTO_INCREMENT PRIMARY KEY,
    Data DATE NOT NULL,
    Hora TIME NOT NULL,
    ValorHora DECIMAL(10, 2),
    Justificativa TEXT,
    Presenca BOOLEAN,
    IDProfessor INT,
    IDAluno INT,
    IDDisciplina INT,
    URL VARCHAR(255),
    Local VARCHAR(255),
    FOREIGN KEY (IDProfessor) REFERENCES Professor(IDProfessor),
    FOREIGN KEY (IDAluno) REFERENCES Aluno(IDAluno),
    FOREIGN KEY (IDDisciplina) REFERENCES Disciplina(IDDisciplina)
);

CREATE TABLE IF NOT EXISTS ConteudoAgendamento (
    IDConteudoAgendamento INT AUTO_INCREMENT PRIMARY KEY,
    IDConteudo INT,
    IDAgendamento INT,
    FOREIGN KEY (IDConteudo) REFERENCES Conteudo(IDConteudo),
    FOREIGN KEY (IDAgendamento) REFERENCES Agendamento(IDAgendamento)
);

CREATE TABLE IF NOT EXISTS Pagamento (
    IDPagamento INT AUTO_INCREMENT PRIMARY KEY,
    ValorTotal DECIMAL(10, 2) NOT NULL,
    DataPgto DATE NOT NULL,
    StatusPgto VARCHAR(50),
    FormaPgto VARCHAR(50),
    IDAluno INT,
    IDProfessor INT,
    IDAgendamento INT,
    FOREIGN KEY (IDAluno) REFERENCES Aluno(IDAluno),
    FOREIGN KEY (IDProfessor) REFERENCES Professor(IDProfessor),
    FOREIGN KEY (IDAgendamento) REFERENCES Agendamento(IDAgendamento)
);