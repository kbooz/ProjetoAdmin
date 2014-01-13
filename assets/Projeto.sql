create table user_grupo (
	id int NOT NULL AUTO_INCREMENT primary key,
	nome varchar(20) not null	
);


CREATE TABLE user (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user varchar(32) NOT NULL,
  senha varchar(32) NOT NULL,
  status tinyint(1) NOT NULL,
  grupo int not null,
  foreign key (grupo) references user_grupo (id)
);


create table pessoa_funcao
(
	id int auto_increment not null primary key,
	nome varchar(100) not null
);

create table pessoa
(
	id int auto_increment not null primary key,
	nome varchar(150) not null,
	apelidofantasia varchar(150),
	nascimentofundacao date not null,
	telefone varchar(20),
	site varchar(20),
	funcao int not null,
	foreign key (funcao) references pessoa_funcao (id),
	rginsc varchar(150) not null,
	cpfcnpj varchar(150) not null,
	equipe boolean not null,
	endereco varchar(200) not null,
	complemento varchar(200) not null,
	bairro varchar(150) not null,
	cidade varchar(150) not null,
	uf varchar(150) not null,
	cep varchar(20) not null,
	obs text,
	banco varchar(20),
	agencia varchar(20),
	conta varchar(100),
	tipodeconta varchar(20),
	enderecoconta varchar(150),
	complementoconta varchar(200),
	bairroconta varchar(150),
	cidadeconta varchar(150),
	ufconta varchar(150),
	cepconta varchar(20),
	valorpadrao real
);


create table equipamento_tipo
(
	id int auto_increment not null primary key,
	nome varchar (150) not null
);

create table equipamento
(
	id int auto_increment not null primary key,
	nome varchar(300) not null,
	tipo int not null,
	foreign key (tipo) references equipamento_tipo(id),
	valor real,
	aluguel real,
	proprio boolean default 0,
	dataentrada date,
	datasaida date,
	obs text
);

create table orcamento
(
	id int auto_increment not null primary key,
	nome varchar(200) not null,
	idCliente int not null,
	foreign key (idCliente) references pessoa(id),
	valor real,
	lucro real,
	dataentrada date not null,
	datasaida date,
	obs text,
	despesa int
);

create table orcamento_despesa
(
	id int auto_increment not null,
	idOrcamento int not null,
	foreign key (idOrcamento) references orcamento (id),
	primary key (id,idOrcamento),
	nome varchar(150),
	dataentrada date not null,
	datasaida date not null,
	valor real
);

create table orcamento_funcionario
(
	idOrcamento int not null,
	foreign key (idOrcamento) references orcamento (id),
	idPessoa int not null,
	foreign key (idPessoa) references pessoa (id),
	primary key (idPessoa,idOrcamento),
	dataentrada date not null,
	datasaida date not null,
	valordiaria real not null
);

create table orcamento_equipamento
(
	idOrcamento int not null,
	foreign key (idOrcamento) references orcamento (id),
	idEquipamento int not null,
	foreign key (idEquipamento) references equipamento (id),
	primary key (idEquipamento,idOrcamento),
	dataentrada date not null,
	datasaida date not null,
	valordiaria real not null
);

INSERT INTO orcamento ( `nome`, `idCliente`, `valor`, `dataentrada`, `datasaida`, `obs`, `despesa`) VALUES
('Filmagem tal', 2, 900, '2013-12-03', '2013-12-26', NULL, 700);

Insert into pessoa_funcao ('id','nome')
(1,'Cliente')