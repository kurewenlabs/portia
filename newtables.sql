-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-07-2018 a las 03:39:05
-- Versión del servidor: 5.6.38
-- Versión de PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `postulacion`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_curso`
--

INSERT INTO `tbl_curso` (`id`, `id_post`, `rut`, `curso`, `fecha`) VALUES
(1, 'P1320186283654435', '40082050', 'uno', '01-07-18'),
(2, 'P1320186283654435', '40082050', 'rw', '17-07-18'),
(3, 'P1320186283654435', '40082050', '314451', '01-07-18'),
(4, 'Pte2018764948931', '16.282.161-k', 'PROGRAMACION', '01-07-18'),
(5, 'Pte20187125326317', '19958243-7', 'marketing', '01-07-18');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_datos_postulacion_abierta`
--

INSERT INTO `tbl_datos_postulacion_abierta` (`id`, `num`, `id_post`, `rut`, `nombre`, `categoria`) VALUES
(1, '11', 'P1320186283654435', '40082050', 'Digitador', 'Administrativo'),
(2, '12', 'P1320186283654435', '40082050', 'Asistente de calidad', 'Administrativo'),
(3, '13', 'P1320186283654435', '40082050', 'Asistente contable', 'Administrativo'),
(4, '2', 'pid', '', 'Reponedor grandes superficies', 'retail'),
(5, '11', 'Pte2018764948931', '16.282.161-k', 'Digitador', 'Administrativo'),
(6, '12', 'Pte2018764948931', '16.282.161-k', 'Asistente de calidad', 'Administrativo'),
(7, '11', 'Pte20187124058697', '16.282.161-k', 'Digitador', 'Administrativo'),
(8, '12', 'Pte20187124058697', '16.282.161-k', 'Asistente de calidad', 'Administrativo'),
(9, '1', 'Pte20187125326317', '19958243-7', 'Reponedor supermercados', 'retail'),
(10, '2', 'Pte20187125326317', '19958243-7', 'Reponedor grandes superficies', 'retail'),
(11, '11', 'Pte20187125326317', '19958243-7', 'Digitador', 'Administrativo'),
(12, '27', 'Pte20187125326317', '19958243-7', 'Conductor grua horquilla', 'Industrial'),
(13, '44', 'Pte20187125326317', '19958243-7', 'Conductor licencia A3', 'Otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_documento`
--

CREATE TABLE `tbl_documento` (
`id` int(11) NOT NULL,
`id_post` varchar(45) NOT NULL,
`rut` varchar(45) NOT NULL,
`cv` blob,
`antecedentes` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_documento`
--

INSERT INTO `tbl_documento` (`id`, `id_post`, `rut`, `cv`, `antecedentes`) VALUES
(1, 'P1320186283654435', '40082050', 0x433a66616b65706174683331313030312e706466, ''),
(2, 'pid', '', '', ''),
(3, 'Pte2018764948931', '16.282.161-k', '', ''),
(4, 'Pte20187124058697', '16.282.161-k', '', ''),
(5, 'Pte20187125326317', '19958243-7', 0x433a66616b6570617468436170747572612064652070616e74616c6c6120323031382d30372d31312061206c612873292031352e33382e32342e706e67, '');

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
`fecha_titulacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_estudio`
--

INSERT INTO `tbl_estudio` (`id`, `id_post`, `rut`, `tipo_estudio`, `titulo`, `estado`, `fecha_titulacion`) VALUES
(1, 'P1320186283654435', '40082050', 'Secundario', 'bachiller', 'En Curso', ''),
(2, 'pid', '', 'Universitario', 'INFORMATICA', '', ''),
(3, 'Pte2018764948931', '16.282.161-k', 'Secundario', 'INFORMATICA', 'En Curso', ''),
(4, 'Pte20187124058697', '16.282.161-k', 'Secundario', '', 'En Curso', ''),
(5, 'Pte20187125326317', '19958243-7', 'Secundario', '', 'En Curso', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_experiencia_laboral`
--

INSERT INTO `tbl_experiencia_laboral` (`id`, `id_post`, `rut`, `empresa`, `cargo`, `fecha_desde`, `fecha_hasta`) VALUES
(1, 'P1320186283654435', '40082050', 'dimerc', 'frontend', '01-07-18', '01-07-18'),
(2, 'P1320186283654435', '40082050', 'asffas', 'gerente general', '04-07-18', '01-07-18'),
(3, 'pid', '', 'dimerc', 'frontend', '10-10-10', '10-12-21'),
(4, 'pid', '', 'asffas', 'gerente general', '02-07-18', '08-07-18'),
(5, 'pid', '', 'jknakjfn', 'kjnaekfnl', 'lanefkn', 'ksdnfk'),
(6, 'Pte2018764948931', '16.282.161-k', 'fasf', 'frontend', '01-07-18', '01-07-18'),
(7, 'Pte20187124058697', '16.282.161-k', 'dimerc', 'frontend', '10-10-10', ''),
(8, 'Pte20187125326317', '19958243-7', 'dimerc', 'frontend', 'julio/2017', '');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_horario_trabajo`
--

INSERT INTO `tbl_horario_trabajo` (`id`, `id_post`, `rut`, `dias`, `horarios`, `comunas`) VALUES
(1, 'P1320186283654435', '40082050', 'Todos, ', '8:00 a 15:00', ''),
(2, 'P1320186283654435', '40082050', 'Viernes, ', '8:00 a 19:00', ''),
(3, 'Pte2018764948931', '16.282.161-k', 'Miercoles, ', '8:00 a 17:00', ''),
(4, 'Pte20187124058697', '16.282.161-k', 'Martes, Jueves, ', '4:00 a 16:00', ''),
(5, 'Pte20187125326317', '19958243-7', 'Lunes, Martes, Miercoles, Jueves, Viernes, ', '8:00 a 18:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_postulante`
--

CREATE TABLE `tbl_postulante` (
`id_post` varchar(45) NOT NULL,
`fecha_post` varchar(12) DEFAULT NULL,
`estado_post` varchar(20) DEFAULT 'Sin Clasificar',
`observacion` text,
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
`renta` varchar(30) DEFAULT NULL,
`tlicenciaconducir` varchar(12) DEFAULT NULL,
`afp` varchar(45) DEFAULT NULL,
`prestadorsalud` varchar(45) DEFAULT NULL,
`experiencialaboral` varchar(2) DEFAULT NULL,
`referencialaboral` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_postulante`
--

INSERT INTO `tbl_postulante` (`id_post`, `fecha_post`, `estado_post`, `observacion`, `rut`, `nombres`, `apellidop`, `apellidom`, `fecha_nacimiento`, `sexo`, `estado_civil`, `nacionalidad`, `telefono`, `telefono_recado`, `email`, `provincia`, `comuna`, `domicilio`, `tpolera`, `tpantalon`, `tpoleron`, `tzapatos`, `renta`, `tlicenciaconducir`, `afp`, `prestadorsalud`, `experiencialaboral`, `referencialaboral`) VALUES
('P1320186283654435', '2018-07-05', 'Sin Clasificar', '', '40082050', 'Andrea ', 'Suarez', 'Ruiz', '31-10-88', 'femenino', 'casado', 'venezolana', '956861325', '', 'asuaruiz@gmail.com', 'R.M.', 'san bernardo', 'la pradera 2004', 'XS', '42', 'M', '40', '500.000 - 550.000', '', 'AFP Cuprum', 'Cruz Blanca', 'Si', 'Si'),
('Pte20187124058697', '2018-07-12', 'Sin Clasificar', '', '16282161-k', 'andrea', 'suae', 'dasda', '01-07-18', 'femenino', 'soltero', 'Chile', '049140', '', 'asuaruiz@hotmail.com', 'Valparaiso', 'afss', '', 'M', '34', 'M', '44', '400.000 - 450.000', '', 'AFP Habitat', 'Cruz Blanca', 'Si', 'No'),
('Pte20187125326317', '2018-07-12', 'Seleccionado', '', '149823592-3', 'David', 'Matamala', 'Godoy', '01-07-18', 'masculino', 'soltero', 'chilena', '32535253', '52545', 'david.godoyecker@gmail.com', 'R.M.', 'Santiago', '', 'M', '42', 'L', '40', '500.000 - 550.000', '', 'AFP Habitat', 'Colmena', 'Si', 'No'),
('Pte2018764948931', '2018-07-06', 'Seleccionado', '', '16247349-2', 'jennifer', 'matamala', 'Godoy', '24-08-84', 'femenino', 'casado', 'chilena', '789780089', '', 'jmatam.go@gmail.com', 'R.M.', 'san bernardo', 'la pradera 2004', 'M', '48', 'L', '40', '450.000 - 500.000', '', 'AFP Modelo', 'Cruz del Norte', 'Si', 'Si');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tbl_referencia_laboral`
--

INSERT INTO `tbl_referencia_laboral` (`id`, `id_post`, `rut`, `empresa`, `nombre_contacto`, `cargo`, `telefono`, `email`) VALUES
(1, 'P1320186283654435', '40082050', 'dimerc', 'jennifer matamala', 'dev', '98798798', 'jmatam1301@gmail.com'),
(2, 'P1320186283654435', '40082050', '', '', '', '', ''),
(3, 'P1320186283654435', '40082050', '', '', '', '', ''),
(4, 'pid', '', 'falkalk', 'lkjnadkjfna', 'kjlsndk', 'ksandgk', 'asuarez@gmail.com'),
(5, 'pid', '', 'fajanslk.', 'kjnfakfkas', 'kjnafklnsk', 'kjnasknsc', 'asuarez@gmail.com'),
(6, 'pid', '', 'asfkjnask', 'jknasdklans', 'kjandflk', 'qkjnakf', 'asuarez@gmail.com'),
(7, 'Pte2018764948931', '16.282.161-k', 'dimerc', 'lkjnadkjfna', 'dev', '98789', 'asuarez@gmail.com'),
(8, 'Pte2018764948931', '16.282.161-k', '', '', '', '', ''),
(9, 'Pte2018764948931', '16.282.161-k', '', '', '', '', '');

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_curso`
--
ALTER TABLE `tbl_curso`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_datos_postulacion_abierta`
--
ALTER TABLE `tbl_datos_postulacion_abierta`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tbl_documento`
--
ALTER TABLE `tbl_documento`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_estudio`
--
ALTER TABLE `tbl_estudio`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_experiencia_laboral`
--
ALTER TABLE `tbl_experiencia_laboral`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbl_horario_trabajo`
--
ALTER TABLE `tbl_horario_trabajo`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_referencia_laboral`
--
ALTER TABLE `tbl_referencia_laboral`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
