create database bitacora;
create schema bitacora.sc_bitacora;
set search_path to sc_bitacora;

create table Permiso(
	idPermiso serial primary key unique not null,
	permiso varchar(50)
);
create table TipoUsuario(
	idTipoU serial primary key unique not null,
	tipo varchar(50)
);
create table usuario_permiso (
	idPermiso int,
	idTipoU int,
	FOREIGN KEY(idPermiso) references Permiso(idPermiso),
	FOREIGN KEY(idTipoU) references TipoUsuario(idTipoU)
);
create table Usuario(
	idUsuario serial primary key unique not null,
	contraseña varchar(200),
	nombre varchar(50),
	apellidos varchar(60),
	correo varchar(40),
	puesto varchar(30),
	idTipoU int,
	FOREIGN KEY(idTipoU) references TipoUsuario(idTipoU)
);
create table Fiscales(
	idFiscal serial primary key unique not null,
	RFC varchar(13) not null, 
	regimen varchar(60),
	direccion varchar(200),
	municipio varchar(100),
	cp varchar(6),
	estado varchar(50),
	pais varchar(50)
);
create table Cliente(
	idCliente serial primary key unique not null,
	noCliente int not null, 
	idFiscal int,
	FOREIGN KEY(idFiscal) references Fiscales(idFiscal)
);
create table Proveedor(
	idProved serial primary key unique not null,
	noProved int not null, 
	nombreComercial varchar(200),
	direccion varchar(200),
	idFiscal int,
	FOREIGN KEY(idFiscal) references Fiscales(idFiscal)
);



