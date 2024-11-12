-- SQLBook: Code
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tinder;
USE tinder;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    genero ENUM('hombre', 'mujer', 'otro') NOT NULL,
    rol ENUM('admin','usuario'),
    biografia TEXT,
    foto_perfil VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de fotos
CREATE TABLE fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    url_foto VARCHAR(255) NOT NULL,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de coincidencias (match)
CREATE TABLE coincidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_usuario_objetivo INT NOT NULL,
    accion ENUM('me_gusta', 'no_me_gusta') NOT NULL,
    fecha_coincidencia TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario_objetivo) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de mensajes
CREATE TABLE mensajes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_emisor INT NOT NULL,
    id_receptor INT NOT NULL,
    mensaje TEXT NOT NULL,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_emisor) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_receptor) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Insertar usuarios de prueba
INSERT INTO usuarios (nombre_usuario, correo, contrasena, genero, rol, biografia, foto_perfil) VALUES
('root', 'root@root.com', 'root', 'hombre', 'admin', 'root', '../root.png'),
('juan', 'juan@example.com', '12345', 'hombre', 'usuario', 'Me encanta la tecnología y los deportes', 'juan.jpg'),
('maria', 'maria@example.com', '12345', 'mujer', 'usuario', 'Amo viajar y descubrir nuevas culturas', 'maria.jpg'),
('carlos', 'carlos@example.com', '12345', 'hombre', 'usuario', 'Amante del cine y la música', 'carlos.jpg'),
('ana', 'ana@example.com', '12345', 'mujer', 'usuario', 'Me apasiona la naturaleza y el senderismo', 'ana.jpg'),
('luis', 'luis@example.com', '12345', 'hombre', 'usuario', 'Me encanta leer libros de ciencia ficción', 'luis.jpg'),
('sofia', 'sofia@example.com', '12345', 'mujer', 'usuario', 'Apasionada por el arte y la fotografía', 'sofia.jpg');

-- Insertar fotos de prueba
INSERT INTO fotos (id_usuario, url_foto) VALUES
(2, 'juan1.jpg'),
(2, 'juan2.jpg'),
(3, 'maria1.jpg'),
(3, 'maria2.jpg'),
(4, 'carlos1.jpg'),
(5, 'ana1.jpg'),
(6, 'luis1.jpg'),
(7, 'sofia1.jpg');

-- Insertar coincidencias de prueba
-- Juan da "me gusta" a María y a Ana
INSERT INTO coincidencias (id_usuario, id_usuario_objetivo, accion) VALUES
(2, 3, 'me_gusta'),
(2, 5, 'me_gusta');

-- María da "me gusta" a Juan
INSERT INTO coincidencias (id_usuario, id_usuario_objetivo, accion) VALUES
(3, 2, 'me_gusta');

-- Carlos da "no me gusta" a Sofía
INSERT INTO coincidencias (id_usuario, id_usuario_objetivo, accion) VALUES
(4, 7, 'no_me_gusta');

-- Ana da "me gusta" a Luis
INSERT INTO coincidencias (id_usuario, id_usuario_objetivo, accion) VALUES
(5, 6, 'me_gusta');
