-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2018 a las 16:12:39
-- Versión del servidor: 10.1.33-MariaDB
-- Versión de PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kurewenc_db_portia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_archivo`
--

CREATE TABLE `tbl_archivo` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `contenido` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_curso`
--

CREATE TABLE `tbl_curso` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `curso` varchar(45) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_curso`
--

INSERT INTO `tbl_curso` (`id`, `id_post`, `rut`, `curso`, `fecha`) VALUES
(2, 'Pte2018761313540', '15.722.353-4', 'Marketing Digital', '11-12-17'),
(3, 'Pte20187265545902', '13252311-8', 'Curso1', '12/12/2015'),
(4, 'Pte2018814151334', '13252311-8', 'Curso1', '12/12/2015'),
(5, 'Pte2018814151334', '13252311-8', 'Curso2', '12/12/2015'),
(6, 'Pte2018814151334', '13252311-8', 'Curso3', '12/12/2015');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_datos_postulacion_abierta`
--

CREATE TABLE `tbl_datos_postulacion_abierta` (
  `id` int(11) NOT NULL,
  `num` varchar(2) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `categoria` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_datos_postulacion_abierta`
--

INSERT INTO `tbl_datos_postulacion_abierta` (`id`, `num`, `id_post`, `rut`, `nombre`, `categoria`) VALUES
(4, '1', 'Pte2018761313540', '15.722.353-4', 'Reponedor supermercados', 'retail'),
(5, '12', 'Pte2018719032924', '16.282.161-k', 'Asistente de calidad', 'Administrativo'),
(6, '13', 'Pte2018719032924', '16.282.161-k', 'Asistente contable', 'Administrativo'),
(7, '1', 'Pte20187265545902', '13252311-8', 'Reponedor supermercados', 'retail'),
(8, '4', 'Pte20187265545902', '13252311-8', 'Promotor (a) supermercados', 'retail'),
(9, '6', 'Pte20187265545902', '13252311-8', 'vendedor de tangibles', 'retail'),
(10, '11', 'Pte20187265545902', '13252311-8', 'Digitador', 'Administrativo'),
(11, '1', 'Pte2018814151334', '13252311-8', 'Reponedor supermercados', 'retail'),
(12, '11', 'Pte2018814151334', '13252311-8', 'Digitador', 'Administrativo'),
(13, '27', 'Pte2018814151334', '13252311-8', 'Conductor grua horquilla', 'Industrial'),
(14, '44', 'Pte2018814151334', '13252311-8', 'Conductor licencia A3', 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_documento`
--

CREATE TABLE `tbl_documento` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `cv` int(11) DEFAULT NULL,
  `antecedentes` int(11) DEFAULT NULL,
  `carnet` int(11) DEFAULT NULL,
  `fotografia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_documento`
--

INSERT INTO `tbl_documento` (`id`, `id_post`, `rut`, `cv`, `antecedentes`, `carnet`, `fotografia`) VALUES
(3, 'Pte2018761313540', '15.722.353-4', NULL, NULL, NULL, NULL),
(4, 'Pte2018719032924', '16.282.161-k', NULL, NULL, NULL, NULL),
(5, 'Pte20187265545902', '', NULL, NULL, NULL, NULL),
(6, 'Pte20187265545902', '13252311-8', NULL, NULL, NULL, NULL),
(7, 'Pte2018814151334', '13252311-8', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estudio`
--

CREATE TABLE `tbl_estudio` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `tipo_estudio` varchar(45) DEFAULT NULL,
  `titulo` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `fecha_titulacion` varchar(45) DEFAULT NULL,
  `semestres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_estudio`
--

INSERT INTO `tbl_estudio` (`id`, `id_post`, `rut`, `tipo_estudio`, `titulo`, `estado`, `fecha_titulacion`, `semestres`) VALUES
(3, 'Pte2018761313540', '15.722.353-4', 'Universitario', 'ingeniero en InformÃ¡tica', 'Graduado', '01-03-16', 0),
(4, 'Pte2018719032924', '16.282.161-k', 'Secundario', '', 'En Curso', '', 0),
(5, 'Pte20187265545902', '13252311-8', 'Universitario', 'Ingeniero Civil en Computacion', 'Graduado', '2000', 10),
(6, 'Pte20187265545902', '13252311-8', 'Universitario', 'Ingeniero Civil en ComputaciÃ³n', 'Graduado', '2000', 0),
(7, 'Pte2018814151334', '13252311-8', 'Universitario', 'Ingeniero Civil en ComputaciÃ³n', 'Graduado', '2000', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_experiencia_laboral`
--

CREATE TABLE `tbl_experiencia_laboral` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `empresa` varchar(45) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `fecha_desde` varchar(45) DEFAULT NULL,
  `fecha_hasta` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_experiencia_laboral`
--

INSERT INTO `tbl_experiencia_laboral` (`id`, `id_post`, `rut`, `empresa`, `cargo`, `fecha_desde`, `fecha_hasta`) VALUES
(2, 'Pte2018761313540', '15.722.353-4', 'Consultora 4p', 'CEO', '01-12-14', '01-07-18'),
(3, 'Pte2018814151334', '13252311-8', 'Empresa1', 'Cargo1', '12/2015', '12/2015'),
(4, 'Pte2018814151334', '13252311-8', 'Empresa2', 'Cargo2', '12/2016', '11/2017'),
(5, 'Pte2018814151334', '13252311-8', 'Empresa3', 'Cargo3', '12/2017', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_horario_trabajo`
--

CREATE TABLE `tbl_horario_trabajo` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `dias` varchar(60) DEFAULT NULL,
  `horarios` varchar(45) DEFAULT NULL,
  `comunas` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_horario_trabajo`
--

INSERT INTO `tbl_horario_trabajo` (`id`, `id_post`, `rut`, `dias`, `horarios`, `comunas`) VALUES
(3, 'Pte2018761313540', '15.722.353-4', 'Lunes, Miercoles, Viernes, ', '8:00 a 19:00', ''),
(4, 'Pte2018761313540', '15.722.353-4', 'Martes, Viernes, ', '10:00 a 21:00', ''),
(5, 'Pte2018719032924', '16.282.161-k', 'Lunes, Martes, Miercoles, Jueves, Viernes, Sabado, ', '2:00 a 19:00', ''),
(6, 'Pte20187265545902', '13252311-8', 'Lunes, Martes, Miercoles, Jueves, Viernes, Sabado, Domingo, ', '8:00 a 21:00', ''),
(7, 'Pte2018814151334', '13252311-8', 'Lunes, Martes, Miercoles, ', '8:00 a 19:00', ''),
(8, 'Pte2018814151334', '13252311-8', 'Sabado, ', '6:00 a 18:00', ''),
(9, 'Pte2018814151334', '13252311-8', 'Jueves, Viernes, ', '7:00 a 19:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_postulante`
--

CREATE TABLE `tbl_postulante` (
  `id_post` varchar(45) NOT NULL,
  `fecha_post` varchar(12) DEFAULT NULL,
  `estado_post` varchar(20) DEFAULT 'Sin Clasificar',
  `rut` varchar(20) NOT NULL,
  `nombres` varchar(45) DEFAULT NULL,
  `apellidop` varchar(45) DEFAULT NULL,
  `apellidom` varchar(45) DEFAULT NULL,
  `fecha_nacimiento` varchar(20) DEFAULT NULL,
  `sexo` varchar(45) DEFAULT NULL,
  `estado_civil` varchar(15) DEFAULT NULL,
  `nacionalidad` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `telefono_recado` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `provincia` varchar(45) DEFAULT NULL,
  `comuna` varchar(45) DEFAULT NULL,
  `domicilio` varchar(45) DEFAULT NULL,
  `tpolera` varchar(45) DEFAULT NULL,
  `tpantalon` varchar(45) DEFAULT NULL,
  `tpoleron` varchar(45) DEFAULT NULL,
  `tzapatos` varchar(45) DEFAULT NULL,
  `renta` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `tlicenciaconducir` varchar(10) DEFAULT NULL,
  `afp` varchar(45) DEFAULT NULL,
  `prestadorsalud` varchar(45) DEFAULT NULL,
  `experiencialaboral` varchar(2) DEFAULT NULL,
  `referencialaboral` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_postulante`
--

INSERT INTO `tbl_postulante` (`id_post`, `fecha_post`, `estado_post`, `rut`, `nombres`, `apellidop`, `apellidom`, `fecha_nacimiento`, `sexo`, `estado_civil`, `nacionalidad`, `telefono`, `telefono_recado`, `email`, `provincia`, `comuna`, `domicilio`, `tpolera`, `tpantalon`, `tpoleron`, `tzapatos`, `renta`, `tlicenciaconducir`, `afp`, `prestadorsalud`, `experiencialaboral`, `referencialaboral`) VALUES
('Pte2018719032924', '2018-07-19', 'Sin Clasificar', '16.282.161-k', 'andrea', 'suarez', 'ruiz', '31-10-88', 'femenino', 'soltero', 'venezolana', '0491407678', '', 'asuaruiz@gmail.com', 'R.M.', 'Santiago', '', 'XS', '34', 'XS', '35', '800.000 - 1.000.000', '', 'AFP Modelo', 'BanmÃ©dica', 'No', 'No'),
('Pte20187265545902', '2018-07-30', 'Sin Clasificar', '13252311-8', 'AndrÃ©s Esteban', 'MuÃ±oz', 'Ã“rdenes', '20/12/1976', 'masculino', 'casado', 'Chilena', '+56998796172', '+56992183608', 'andmunoz@gmail.com', 'RegiÃ³n Metropolitana de Santiago', 'Quilicura', 'Pasaje Belen 193', 'XL', '52', 'XL', '43', '800.000 - 1.000.000', 'Clase B', 'AFP Cuprum', 'BanmÃ©dica', 'No', 'No'),
('Pte2018761313540', '2018-07-06', 'Sin Clasificar', '15.722.353-4', 'SebastiÃ¡n', 'Morales', 'Riquelme', '01-11-83', 'masculino', 'divorciado', 'Chilena', '+56982825127', '', 'sebastianmoralesr@gmail.com', 'R.M.', 'Providencia', 'Providencia 701', 'XL', '44', 'M', '42', '275.000 - 350.000', '', 'AFP Modelo', 'Fonasa', 'Si', 'Si'),
('Pte2018814151334', '2018-08-02', 'Sin Clasificar', '13252311-8', 'AndrÃ©s Esteban', 'MuÃ±oz', 'Ã“rdenes', '20/12/1976', 'masculino', 'casado', 'Chilena', '+56998796172', '+56992183608', 'andmunoz@gmail.com', 'RegiÃ³n Metropolitana de Santiago', 'Quilicura', 'Pasaje BelÃ©n 193', 'XL', '52', 'XL', '43', '450.000 - 500.000', 'Clase B', 'AFP Cuprum', 'BanmÃ©dica', 'Si', 'Si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_referencia_laboral`
--

CREATE TABLE `tbl_referencia_laboral` (
  `id` int(11) NOT NULL,
  `id_post` varchar(45) NOT NULL,
  `rut` varchar(45) NOT NULL,
  `empresa` varchar(45) DEFAULT NULL,
  `nombre_contacto` varchar(45) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_referencia_laboral`
--

INSERT INTO `tbl_referencia_laboral` (`id`, `id_post`, `rut`, `empresa`, `nombre_contacto`, `cargo`, `telefono`, `email`) VALUES
(4, 'Pte2018761313540', '15.722.353-4', 'Cyber Center', 'Juan PÃ©rez', 'Gerente', '+56987654321', 'juan@empresa.cl'),
(5, 'Pte2018761313540', '15.722.353-4', '', '', '', '', ''),
(6, 'Pte2018761313540', '15.722.353-4', '', '', '', '', ''),
(7, 'Pte2018814151334', '13252311-8', 'Empresa1', 'Nombre1', 'Cargo1', '1234567', 'nombre1@empresa1.cl'),
(8, 'Pte2018814151334', '13252311-8', 'Empresa2', 'Nombre2', 'Cargo2', '12345678', 'nombre2@empresa2.cl'),
(9, 'Pte2018814151334', '13252311-8', 'Empresa3', 'Nombre3', 'Cargo3', '12345678', 'nombre3@empresa3.cl');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(256) NOT NULL,
  `clave` varchar(256) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`id`, `nombre`, `correo`, `clave`, `estado`) VALUES
(1, 'Usuario 1', 'curzua@portia.cl', 'portia.2018', 1),
(2, 'Usuario 2', 'drincon@portia.cl', 'portia.2018', 1),
(3, 'Usuario 3', 'aferreira@portia.cl', 'portia.2018', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_archivo`
--
ALTER TABLE `tbl_archivo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_curso`
--
ALTER TABLE `tbl_curso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_datos_postulacion_abierta`
--
ALTER TABLE `tbl_datos_postulacion_abierta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_documento`
--
ALTER TABLE `tbl_documento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_estudio`
--
ALTER TABLE `tbl_estudio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_experiencia_laboral`
--
ALTER TABLE `tbl_experiencia_laboral`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_horario_trabajo`
--
ALTER TABLE `tbl_horario_trabajo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_postulante`
--
ALTER TABLE `tbl_postulante`
  ADD PRIMARY KEY (`id_post`);

--
-- Indices de la tabla `tbl_referencia_laboral`
--
ALTER TABLE `tbl_referencia_laboral`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_archivo`
--
ALTER TABLE `tbl_archivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_curso`
--
ALTER TABLE `tbl_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tbl_datos_postulacion_abierta`
--
ALTER TABLE `tbl_datos_postulacion_abierta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tbl_documento`
--
ALTER TABLE `tbl_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_estudio`
--
ALTER TABLE `tbl_estudio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_experiencia_laboral`
--
ALTER TABLE `tbl_experiencia_laboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_horario_trabajo`
--
ALTER TABLE `tbl_horario_trabajo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tbl_referencia_laboral`
--
ALTER TABLE `tbl_referencia_laboral`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
