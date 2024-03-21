-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2022 a las 17:18:20
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fooder`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bans`
--

CREATE TABLE `bans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime DEFAULT NULL,
  `permaban` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `featured` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `featured`) VALUES
(1, 'Argentina', NULL),
(2, 'Tortas', 'YES'),
(3, 'Paraguay', NULL),
(5, 'Vacio', 'YES'),
(6, 'Italia', NULL),
(7, 'Mexico', NULL),
(8, 'Uruguay', NULL),
(9, 'Guatemala', NULL),
(10, 'Brasil', NULL),
(11, 'Guiso', NULL),
(12, 'Sopa', NULL),
(13, 'Pizza', 'YES'),
(14, 'Tortilla', NULL),
(15, 'Empanada', NULL),
(17, 'Pastas', NULL),
(18, 'Milanesa', 'YES'),
(19, 'Omelette', NULL),
(20, 'Hamburguesa', 'YES'),
(21, 'Huevo', NULL),
(22, 'Amargo', NULL),
(23, 'Dulce', NULL),
(24, 'Salado', NULL),
(25, 'Agridulce', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories_recipes`
--

CREATE TABLE `categories_recipes` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `recipe_id`, `comment`, `created_at`, `deleted_at`) VALUES
(90, 61, 48, 'El mondongo no debería existir.', '2022-09-04 22:31:24', NULL),
(94, 47, 48, 'Muy buena receta', '2022-09-11 19:33:38', NULL),
(95, 47, 41, 'Que es esa introduccion', '2022-09-11 19:35:28', NULL),
(96, 46, 48, 'Que bardeas', '2022-09-11 19:38:14', NULL),
(97, 46, 47, 'Muy rica', '2022-09-11 19:38:50', NULL),
(98, 48, 45, 'Gracias , me gusta mucho la pizza', '2022-09-11 19:47:48', NULL),
(99, 48, 41, 'Gracias por la receta, me salieron espectaculares', '2022-09-11 19:56:26', NULL),
(100, 75, 47, 'muy bueno el paso a paso', '2022-09-11 20:01:22', NULL),
(101, 75, 45, 'buen tutorial', '2022-09-11 20:28:55', NULL),
(102, 76, 43, 'Buena receta', '2022-09-11 20:31:31', NULL),
(103, 76, 42, 'Me salieron riquisimos', '2022-09-11 20:32:09', NULL),
(104, 77, 42, 'Gracias, me salieron espectaculares', '2022-09-11 20:36:49', NULL),
(105, 77, 35, 'No me gusto', '2022-09-11 20:38:54', NULL),
(106, 78, 43, 'Me gusta mucho las papas', '2022-09-11 20:44:14', NULL),
(107, 78, 44, 'Tus recetas son muy buenas', '2022-09-11 20:45:23', NULL),
(108, 79, 44, 'Esta torta es buenisima', '2022-09-11 20:48:15', NULL),
(109, 79, 40, 'Las milanesas son god', '2022-09-11 20:48:33', NULL),
(110, 80, 40, 'Me encantan las milanesas', '2022-09-11 20:52:20', NULL),
(111, 80, 36, 'Me sirvio mucho esta receta', '2022-09-11 20:53:33', NULL),
(112, 81, 36, 'Me parecio una buena receta', '2022-09-11 20:57:08', NULL),
(113, 81, 35, 'Me gusto mucho', '2022-09-11 20:57:54', NULL),
(115, 32, 35, 'hola', '2022-09-21 20:00:08', '2022-09-21 20:00:12'),
(122, 32, 159, 'aerafgrweg', '2022-11-19 08:38:28', NULL),
(123, 32, 160, 'qweqwegqwrg', '2022-11-19 10:58:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments_likes`
--

CREATE TABLE `comments_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comments_likes`
--

INSERT INTO `comments_likes` (`id`, `user_id`, `comment_id`, `created_at`) VALUES
(6, 61, 90, '2022-09-04 22:31:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `followed_id`, `created_at`) VALUES
(2, 43, 37, '2022-08-13 15:29:10'),
(13, 32, 37, '2022-08-13 19:09:30'),
(19, 3, 32, '2022-09-13 19:40:00'),
(20, 3, 48, '2022-09-13 21:11:26'),
(76, 32, 47, '2022-09-20 21:18:44'),
(84, 32, 48, '2022-10-04 21:05:38'),
(93, 32, 1, '2022-10-09 22:19:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(75) NOT NULL,
  `introduction` varchar(250) NOT NULL,
  `ingredients` varchar(500) NOT NULL,
  `steps` varchar(2000) NOT NULL,
  `video_url` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `introduction`, `ingredients`, `steps`, `video_url`, `created_at`, `modified_at`, `deleted_at`) VALUES
(1, 32, 'qeereqw', 'eqwreqw', 'qewrqerwqerw', 'erqwerwewrqrqew', NULL, '2022-09-27 19:33:37', NULL, '2022-09-27 19:55:58'),
(35, 48, 'Omelette', 'Ya que estamos a fin de mes, aprovecho para enseñarles esta receta bien simple', 'Huevo\nUn pedacito de queso (en este caso, pero se pueden poner diversas cosas)', '1.Lo primero que vamos a hacer es romper el huevo en un bol y batirlo con rapidez. Esto va a generar que el huevo agarre aire y quede como más esponjoso.\r\n\r\n2.En una sarten al fuego (medio), vamos a derretir un pedacito de manteca (también pueden hacerlo con aceite) y vamos a volcar nuestro huevo en el centro. Es muy importante que no se distraigan buscando espátulas y tengan todo listo porque se les puede cuajar de más el huevo y no va a quedar TAN perfecto como queremos.  \r\n\r\n3.Entonces, la idea es que cuando veamos que ya esta un poco cocido por debajo, pero arriba aún está bastante líquido, ese es el momento de agregar lo que quieran de relleno, en este caso, un pedacito de queso fresco de un lado del círculo que está formando nuestro huevo.\r\n    \r\n4.Aquí viene la magia. Sin esperar mucho, vamos a agarrar una espátula y con rapidez vamos a juntar el extremo vacío del huevo con el otro extremo, tapando nuestro pedazo de queso. Lo que va a suceder, es que las puntas van a terminar de cocinarse juntas y así nuestro omelette va a quedar sellado perfectamente y nuestro relleno se va a terminar de cocinar dentro del huevo. Tengan en cuenta que es importante que el fuego sea medio. Si desean que por dentro quede un poco más crudo el huevo, lo pueden subir, para que se haga más de afuera. Pero sino, fuego medio para la cocción perfecta.\r\n    \r\n5.Lo que resta hacer es dar vuelta nuestro omelette una vez que ya esté bien cocido de un lado para que se cocine bien del otro y listo! Al terminar, lo retiramos con cuidado y lo servimos en un plato para degustarlo y ser felices.', NULL, '2022-08-24 22:58:20', NULL, NULL),
(36, 46, 'Fideos caseros', 'Esta vez les voy a ensañar la mejor receta de fideos caseros que conozco. La aprendi una vez que fui a Italia y tuve la oportunidad de conocer un chef', '500 g de harina 000\n5 huevos\n2 cdas de aceite de oliva\nSal (opcional, puede ir junto con la harina o en el agua de cocción)', '1.Sobre la mesada formá una corona con la harina. En el centro, volcá los huevos y el aceite de oliva, mezclá con un tenedor o con la punta de los dedos e incorporá la harina desde el borde de la corona hacia el centro. Trabajá hasta que todo se integre.   \n \n2.Una vez que se haya integrado todo, es momento de amasar, proceso que lleva unos 15 o 20 minutos. Para amasar a mano, hacelo con la parte inferior de las palmas, alternando una mano con la otra y usando el peso del cuerpo para darle más fuerza al amasado, hasta que la masa quede lisa y compacta y no se pegue a la mesada ni a los dedos.\n\n3.Después, la masa necesita descanso, mínimo media hora envuelta en papel film en la heladera o a temperatura ambiente (si hace mucho calor, no).  \n\n4.Estirado. Si tenés máquina de pasta, golazo, seguí las instrucciones del fabricante (básicamente vas a pasar varias veces la masa ajustando el espesor, hasta obtener una lámina de 1 mm).\nSi lo tuyo es el palote de la abuela, adelante. Van algunos tips: tomá el bollo y estiralo con el palote manteniendo la forma circular. Una vez que esté estirada, dale un cuarto de giro y estirala nuevamente con el palote desde el centro hacia afuera haciendo una leve presión. Espolvoréa semolín (o harina común), repetí el giro y el estirado varias veces hasta obtener una masa fina, de 1 mm de espesor.  \n\n5.Cortá tiras de 0,3 mm de ancho (podés usar un palote cortapastas, la Pastalinda o el cuchillo nomás). Dejalas secar (sería ideal que las cuelgues en el tender, ponele, una media hora mínimo). Esto hará que durante la cocción mantengan su forma y no absorban agua de más. Cuanto más seca, más tardará en cocinarse, pero, en términos generales, entre 5 a 7 minutos en la olla va a estar bien.', NULL, '2022-08-29 22:45:54', NULL, NULL),
(40, 46, 'Milanesa', 'Buenas gente, hoy les voy a enseñar como hacia las milanesas mi abuela. Esta es la comida que mas me gustaba cuando era chico. Espero que a ustedes tambien les guste', '4 huevos\n2 dientes de ajo\nPerejil picado\nSal y pimienta, a gusto\nPan rallado\n1 kilo de nalga o peceto para milanesa', '1.Pelar los ajos y picar junto con el perejil.\r\n\r\n2.Colocar los huevos en un bowl y batir hasta disolverlos bien. Luego agregar el perejil, los ajos y condimentar con sal y pimienta.\r\n\r\n3.Colocar la carne en la mezcla anterior, deje unos minutos, retirar y pasar por pan rallado.\r\n\r\n4.En una sartén con abundante aceite caliente freír las milanesas. Retirar y escurrir en papel absorbente.', NULL, '2022-08-29 22:49:57', NULL, NULL),
(41, 46, 'Empanada', 'Esta receta de empanadas que te voy a enseñar esta mas rica que la de tu novia ', '12 tapas de empanada\n600 gramos de carne picada\n600 gramos de cebolla\n2 huevos\n12 aceitunas\n1 cucharada postre de comino\n1 cucharada sopera de pimentón\n½ cucharada postre de ají molido\n1 hoja de laurel\n30 gramos de pasas de uva\n30 gramos de manteca\n30 centímetros cúbicos de aceite\n½ morrón\n3 verdeos\n1 huevo\n20 centímetros cúbicos de leche', '1.Para empezar con la receta de empanada argentina, primero debes cocer el huevo y dejar que se enfríe. Para ello, disponlo en una olla tapado con agua fría y llévalos al fuego por 12 minutos. Pélalos, pícalos y resérvalos.\r\n\r\n2.Mientras, mezcla la manteca con el aceite en una olla amplia con el fuego fuerte para saltear la parte blanca de la cebolla de verdeo y la cebolla picada. Una vez que estén transparentes y doradas, agrega el morrón picado.\r\n\r\n3.Cuando los vegetales estén dorados, retíralos de la sartén, resérvalos y en el mismo fondo de cocción con 1 cucharadita de aceite extra, saltea la carne picada. Aquí buscamos sellarla para darle sabor y que quede jugosa.\r\n\r\n4.Retira la carne dorada y los vegetales salteados del fuego para condimentar el relleno de tu empanada argentina con la parte verde del verdeo picada, el huevo duro que habías cocinado previamente, las aceitunas en rodajas, el pimentón, comino y ají molido. Refrigera antes de rellenar tus empanadillas argentinas.\r\n\r\n5.Mientras, hidrata las pasas de uva en agua caliente, si es que deseas agregarlas.\r\n\r\n6.Enciende el horno a temperatura máxima y procede a rellenar con el relleno para las empanadas argentinas al horno. Para ello, moja el borde de medio disco de masa y agrega una cucharada del relleno en el centro junto con 3-5 pasas. A continuación, aprieta los bordes y séllalos haciendo el clásico repulgue de las empanadas argentinas. Si quieres diferenciar las que tienen pasas de las que no, puedes hacerle otro tipo de cierre, como 5 o 6 pellizcos, o cerrarlas con un tenedor.\r\n\r\n7.Dispón las empanadas en una asadera engrasada, separadas por al menos 1 dedo de distancia. Seguido, píntalas con el huevo batido.\r\n\r\n8.Cocínalas unos 10-15 minutos o, hasta que la masa esté bien dorada. Puedes servirlas con unas rodajas de limón, salsa criolla cruda o disfrutarlas solas, pues están deliciosas de cualquier forma.', NULL, '2022-08-29 23:09:59', NULL, NULL),
(42, 46, 'Ravioles caseros', 'Antes te enseñe a hacer fideos caseros, hoy te voy a enseñar a hacer fideos caseros', '500g. de harina\n4 yemas\n1 cdita. de sal\n¼ de taza de agua tibia\n1 cda. de aceite de oliva', '\r\n1.Poner la harina y la sal en un bol en forma de corona. Agregar en el centro las yemas, el agua y el aceite. Pueden saborizar esta masa para ravioles, en mi caso le puse pimentón ya que iba a hacer estos fantásticos ravioles caseros de chorizo y espinaca.\r\n\r\n2. Mezclar hasta que quede una masa pegajosa y amasar por 10 minutos. A mí me ayudó Coco, que adora amasar. Les quedará una masa elástica y fina, que no se pega ni en las manos ni en la mesada. Muy amorosa esta masa para ravioles.\r\n\r\n3. Dejar reposar tapada con un repasador. Mientras tu masa para ravioles podés aprovechar para hacer el relleno. Porque si estás haciendo masa para ravioles tengo que suponer que vas a hacer ravioles, ¿no?\r\n\r\n4. Pasado este tiempo (una media hora), retirar la masa del bol y amasar 5 minutos más.\r\n\r\n5. Dividir la masa de ravioles en dos partes iguales.\r\n\r\n6. Estirar la primera parte con el palo de amasar hasta formar una pelicula de unos 2mm. de espesor. El grosor es importante ya que si te quedan muy gruesos no quedarán bien y si te quedan muy finos pueden abrirse durante la cocción. Reservar. Vale colgar la masa del respaldo de una silla, como hacía mi nonna. Y si la dejás sobre la mesada, qué envidia, cuánta mesada tenés.\r\n\r\n7. Repetir la operación con la otra mitad pero dejar en la mesada.\r\n\r\n8. Colocar cucharaditas de relleno bastante separadas entre sí hasta acabar el relleno (o la masa!). Si sobra relleno no desesperes: sobrará masa tras cortarla y podés volver a amasarla y hacer ravioles ad infinitum.\r\n\r\n9. Mojar los bordes de cada bolita de relleno con agua. Tapar con la masa reservada (la que está en la silla o en la otra parte de su fucking gran mesada) y presionar ligeramente con los dedos en las uniones para que se pegue. Tratar de que no quede demasiado aire dentro de cada raviol. Esto es importante porque sino se abrirán durante la cocción.\r\n\r\n10. Cortar con cortapastas o cuchillo cada raviol. Vean mi cortapastas: de la masa de jugar de mi hijo. Muy profesional. Vos', NULL, '2022-08-29 23:44:16', NULL, NULL),
(43, 47, 'Tortilla de papa', 'La papa en cualquiera de sus formas es rica. Esta ves les enseño en formato tortilla', 'Papa blanca 400 g\nHuevos, 4\nCebolla, 1 mediana\nSal fina, 1 cucharadita\nPimienta recién molida, a gusto\nAceite de oliva, 100 cc', '\r\n1.Lavar y pelar las papas, cortarlas en medias rodajas de 5 mm\r\n\r\n2.Colocar 50cc de aceite de oliva en un sartén y cocinar las papas pochandolas con el aceite a temperatura media, las papas deben estar tiernas y algo doradas, mezclar de vez en cuando.\r\n\r\n3.Cortar la cebolla en pluma de 2 mm y saltearla apenas dorada.\r\n    \r\n4.Batir los huevos en un bol con una pizca de sal y pimienta\r\n    \r\n5.Mezclar las papas y cebollas ya cocidas con los huevos.\r\n    \r\n6.Colocar unas 4 cucharadas de aceite en un sartén a fuego máximo y calentar hasta punto de humeo, volcar la preparación la cual debe cuajar una capa fina, bajar el fuego a mínimo y cocinar por unos 4 minutos.\r\n    \r\n7.Dar vuelta la tortilla con la ayuda de un plato y verter sobre el mismo sartén con algo de aceite y cocinar 4 minutos más.', NULL, '2022-08-29 23:55:30', NULL, NULL),
(44, 47, 'Torta de vainilla', '', '300 gramos de harina leudante o de repostería\n300 gramos de azúcar (1½ tazas)\n3 huevos\n200 mililitros de leche\n4 gotas de esencia de vainilla\n2 cucharaditas de levadura en polvo (polvos de hornear)', '1.Para comenzar a preparar esta torta casera hay que separar las claras de las yemas de los huevos y batir las yemas durante 2 minutos con una batidora o varillas eléctricas. Si lo prefieres, también puedes emplear una licuadora y preparar, incluso, toda la masa del bizcocho en ella.\r\n\r\n2.Transcurridos los 2 minutos, añade la mitad del azúcar y sigue batiendo hasta integrarlo por completo. El resultado debe ser una mezcla espumosa y uniforme para que la torta casera económica quede bien esponjosa.\r\n\r\n3.Cuando las yemas y el azúcar estén bien incorporados, puedes dejar de utilizar las varillas eléctricas para emplear las manuales si lo prefieres. Dicho esto, agrega la leche y mezcla haciendo movimientos circulares. Luego, incorpora la esencia de vainilla y sigue revolviendo hasta obtener una masa homogénea.\r\n\r\n4.Ahora, añade poco a poco la harina previamente tamizada para conseguir una masa con más aire y, por ende, una torta casera más esponjosa. Para integrar este ingrediente, recomendamos utilizar varillas manuales o una espátula y realizar movimientos envolventes suaves. Cabe destacar que en algunos países la harina leudante también es conocida como harina preparada o harina de repostería. Se trata de un tipo de harina que ya contiene en su composición levadura química, un impulsor que ayuda al queque a crecer. Si no la encuentras, también puedes usar harina común e incorporar una cucharadita más de polvos de hornear.\r\n\r\n5.Bate las claras a punto de nieve con el azúcar restante, como si quisieras hacer un merengue suizo. Después, incorpora las claras batidas a la mezcla haciendo movimientos envolventes para que no pierdan volumen. Precalienta el horno a 180 ºC.\r\n\r\n6.Para terminar la receta de torta casera económica, coloca la masa en el molde seleccionado, previamente engrasado con mantequilla o aceite, y hornea a 150 durante 60 minutos aproximadamente, o hasta que el queque esté listo. Es preferible hornear a temperaturas más bajas durante más tiempo para garant', NULL, '2022-08-30 00:03:02', NULL, NULL),
(45, 47, 'Pizza casera', 'Si no sabes hacer pizza desde 0, esta es tu receta!', '1 k. de harina 0000\n600 cc. de agua\n80 cc. de aceite de oliva\n50 grs. de levadura\n25 grs. de sal\n100 cc. de salsa de tomates\n500 g.. de mozzarella\n10 g. de orégano\nAceite de oliva, a gusto', '\r\n1.Formar una corona con toda la harina en la mesada de trabajo. Colocar en la parte externa de la misma la sal.\r\n\r\n2.En el centro incorporar la levadura y parte del agua, comenzar a mezclar tratando de no mezclar la sal con la levadura. Incorporar el resto del agua, y por último añadir el aceite. Amasar hasta lograr una masa uniforme.  Tapar y dejar descansar la masa unos 15 a 20 minutos.\r\n\r\n3.Cortar el tamaño de piezas deseado y dar forma de bollo. Tapar y dejar levar hasta duplicar el volumen.\r\n\r\n4.Colocar en placas previamente aceitadas y estirar a mano dándole el formato según el producto a realizar.\r\n\r\n5.Cocinar a una temperatura de 200° hasta que el disco tome color dorado en la base. Retirar del horno y esparcir el relleno deseado. Finalizar la cocción.', NULL, '2022-08-30 22:52:03', NULL, NULL),
(47, 48, 'Sopa paraguaya', 'Desde paraguay les presento, la sopa paraguaya', '300g. de harina de maíz (la amarilla fina, no polenta)\n1/2 lt. de leche\n3 cebollas grandes\n4 huevos\n400g. de queso que se derrita (cremoso, mozzarella, etc.)\n1 cdita. de orégano\nSal, pimienta, aceite', '1.Cortar la cebolla en tiras finas y rehogarlas en un poco de aceite. Que no lleguen a ponerse transparentes del todo, sino desaparecerán dentro de la sopa.\r\n    \r\n2.Batir en un bol los huevos. Una vez que estén unidos agregar la leche. Seguir batiendo.\r\n    \r\n3.Incorporar la harina de maíz, unir con batidor hasta que esté completamente integrada. Es fácil y no quedarán grumos.\r\n    \r\n4.Incorporar las cebollas rehogadas y salpimentar.\r\n    \r\n5.Agregar el queso, cortado en cubitos y unir bien sin que se rompa (quizás es mejor hacerlo con cuchara en esta parte).\r\n    \r\n6.Colocar la preparación en una fuente apta para horno apenas untada con aceite.\r\n    \r\n7.Llevar a horno moderado unos 30 minutos o hasta que veas la sopa paraguaya dorada por arriba.\r\n    \r\n8.Dejar entibiar y cortar en cuadrados.', NULL, '2022-08-30 23:02:02', NULL, NULL),
(48, 48, 'Guiso de mondongo', 'Para muchos un asco para otros, como yo, una delicia. Hoy toca guiso de mondongo', '1 kg de mondongo   \n1 cebolla grande o 2 cebollas chicas  \n3 dientes de ajo    \n1/2 pimiento morrón rojo    \n1/2 pimiento morrón verde    \n2 cebollas de verdeo   \n1 puerro    \n2 tallos de apio   \n1 chorizo colorado    \n4 tomates maduros\n250 gr de panceta    \nOpcional: una taza de porotos o garbanzos cocidos   \nOpcional: 2 papas    \nSal, pimienta, pimentón, ají molido   \n2 hojas de laurel   \nCantidad necesaria de caldo  \nAceite de oliva    \nPerejil o ciboulette para presentar', 'Lo primero que hay que hacer es limpiar el mondongo de la mayor grasa posible. Una vez limpio, hervir en agua con sal por media hora para terminar de desgrasar. Una vez pasado el tiempo dejar enfriar un poco y volver a retirar el exceso de grasa que pueda llegar a tener: se pueden notar unas partes blancas y unas pieles un poquito más duras. Luego cortar en tiras y reservar.\r\n    \r\n2.Colocar en una cacerola muy poquito de aceite de oliva y agregar la panceta y el chorizo colorado a fuego medio. La idea es que se doren y a la vez pierdan un poco de la grasa que llevan. Una vez dorados retirar de la olla y reservar.\r\n    \r\n3.En esa misma olla, sin lavar, agregamos el ajo y el resto de las verduras cortados bien pequeños y cocinar. Agregar los tomates cortados bien chiquitos, o mejor, triturados. Condimentar a gusto. Agregar las hojas de laurel.\r\n    \r\n4.Una vez que la preparación se redujo un poco y el tomate cambió a un color un poquito más oscuro, bajar el fuego y sumar las tiras de mondongo que estaban reservadas.\r\n    \r\n5.Agregar caldo o agua hasta cubrir los ingredientes, tapar y dejar cocinar unos 40 o 45 minutos más o menos. Mientras se cocina ir revolviendo para que no se pegue y de ser necesario ir agregando más líquido para que quede en la contextura deseada.\r\n    \r\n6.Si se le va a agregar al guiso de mondongo porotos, garbanzos o papas: este es el momento.\r\n    \r\n7.Agregar las papas peladas y cortadas en cubos y los porotos ya cocidos. Cocinar 10 o 15 minutos más (hasta que la papa ya esté tierna) y retirar del fuego.\r\n    \r\n8.Dejar tapado un rato para que se asienten los sabores. Servir y espolvorear con perejil o ciboulette picado por encima.', NULL, '2022-09-16 23:10:56', NULL, NULL),
(159, 32, 'Tutorial de como publicar una receta con imagenes', 'Esto es una prueba para ver como quedan las recetas agregandoles imagenes a gusto', '-Cuenta\r\n-Receta\r\n-Imagenes', '1- Iniciar sesión o registrarse \r\n2- Ir al apartado de \"Publicar receta\" (+) \r\n3- Escribir una receta \r\n4- Agregarle imagenes \r\n5- Verificar que este todo bien\r\n6- Publicar \r\n7- Fijarse como quedo', NULL, '2022-10-05 11:13:26', NULL, NULL),
(160, 32, 'otra prueba', 'jijijija', '-haidhw\r\n-hajahja\r\n-lñror\r\n-qeqwe', 'eqwefqwgqweqweqwr', NULL, '2022-10-05 11:14:27', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recipes_likes`
--

CREATE TABLE `recipes_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recipes_likes`
--

INSERT INTO `recipes_likes` (`id`, `user_id`, `recipe_id`, `created_at`) VALUES
(7, 61, 48, '2022-09-04 22:30:53'),
(10, 3, 48, '2022-09-13 21:13:00'),
(226, 32, 36, '2022-10-09 07:05:06'),
(227, 32, 35, '2022-10-09 07:05:07'),
(253, 32, 159, '2022-10-09 07:26:01'),
(261, 32, 48, '2022-11-19 10:53:06'),
(262, 32, 160, '2022-11-19 10:58:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `reported_comment_id` int(11) DEFAULT NULL,
  `reported_recipe_id` int(11) DEFAULT NULL,
  `reported_user_id` int(11) DEFAULT NULL,
  `reporter_user_id` int(11) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `justification` varchar(100) NOT NULL,
  `verdict` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `resolved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reports`
--

INSERT INTO `reports` (`id`, `admin_id`, `reported_comment_id`, `reported_recipe_id`, `reported_user_id`, `reporter_user_id`, `reason`, `justification`, `verdict`, `created_at`, `resolved_at`) VALUES
(18, NULL, NULL, 48, NULL, 32, 'cont_sex', 'testeando', '', '2022-10-31 08:36:17', NULL),
(32, NULL, 90, NULL, NULL, 32, 'cont_sex', 'Agrede a toda la colectividad mondongera', '', '2022-10-31 09:14:55', NULL),
(43, 32, NULL, NULL, 75, 32, 'cont_sex', 'qwerqwerweq', 'Reporte resuelto en reporte con id 44', '2022-11-17 23:45:41', '2022-11-17 23:47:00'),
(44, 32, NULL, NULL, 75, 32, 'cont_sex', 'qwerqwerqwerqwe', 'qwerqwerqwerweqrqwerqwe', '2022-11-17 23:46:48', '2022-11-17 23:47:00'),
(45, 32, NULL, NULL, 61, 32, 'cont_sex', 'qwerqwerqwereqwrqwe2', 'Reporte resuelto en reporte con id 46', '2022-11-17 23:48:37', '2022-11-17 23:51:47'),
(46, 32, NULL, NULL, 61, 32, 'cont_sex', 'qwerqwerqwereqwr', 'qwerqwerqwerqwe', '2022-11-17 23:49:57', '2022-11-17 23:51:47'),
(47, 32, NULL, NULL, 61, 32, 'cont_sex', 'qwerqwerweqrqwe', 'Reporte resuelto en reporte con id 46', '2022-11-17 23:49:59', '2022-11-17 23:51:47'),
(48, 32, NULL, NULL, 61, 32, 'cont_sex', 'qwreqwrqwerqew', 'Reporte resuelto en reporte con id 46', '2022-11-17 23:50:01', '2022-11-17 23:51:47'),
(49, NULL, NULL, NULL, 61, 32, 'cont_sex', 'qwerqwerqwerqwe', '', '2022-11-19 09:24:20', NULL),
(50, NULL, NULL, 48, NULL, 32, 'cont_sex', 'qwereqwrqwerqwe', '', '2022-11-19 09:31:55', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(3, 'administrador'),
(2, 'moderador'),
(1, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(60) NOT NULL,
  `biography` varchar(300) DEFAULT NULL,
  `gender` enum('male','female','other','no') NOT NULL DEFAULT 'no',
  `email` varchar(300) NOT NULL,
  `password` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `biography`, `gender`, `email`, `password`, `created_at`, `modified_at`, `deleted_at`) VALUES
(1, 'homero', 'Gaston', 'Soy un fanatico del LoL', 'male', 'gasty@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2022-06-13 01:20:57', NULL, NULL),
(2, 'aborigendesquiciado', 'Simon', 'Soy un dibujante fracasado', 'male', 'simon2004@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2022-06-01 20:28:04', NULL, NULL),
(3, 'elmasi', 'Massi', 'Boca Juniors', 'male', 'massipozzuto2016@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '2022-06-06 20:28:04', NULL, NULL),
(32, 'aa', 'aa', '', 'other', 'aa@gmail.com', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', '2022-06-22 18:31:03', '2022-09-07 23:20:59', NULL),
(35, 'homero9305', 'gastonam', 'esto es un test asdasd', 'other', 'testeandocambios@gmail.com', '8cb2237d0679ca88db6464eac60da96345513964', '2022-06-23 20:09:26', NULL, NULL),
(37, 'holaaa', 'queondaa', 'test', 'no', 'gaston.amenta@gmail.com', '2b1466e64b6040935428cd5644d49ffefaf3c62f', '2022-06-27 18:23:46', NULL, '2022-06-30 18:52:49'),
(46, 'Roberto', 'Roberto', '', 'no', 'roberto@gmail.com', 'dddd5d7b474d2c78ebbb833789c4bfd721edf4bf', '2022-08-29 22:33:48', '2022-09-11 19:29:03', NULL),
(47, 'juan', 'juan', NULL, 'no', 'jperez@gmail.com', '01b7bca425e6d725fc27f63b369fee5e78cdfd51', '2022-08-29 23:45:19', NULL, NULL),
(48, 'pepe', 'pepe', '', 'no', 'pepe@gmail.com', 'efc0272efb3783dcff5fdf4e07957efc42b3120b', '2022-08-30 22:54:01', '2022-09-11 19:30:51', NULL),
(60, 'ff', 'ff', NULL, 'no', 'ff@gmail.com', '354bf98925838ca68611b950e2a37ebd11c21640', '2022-09-03 04:06:57', '2022-09-03 04:47:33', NULL),
(61, 'aborigen insano', 'lucas', 'a todo ritmo', 'other', 'simoncarrenoe.t26@gmail.com', 'c473f1d6e3b25a1a745c1e8fde3b151292983060', '2022-09-04 22:30:47', '2022-09-04 22:33:09', NULL),
(75, 'Jose', 'Jose', NULL, 'no', 'jose@gmail.com', '1e3daf0c3c26b179f261958679f9226b2c606b57', '2022-09-11 19:59:02', NULL, NULL),
(76, 'Bauti', 'Bauti', NULL, 'no', 'bauti@gmail.com', '818a1858a9c38b48937b3302cb57ab2025f6eaaa', '2022-09-11 20:30:34', NULL, NULL),
(77, 'Maxi', 'Maximiliano', '', 'no', 'maximiliano@gmail.com', 'affb7d615f3d426a2f4ec629dde7dd030009e5ad', '2022-09-11 20:33:27', '2022-09-11 20:34:49', NULL),
(78, 'Ermenegildo', 'Ermenegildo', NULL, 'no', 'ermenegildo@gmail.com', '9bc34549d565d9505b287de0cd20ac77be1d3f2c', '2022-09-11 20:42:57', NULL, NULL),
(79, 'Nico', 'Nicolas', NULL, 'no', 'Nicolas@gmail.com', '230ca458880a428b97262e4876fcfe1741f21498', '2022-09-11 20:47:11', NULL, NULL),
(80, 'Carlos', 'Carlos', NULL, 'no', 'carlos@gmail.com', '4332e756d7877d568ba11664c4640b700d04edd9', '2022-09-11 20:51:20', NULL, NULL),
(81, 'Benito', 'Benito', NULL, 'no', 'benito@gmail.com', '7c4509a3d71dc2294dbf7fd79439de2dbe6262e4', '2022-09-11 20:55:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`, `modified_at`) VALUES
(1, 1, 1, NULL),
(2, 2, 2, '2022-11-19 07:13:26'),
(3, 3, 3, NULL),
(4, 32, 3, NULL),
(5, 35, 1, NULL),
(6, 37, 1, NULL),
(7, 46, 1, NULL),
(8, 47, 1, NULL),
(9, 48, 1, NULL),
(10, 60, 1, NULL),
(11, 61, 1, '2022-10-31 09:41:34'),
(12, 75, 1, NULL),
(13, 76, 1, NULL),
(14, 77, 1, NULL),
(15, 78, 1, NULL),
(16, 79, 1, NULL),
(17, 80, 1, NULL),
(18, 81, 1, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bans`
--
ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `categories_recipes`
--
ALTER TABLE `categories_recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `combination-recipe_id-category_id` (`recipe_id`,`category_id`) USING BTREE,
  ADD KEY `fk_categoriesrecipes_recipes` (`recipe_id`),
  ADD KEY `fk_categoriesrecipes_categories` (`category_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_comments_recipes` (`recipe_id`),
  ADD KEY `fk_comments_users` (`user_id`);

--
-- Indices de la tabla `comments_likes`
--
ALTER TABLE `comments_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `combination-user_id-comment_id` (`user_id`,`comment_id`) USING BTREE,
  ADD KEY `fk_commentslikes2_users` (`user_id`),
  ADD KEY `fk_commentscomments_likes` (`comment_id`);

--
-- Indices de la tabla `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `combination-follower_id-followed_id` (`follower_id`,`followed_id`) USING BTREE;

--
-- Indices de la tabla `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recipes_users` (`user_id`) USING BTREE;

--
-- Indices de la tabla `recipes_likes`
--
ALTER TABLE `recipes_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `combination-user_id-recipe_id` (`user_id`,`recipe_id`) USING BTREE,
  ADD KEY `fk_likesrecipes_recipes` (`recipe_id`),
  ADD KEY `fk_likesrecipes2_users` (`user_id`);

--
-- Indices de la tabla `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `combination-user_id-role_id` (`user_id`,`role_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bans`
--
ALTER TABLE `bans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `categories_recipes`
--
ALTER TABLE `categories_recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT de la tabla `comments_likes`
--
ALTER TABLE `comments_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT de la tabla `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

--
-- AUTO_INCREMENT de la tabla `recipes_likes`
--
ALTER TABLE `recipes_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT de la tabla `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de la tabla `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categories_recipes`
--
ALTER TABLE `categories_recipes`
  ADD CONSTRAINT `fk_categoriesrecipes_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_categoriesrecipes_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);

--
-- Filtros para la tabla `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comments_likes`
--
ALTER TABLE `comments_likes`
  ADD CONSTRAINT `fk_commentscomments_likes` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_commentslikes2_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `fk_recipes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `recipes_likes`
--
ALTER TABLE `recipes_likes`
  ADD CONSTRAINT `fk_likesrecipes2_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_likesrecipes_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
