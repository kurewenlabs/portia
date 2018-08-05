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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_archivo`
--
ALTER TABLE `tbl_archivo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_archivo`
--
ALTER TABLE `tbl_archivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;