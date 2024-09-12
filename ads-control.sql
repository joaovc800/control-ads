-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12/09/2024 às 13:56
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ads-control`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `header` int(11) NOT NULL,
  `campaign` varchar(255) NOT NULL,
  `group_campaign` varchar(255) NOT NULL,
  `budget` decimal(10,2) NOT NULL,
  `typecampaign` varchar(255) NOT NULL,
  `initialcpc` decimal(10,2) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `conversiongoal` varchar(255) NOT NULL,
  `initialdate` date NOT NULL,
  `urlnotutm` varchar(255) NOT NULL,
  `listkeywords` text DEFAULT NULL,
  `wordsnotused` text DEFAULT NULL,
  `ctaheadline1` varchar(255) NOT NULL,
  `utmcampaign` varchar(255) NOT NULL,
  `utmmedium` varchar(255) NOT NULL,
  `utmsource` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `prefixsitelink` varchar(255) NOT NULL,
  `csv_campaigns` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `campaigns_header`
--

CREATE TABLE `campaigns_header` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `file_path` varchar(255) NOT NULL,
  `file_text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'teste@teste.com', '202cb962ac59075b964b07152d234b70', '2024-09-09 10:52:58');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaignsxheader` (`header`);

--
-- Índices de tabela `campaigns_header`
--
ALTER TABLE `campaigns_header`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `campaigns_header`
--
ALTER TABLE `campaigns_header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaignsxheader` FOREIGN KEY (`header`) REFERENCES `campaigns_header` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
