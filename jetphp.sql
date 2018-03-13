-- JetPHP
-- Apague este arquivo após salvar o banco de dados
--
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jetphp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador_nivel`
--

CREATE TABLE `administrador_nivel` (
  `id` int(10) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `administrador_nivel`
--

INSERT INTO `administrador_nivel` (`id`, `nome`, `comentario`) VALUES
(1, 'Desenvolvedor', 'Tem acesso ao sistema inteiro'),
(2, 'Administrador', 'Tem acesso à quase tudo do sistema, exceto gerenciar as seções'),
(3, 'Editor', 'Pode editar e publicar produtos/categorias');

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador_secao`
--

CREATE TABLE `administrador_secao` (
  `id` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pagina` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `controle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `administrador_secao`
--

INSERT INTO `administrador_secao` (`id`, `nivel`, `nome`, `pagina`, `controle`, `icone`, `ordem`) VALUES
(1, 1, 'Seções', 'secao', 'FormSistemaSecao', 'fa-list', 98),
(5, 2, 'Textos', 'textos', 'FormSistemaTextos', 'fa-font', 1),
(6, 3, 'Início', 'home', 'FormSistemaHome', 'fa-home', 0),
(7, 3, 'Sair do sistema', 'sair', 'FormSistemaSair', 'fa-sign-out', 99),
(9, 2, 'Usuários', 'usuarios', 'FormSistemaUsuarios', 'fa fa-user', 97);

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador_usuarios`
--

CREATE TABLE `administrador_usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL COMMENT 'tabela administrador_nivel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `administrador_usuarios`
--

INSERT INTO `administrador_usuarios` (`id`, `nome`, `usuario`, `email`, `senha`, `ativo`, `nivel`) VALUES
(1, 'Administrador', 'admin', 'contato@joaoartur.com', '6139d95f4d8efa8b790ce93790c7c36d', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `site_texto`
--

CREATE TABLE `site_texto` (
  `id` int(10) NOT NULL,
  `identificador` varchar(255) DEFAULT NULL,
  `conteudo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrador_nivel`
--
ALTER TABLE `administrador_nivel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrador_secao`
--
ALTER TABLE `administrador_secao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrador_usuarios`
--
ALTER TABLE `administrador_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_texto`
--
ALTER TABLE `site_texto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrador_nivel`
--
ALTER TABLE `administrador_nivel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `administrador_secao`
--
ALTER TABLE `administrador_secao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `administrador_usuarios`
--
ALTER TABLE `administrador_usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `site_texto`
--
ALTER TABLE `site_texto`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
