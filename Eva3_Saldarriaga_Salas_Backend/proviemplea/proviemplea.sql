-- phpMyAdmin SQL Dump
-- Base de datos: proviemplea
-- Plataforma: ProviEmplea - Vitrina de Talentos Providencia

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Crear base de datos
-- --------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `proviemplea` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `proviemplea`;

-- --------------------------------------------------------
-- Tabla: tbl_candidato
-- Perfil del candidato SIN datos sociodemograficos
-- (sin nombre, edad, genero ni comuna, para evitar discriminacion)
-- --------------------------------------------------------
CREATE TABLE `tbl_candidato` (
  `ID_CANDIDATO`          int(11)      NOT NULL,
  `VCH_TITULO_PERFIL`     varchar(100) NOT NULL,
  `VCH_DESCRIPCION`       varchar(500) NOT NULL,
  `INT_ANIOS_EXPERIENCIA` int(11)      NOT NULL DEFAULT 0,
  `INT_ACTIVO`            tinyint(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabla: tbl_empresa
-- Empresas que buscan candidatos en la plataforma
-- --------------------------------------------------------
CREATE TABLE `tbl_empresa` (
  `ID_EMPRESA`        int(11)      NOT NULL,
  `VCH_NOMBRE_EMPRESA` varchar(100) NOT NULL,
  `VCH_RUBRO`         varchar(100) NOT NULL,
  `VCH_DESCRIPCION`   varchar(300) NOT NULL,
  `INT_ACTIVO`        tinyint(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Tabla: tbl_habilidad
-- Catalogo de habilidades disponibles en la plataforma
-- --------------------------------------------------------
CREATE TABLE `tbl_habilidad` (
  `ID_HABILIDAD`        int(11)     NOT NULL,
  `VCH_NOMBRE_HABILIDAD` varchar(100) NOT NULL,
  `VCH_CATEGORIA`        varchar(50)  NOT NULL,
  `INT_ACTIVO`           tinyint(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Indices y claves primarias
-- --------------------------------------------------------
ALTER TABLE `tbl_candidato`
  ADD PRIMARY KEY (`ID_CANDIDATO`);

ALTER TABLE `tbl_empresa`
  ADD PRIMARY KEY (`ID_EMPRESA`);

ALTER TABLE `tbl_habilidad`
  ADD PRIMARY KEY (`ID_HABILIDAD`);

-- --------------------------------------------------------
-- AUTO_INCREMENT
-- --------------------------------------------------------
ALTER TABLE `tbl_candidato`
  MODIFY `ID_CANDIDATO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_empresa`
  MODIFY `ID_EMPRESA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tbl_habilidad`
  MODIFY `ID_HABILIDAD` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- --------------------------------------------------------
-- Datos de ejemplo para pruebas
-- --------------------------------------------------------
INSERT INTO `tbl_candidato` (`VCH_TITULO_PERFIL`, `VCH_DESCRIPCION`, `INT_ANIOS_EXPERIENCIA`, `INT_ACTIVO`) VALUES
('Tecnico en Informatica', 'Experiencia en soporte tecnico, redes y desarrollo web basico', 3, 1),
('Contador Auditor', 'Manejo de Excel avanzado, contabilidad general y tributaria', 5, 1),
('Disenador Grafico', 'Dominio de Adobe Illustrator, Photoshop y Figma para proyectos digitales', 2, 1);

INSERT INTO `tbl_empresa` (`VCH_NOMBRE_EMPRESA`, `VCH_RUBRO`, `VCH_DESCRIPCION`, `INT_ACTIVO`) VALUES
('TechCorp SPA', 'Tecnologia', 'Empresa de desarrollo de software y consultoria TI', 1),
('Contadores Asociados', 'Finanzas', 'Firma contable con mas de 10 anos en el mercado', 1),
('Estudio Creativo', 'Marketing', 'Agencia de diseno y comunicacion visual', 1);

INSERT INTO `tbl_habilidad` (`VCH_NOMBRE_HABILIDAD`, `VCH_CATEGORIA`, `INT_ACTIVO`) VALUES
('PHP', 'Tecnica', 1),
('MySQL', 'Tecnica', 1),
('Trabajo en equipo', 'Blanda', 1),
('Comunicacion efectiva', 'Blanda', 1),
('Excel Avanzado', 'Tecnica', 1);

COMMIT;
