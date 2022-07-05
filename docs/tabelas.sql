CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `login` varchar(45) NOT NULL,
  `senha` varchar(80) NOT NULL,
  `nivel` tinyint(1) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `unidades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `endereco` varchar(80) DEFAULT NULL,
  `complemento` varchar(80) DEFAULT NULL,
  `municipio` varchar(60) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `endereco` varchar(60) DEFAULT NULL,
  `complemento` varchar(60) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `municipio` varchar(60) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `responsavel` varchar(60) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `enviar_email` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='O campo status poderá ser: 0 - Ativo, 1 - Inativo, 2 - Bloqueado (todos os visitantes dessa empresa não poderão entrar)';


CREATE TABLE `visitantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `empresa_id` int DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `observacoes` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_visitante_empresa_id_idx` (`empresa_id`),
  CONSTRAINT `fk_visitante_empresa_id` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='O campo status do visitante poderá ser: 0 - Ativo, 1 - Inativo, 2 - Requer conferência, 3 - Bloqueado para visitas';


CREATE TABLE `crachas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `identificacao` varchar(40) NOT NULL,
  `unidade_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `movimentacao_id` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_unidade_id_idx` (`unidade_id`),
  CONSTRAINT `fk_cracha_unidade_id` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `portarias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL,
  `unidade_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `tipo_passagem` tinyint(1) DEFAULT NULL COMMENT '1 - Pessoas e veículos, 2 - Pessoas apenas, 3 - Veículos apenas',
  PRIMARY KEY (`id`),
  KEY `fk_portaria_unidade_id_idx` (`unidade_id`),
  CONSTRAINT `fk_portaria_unidade_id` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='O campo status desse cadastro refere-se à portaria que pode estar em reformas ou não funcionando mais. 0 - Ativo, 1 - Inativo';


CREATE TABLE `logins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_id` int NOT NULL,
  `portaria_id` int NOT NULL,
  `data_entrada` date NOT NULL,
  `hora_entrada` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_login_usuario_id_idx` (`usuario_id`),
  KEY `fk_login_portaria_id_idx` (`portaria_id`),
  CONSTRAINT `fk_login_portaria_id` FOREIGN KEY (`portaria_id`) REFERENCES `portarias` (`id`),
  CONSTRAINT `fk_login_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `movimentacoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `visitante_id` int DEFAULT NULL,
  `cracha_id` int DEFAULT NULL,
  `placa` varchar(7) DEFAULT NULL,
  `usuario_entrada_id` int DEFAULT NULL,
  `data_entrada` date DEFAULT NULL,
  `hora_entrada` time DEFAULT NULL,
  `portaria_entrada_id` int DEFAULT NULL,
  `usuario_saida_id` int DEFAULT NULL,
  `data_saida` date DEFAULT NULL,
  `hora_saida` time DEFAULT NULL,
  `portaria_saida_id` int DEFAULT NULL,
  `contato` varchar(45) DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `observacoes` varchar(200) DEFAULT NULL,
  `status` int DEFAULT '0' COMMENT '0 - Em aberto, 1 - Finalizado, 2 - Cancelado',
  `cancelamento` varchar(200) DEFAULT NULL,
  `unidade_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movimentacoes_visitante_id_idx` (`visitante_id`),
  KEY `fk_movimentacoes_cracha_id_idx` (`cracha_id`),
  KEY `fk_mov_portaria_entrada_id_idx` (`portaria_entrada_id`),
  KEY `fk_mov_usuario_entrada_id_idx` (`usuario_entrada_id`),
  KEY `fk_mov_usuario_saida_id_idx` (`usuario_saida_id`),
  KEY `fk_mov_portaria_saida_id_idx` (`portaria_saida_id`),
  KEY `fk_mov_unidade_id_idx` (`unidade_id`),
  CONSTRAINT `fk_mov_cracha_id` FOREIGN KEY (`cracha_id`) REFERENCES `crachas` (`id`),
  CONSTRAINT `fk_mov_portaria_entrada_id` FOREIGN KEY (`portaria_entrada_id`) REFERENCES `portarias` (`id`),
  CONSTRAINT `fk_mov_portaria_saida_id` FOREIGN KEY (`portaria_saida_id`) REFERENCES `portarias` (`id`),
  CONSTRAINT `fk_mov_unidade_id` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`),
  CONSTRAINT `fk_mov_usuario_entrada_id` FOREIGN KEY (`usuario_entrada_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_mov_usuario_saida_id` FOREIGN KEY (`usuario_saida_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `fk_mov_visitante_id` FOREIGN KEY (`visitante_id`) REFERENCES `visitantes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `acompanhantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `movimentacao_id` int DEFAULT NULL,
  `nome` varchar(60) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `observacoes` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_acompanhante_movimentacoes_id_idx` (`movimentacao_id`),
  CONSTRAINT `fk_acompanhante_movimentacoes_id` FOREIGN KEY (`movimentacao_id`) REFERENCES `movimentacoes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Quem está acompanhando o visitante na hora da entrada';


CREATE TABLE `parametros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unidade_id` int DEFAULT NULL COMMENT 'ID da unidade parametrizada',
  `limite_acompanhantes` int DEFAULT NULL COMMENT 'Número máximo de acompanhantes (0 - não pode ter acompanhante, registrar um por um)',
  `limitar_hora_entrada` tinyint(1) DEFAULT NULL COMMENT 'Vai limitar o horário de início das visitas?',
  `limite_horario_entrada` time DEFAULT NULL COMMENT 'Horário inicial para liberar as visitas',
  `limitar_hora_saida` tinyint(1) DEFAULT NULL COMMENT 'Vai limitar o horário de saída das visitas?',
  `limite_horario_saida` time DEFAULT NULL COMMENT 'Horário final para registrar as saídas',
  `motivo_obrigatorio` tinyint(1) DEFAULT NULL COMMENT 'Obrigatório informar o motivo da visita',
  PRIMARY KEY (`id`),
  KEY `fk_par_unidade_id_idx` (`unidade_id`),
  CONSTRAINT `fk_par_unidade_id` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `portaria_db`.`usuarios`
(`nome`, `login`, `senha`, `nivel`, `status`)
VALUES
('Administrador', 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0);