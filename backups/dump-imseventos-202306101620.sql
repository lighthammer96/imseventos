--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.20
-- Dumped by pg_dump version 9.2.20
-- Started on 2023-06-10 16:20:49

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 9 (class 2615 OID 17757)
-- Name: eventos; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA eventos;


--
-- TOC entry 8 (class 2615 OID 17604)
-- Name: seguridad; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA seguridad;


SET search_path = eventos, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 200 (class 1259 OID 21761)
-- Name: asistencias; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE asistencias (
    asistencia_id integer NOT NULL,
    evento_id integer,
    programa_id integer,
    participante_id integer,
    usuario_registro character varying(50),
    fecha_registro timestamp without time zone,
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 199 (class 1259 OID 21759)
-- Name: asistencias_asistencia_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE asistencias_asistencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2139 (class 0 OID 0)
-- Dependencies: 199
-- Name: asistencias_asistencia_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE asistencias_asistencia_id_seq OWNED BY asistencias.asistencia_id;


--
-- TOC entry 204 (class 1259 OID 21807)
-- Name: asistencias_transporte; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE asistencias_transporte (
    at_id integer NOT NULL,
    evento_id integer,
    participante_id integer,
    usuario_registro character varying(50),
    fecha_registro timestamp without time zone,
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 203 (class 1259 OID 21805)
-- Name: asistencias_transporte_at_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE asistencias_transporte_at_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2140 (class 0 OID 0)
-- Dependencies: 203
-- Name: asistencias_transporte_at_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE asistencias_transporte_at_id_seq OWNED BY asistencias_transporte.at_id;


--
-- TOC entry 192 (class 1259 OID 21564)
-- Name: detalle_eventos; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE detalle_eventos (
    evento_id integer NOT NULL,
    participante_id integer NOT NULL,
    registro_id integer NOT NULL,
    de_codigoqr character varying(255),
    de_codigoqr_ruta character varying(255)
);


--
-- TOC entry 187 (class 1259 OID 20299)
-- Name: eventos; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE eventos (
    evento_id integer NOT NULL,
    evento_descripcion character varying(255),
    evento_fecha_inicio date,
    evento_fecha_fin date,
    estado character(1) DEFAULT 'A'::bpchar,
    fecha_registro time without time zone,
    evento_detalle text
);


--
-- TOC entry 186 (class 1259 OID 20297)
-- Name: eventos_evento_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE eventos_evento_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2141 (class 0 OID 0)
-- Dependencies: 186
-- Name: eventos_evento_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE eventos_evento_id_seq OWNED BY eventos.evento_id;


--
-- TOC entry 185 (class 1259 OID 17782)
-- Name: participantes; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE participantes (
    participante_id integer NOT NULL,
    participante_nombres character varying(100),
    participante_apellidos character varying(100),
    idtipodoc integer,
    participante_nrodoc character varying(20),
    participante_fecha_nacimiento date,
    idpais integer,
    participante_ciudad_procedencia character varying(50),
    participante_celular character varying(20),
    participante_celular_emergencia character varying(20),
    participante_correo character varying(100),
    participante_apoderado character varying(200),
    participante_iglesia character varying(100),
    participante_codigoqr character varying(255),
    participante_codigoqr_ruta character varying(255),
    estado character(1) DEFAULT 'A'::bpchar,
    usuario_registro character varying(50),
    participante_edad integer,
    participante_delegado character(1),
    participante_aerolinea character varying(50),
    participante_nrovuelo character varying(50),
    participante_fecha_llegada date,
    participante_hora_llegada time without time zone,
    participante_fecha_retorno date,
    participante_hora_retorno time without time zone,
    participante_destino_llegada character varying(50),
    registro_id_ultimo integer,
    fecha_registro timestamp without time zone
);


--
-- TOC entry 2142 (class 0 OID 0)
-- Dependencies: 185
-- Name: COLUMN participantes.participante_delegado; Type: COMMENT; Schema: eventos; Owner: -
--

COMMENT ON COLUMN participantes.participante_delegado IS 'S -> Si
N -> No';


--
-- TOC entry 184 (class 1259 OID 17780)
-- Name: participantes_participante_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE participantes_participante_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2143 (class 0 OID 0)
-- Dependencies: 184
-- Name: participantes_participante_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE participantes_participante_id_seq OWNED BY participantes.participante_id;


--
-- TOC entry 202 (class 1259 OID 21784)
-- Name: permisos; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE permisos (
    permiso_id integer NOT NULL,
    evento_id integer,
    programa_id integer,
    participante_id integer,
    tipo character(1),
    usuario_registro character varying(50),
    fecha_registro timestamp without time zone,
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 2144 (class 0 OID 0)
-- Dependencies: 202
-- Name: COLUMN permisos.tipo; Type: COMMENT; Schema: eventos; Owner: -
--

COMMENT ON COLUMN permisos.tipo IS 'S -> SALIDA
                    E -> ENTRADA';


--
-- TOC entry 201 (class 1259 OID 21782)
-- Name: permisos_permiso_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE permisos_permiso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2145 (class 0 OID 0)
-- Dependencies: 201
-- Name: permisos_permiso_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE permisos_permiso_id_seq OWNED BY permisos.permiso_id;


--
-- TOC entry 196 (class 1259 OID 21607)
-- Name: programas; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE programas (
    programa_id integer NOT NULL,
    programa_descripcion character varying(100),
    programa_fecha date,
    tp_id integer,
    evento_id integer,
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 195 (class 1259 OID 21605)
-- Name: programas_programa_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE programas_programa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2146 (class 0 OID 0)
-- Dependencies: 195
-- Name: programas_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE programas_programa_id_seq OWNED BY programas.programa_id;


--
-- TOC entry 198 (class 1259 OID 21654)
-- Name: registros; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE registros (
    registro_id integer NOT NULL,
    participante_id integer,
    registro_ciudad_procedencia character varying(50),
    registro_celular character varying(20),
    registro_celular_emergencia character varying(20),
    registro_correo character varying(100),
    registro_apoderado character varying(200),
    registro_iglesia character varying(100),
    registro_edad integer,
    registro_delegado character(1),
    registro_aerolinea character varying(50),
    registro_nrovuelo character varying(50),
    registro_fecha_llegada date,
    registro_hora_llegada time without time zone,
    registro_fecha_retorno date,
    registro_hora_retorno time without time zone,
    registro_destino_llegada character varying(50)
);


--
-- TOC entry 2147 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN registros.registro_delegado; Type: COMMENT; Schema: eventos; Owner: -
--

COMMENT ON COLUMN registros.registro_delegado IS 'S -> Si
        N -> No';


--
-- TOC entry 197 (class 1259 OID 21652)
-- Name: registros_registro_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE registros_registro_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2148 (class 0 OID 0)
-- Dependencies: 197
-- Name: registros_registro_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE registros_registro_id_seq OWNED BY registros.registro_id;


--
-- TOC entry 194 (class 1259 OID 21598)
-- Name: tipos_programa; Type: TABLE; Schema: eventos; Owner: -; Tablespace: 
--

CREATE TABLE tipos_programa (
    tp_id integer NOT NULL,
    tp_descripcion character varying(50),
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 193 (class 1259 OID 21596)
-- Name: tipos_programa_tp_id_seq; Type: SEQUENCE; Schema: eventos; Owner: -
--

CREATE SEQUENCE tipos_programa_tp_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2149 (class 0 OID 0)
-- Dependencies: 193
-- Name: tipos_programa_tp_id_seq; Type: SEQUENCE OWNED BY; Schema: eventos; Owner: -
--

ALTER SEQUENCE tipos_programa_tp_id_seq OWNED BY tipos_programa.tp_id;


SET search_path = public, pg_catalog;

--
-- TOC entry 188 (class 1259 OID 20307)
-- Name: pais; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE pais (
    idpais integer NOT NULL,
    descripcion character varying(50) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 189 (class 1259 OID 20311)
-- Name: pais_idpais_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE pais_idpais_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2150 (class 0 OID 0)
-- Dependencies: 189
-- Name: pais_idpais_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE pais_idpais_seq OWNED BY pais.idpais;


--
-- TOC entry 190 (class 1259 OID 20313)
-- Name: tipodoc; Type: TABLE; Schema: public; Owner: -; Tablespace: 
--

CREATE TABLE tipodoc (
    idtipodoc integer NOT NULL,
    descripcion character varying(50) DEFAULT ''::character varying NOT NULL
);


--
-- TOC entry 191 (class 1259 OID 20317)
-- Name: tipodoc_idtipodoc_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE tipodoc_idtipodoc_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2151 (class 0 OID 0)
-- Dependencies: 191
-- Name: tipodoc_idtipodoc_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE tipodoc_idtipodoc_seq OWNED BY tipodoc.idtipodoc;


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 176 (class 1259 OID 17615)
-- Name: log_sistema; Type: TABLE; Schema: seguridad; Owner: -; Tablespace: 
--

CREATE TABLE log_sistema (
    idlog integer NOT NULL,
    mensaje character varying(250) DEFAULT NULL::character varying,
    fecha timestamp without time zone,
    usuario character varying(20) DEFAULT NULL::character varying,
    nombres character varying(150) DEFAULT NULL::character varying,
    idperfil integer,
    idreferencia integer,
    ip character varying(50),
    operacion character varying(50),
    tabla character varying(50)
);


--
-- TOC entry 171 (class 1259 OID 17605)
-- Name: log_sistema_idlog_seq; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE log_sistema_idlog_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 175 (class 1259 OID 17613)
-- Name: log_sistema_idlog_seq1; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE log_sistema_idlog_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2152 (class 0 OID 0)
-- Dependencies: 175
-- Name: log_sistema_idlog_seq1; Type: SEQUENCE OWNED BY; Schema: seguridad; Owner: -
--

ALTER SEQUENCE log_sistema_idlog_seq1 OWNED BY log_sistema.idlog;


--
-- TOC entry 183 (class 1259 OID 17655)
-- Name: modulos; Type: TABLE; Schema: seguridad; Owner: -; Tablespace: 
--

CREATE TABLE modulos (
    modulo_id integer NOT NULL,
    modulo_nombre character varying(50),
    modulo_icono character varying(50),
    modulo_controlador character varying(50),
    modulo_padre integer,
    modulo_orden integer,
    modulo_route character varying(50),
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 172 (class 1259 OID 17607)
-- Name: modulos_modulo_id_seq; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE modulos_modulo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 182 (class 1259 OID 17653)
-- Name: modulos_modulo_id_seq1; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE modulos_modulo_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2153 (class 0 OID 0)
-- Dependencies: 182
-- Name: modulos_modulo_id_seq1; Type: SEQUENCE OWNED BY; Schema: seguridad; Owner: -
--

ALTER SEQUENCE modulos_modulo_id_seq1 OWNED BY modulos.modulo_id;


--
-- TOC entry 178 (class 1259 OID 17629)
-- Name: perfiles; Type: TABLE; Schema: seguridad; Owner: -; Tablespace: 
--

CREATE TABLE perfiles (
    perfil_id integer NOT NULL,
    perfil_descripcion character varying(50),
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 173 (class 1259 OID 17609)
-- Name: perfiles_perfil_id_seq; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE perfiles_perfil_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 177 (class 1259 OID 17627)
-- Name: perfiles_perfil_id_seq1; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE perfiles_perfil_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2154 (class 0 OID 0)
-- Dependencies: 177
-- Name: perfiles_perfil_id_seq1; Type: SEQUENCE OWNED BY; Schema: seguridad; Owner: -
--

ALTER SEQUENCE perfiles_perfil_id_seq1 OWNED BY perfiles.perfil_id;


--
-- TOC entry 179 (class 1259 OID 17636)
-- Name: permisos; Type: TABLE; Schema: seguridad; Owner: -; Tablespace: 
--

CREATE TABLE permisos (
    perfil_id integer NOT NULL,
    modulo_id integer NOT NULL
);


--
-- TOC entry 181 (class 1259 OID 17643)
-- Name: usuarios; Type: TABLE; Schema: seguridad; Owner: -; Tablespace: 
--

CREATE TABLE usuarios (
    usuario_id integer NOT NULL,
    usuario_user character varying(50),
    usuario_pass character varying(200),
    usuario_nombres character varying(100),
    usuario_referencia text,
    perfil_id integer,
    estado character(1) DEFAULT 'A'::bpchar
);


--
-- TOC entry 174 (class 1259 OID 17611)
-- Name: usuarios_usuario_id_seq; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE usuarios_usuario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 180 (class 1259 OID 17641)
-- Name: usuarios_usuario_id_seq1; Type: SEQUENCE; Schema: seguridad; Owner: -
--

CREATE SEQUENCE usuarios_usuario_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 2155 (class 0 OID 0)
-- Dependencies: 180
-- Name: usuarios_usuario_id_seq1; Type: SEQUENCE OWNED BY; Schema: seguridad; Owner: -
--

ALTER SEQUENCE usuarios_usuario_id_seq1 OWNED BY usuarios.usuario_id;


SET search_path = eventos, pg_catalog;

--
-- TOC entry 1935 (class 2604 OID 21764)
-- Name: asistencia_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias ALTER COLUMN asistencia_id SET DEFAULT nextval('asistencias_asistencia_id_seq'::regclass);


--
-- TOC entry 1939 (class 2604 OID 21810)
-- Name: at_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias_transporte ALTER COLUMN at_id SET DEFAULT nextval('asistencias_transporte_at_id_seq'::regclass);


--
-- TOC entry 1924 (class 2604 OID 20302)
-- Name: evento_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY eventos ALTER COLUMN evento_id SET DEFAULT nextval('eventos_evento_id_seq'::regclass);


--
-- TOC entry 1922 (class 2604 OID 17785)
-- Name: participante_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY participantes ALTER COLUMN participante_id SET DEFAULT nextval('participantes_participante_id_seq'::regclass);


--
-- TOC entry 1937 (class 2604 OID 21787)
-- Name: permiso_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY permisos ALTER COLUMN permiso_id SET DEFAULT nextval('permisos_permiso_id_seq'::regclass);


--
-- TOC entry 1932 (class 2604 OID 21610)
-- Name: programa_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY programas ALTER COLUMN programa_id SET DEFAULT nextval('programas_programa_id_seq'::regclass);


--
-- TOC entry 1934 (class 2604 OID 21657)
-- Name: registro_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY registros ALTER COLUMN registro_id SET DEFAULT nextval('registros_registro_id_seq'::regclass);


--
-- TOC entry 1930 (class 2604 OID 21601)
-- Name: tp_id; Type: DEFAULT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY tipos_programa ALTER COLUMN tp_id SET DEFAULT nextval('tipos_programa_tp_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- TOC entry 1927 (class 2604 OID 20319)
-- Name: idpais; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY pais ALTER COLUMN idpais SET DEFAULT nextval('pais_idpais_seq'::regclass);


--
-- TOC entry 1929 (class 2604 OID 20320)
-- Name: idtipodoc; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY tipodoc ALTER COLUMN idtipodoc SET DEFAULT nextval('tipodoc_idtipodoc_seq'::regclass);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 1912 (class 2604 OID 17618)
-- Name: idlog; Type: DEFAULT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY log_sistema ALTER COLUMN idlog SET DEFAULT nextval('log_sistema_idlog_seq1'::regclass);


--
-- TOC entry 1920 (class 2604 OID 17658)
-- Name: modulo_id; Type: DEFAULT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY modulos ALTER COLUMN modulo_id SET DEFAULT nextval('modulos_modulo_id_seq1'::regclass);


--
-- TOC entry 1916 (class 2604 OID 17632)
-- Name: perfil_id; Type: DEFAULT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY perfiles ALTER COLUMN perfil_id SET DEFAULT nextval('perfiles_perfil_id_seq1'::regclass);


--
-- TOC entry 1918 (class 2604 OID 17646)
-- Name: usuario_id; Type: DEFAULT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY usuarios ALTER COLUMN usuario_id SET DEFAULT nextval('usuarios_usuario_id_seq1'::regclass);


SET search_path = eventos, pg_catalog;

--
-- TOC entry 2129 (class 0 OID 21761)
-- Dependencies: 200
-- Data for Name: asistencias; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO asistencias VALUES (1, 1, 1, 4, 'admin', '2023-05-22 17:04:11', 'A');
INSERT INTO asistencias VALUES (2, 1, 1, 12, 'admin', '2023-05-22 19:02:01', 'A');
INSERT INTO asistencias VALUES (3, 1, 2, 11, 'admin', '2023-05-22 19:17:28', 'A');
INSERT INTO asistencias VALUES (4, 1, 1, 7, 'admin', '2023-05-22 19:34:15', 'A');
INSERT INTO asistencias VALUES (5, 1, 1, 10, 'admin', '2023-05-22 19:35:21', 'A');
INSERT INTO asistencias VALUES (6, 1, 2, 4, 'admin', '2023-05-23 09:04:12', 'I');


--
-- TOC entry 2156 (class 0 OID 0)
-- Dependencies: 199
-- Name: asistencias_asistencia_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('asistencias_asistencia_id_seq', 6, true);


--
-- TOC entry 2133 (class 0 OID 21807)
-- Dependencies: 204
-- Data for Name: asistencias_transporte; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO asistencias_transporte VALUES (1, 1, 4, 'admin', '2023-05-26 12:33:20', 'A');
INSERT INTO asistencias_transporte VALUES (2, 1, 7, 'admin', '2023-05-26 12:41:44', 'A');
INSERT INTO asistencias_transporte VALUES (3, 1, 12, 'admin', '2023-05-26 12:55:14', 'A');
INSERT INTO asistencias_transporte VALUES (4, 1, 10, 'admin', '2023-05-26 12:57:21', 'A');
INSERT INTO asistencias_transporte VALUES (5, 1, 21, 'admin', '2023-05-26 13:02:45', 'A');


--
-- TOC entry 2157 (class 0 OID 0)
-- Dependencies: 203
-- Name: asistencias_transporte_at_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('asistencias_transporte_at_id_seq', 5, true);


--
-- TOC entry 2121 (class 0 OID 21564)
-- Dependencies: 192
-- Data for Name: detalle_eventos; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO detalle_eventos VALUES (2, 4, 4, '2-4-6640', '2-4-6640.png');
INSERT INTO detalle_eventos VALUES (3, 6, 6, '3-6-4888', '3-6-4888.png');
INSERT INTO detalle_eventos VALUES (1, 4, 4, '1-4-4917', '1-4-4917.png');
INSERT INTO detalle_eventos VALUES (1, 7, 7, '1-7-5628', '1-7-5628.png');
INSERT INTO detalle_eventos VALUES (2, 7, 7, '2-7-1050', '2-7-1050.png');
INSERT INTO detalle_eventos VALUES (1, 8, 8, '1-8-7152', '1-8-7152.png');
INSERT INTO detalle_eventos VALUES (3, 9, 9, '3-9-3813', '3-9-3813.png');
INSERT INTO detalle_eventos VALUES (1, 10, 10, '1-10-5362', '1-10-5362.png');
INSERT INTO detalle_eventos VALUES (1, 11, 11, '1-11-1776', '1-11-1776.png');
INSERT INTO detalle_eventos VALUES (1, 12, 12, '1-12-1714', '1-12-1714.png');
INSERT INTO detalle_eventos VALUES (2, 13, 13, '2-13-2762', '2-13-2762.png');
INSERT INTO detalle_eventos VALUES (3, 14, 14, '3-14-9781', '3-14-9781.png');
INSERT INTO detalle_eventos VALUES (3, 15, 15, '3-15-2598', '3-15-2598.png');
INSERT INTO detalle_eventos VALUES (1, 16, 16, '1-16-6779', '1-16-6779.png');
INSERT INTO detalle_eventos VALUES (2, 16, 16, '2-16-8176', '2-16-8176.png');
INSERT INTO detalle_eventos VALUES (3, 16, 16, '3-16-8206', '3-16-8206.png');
INSERT INTO detalle_eventos VALUES (1, 17, 17, 'joan_manuel_zarria_sinarahua-1-17-4431', 'joan_manuel_zarria_sinarahua-1-17-4431.png');
INSERT INTO detalle_eventos VALUES (3, 17, 17, 'joan_manuel_zarria_sinarahua-3-17-7059', 'joan_manuel_zarria_sinarahua-3-17-7059.png');
INSERT INTO detalle_eventos VALUES (2, 17, 17, 'joan_manuel_zarria_sinarahua-2-17-4170', 'joan_manuel_zarria_sinarahua-2-17-4170.png');
INSERT INTO detalle_eventos VALUES (1, 20, 20, 'jmzs-1-20-1318', 'jmzs-1-20-1318.png');
INSERT INTO detalle_eventos VALUES (3, 20, 20, 'jmzs-3-20-7367', 'jmzs-3-20-7367.png');
INSERT INTO detalle_eventos VALUES (2, 20, 20, 'jmzs-2-20-1105', 'jmzs-2-20-1105.png');
INSERT INTO detalle_eventos VALUES (1, 21, 21, '1-21-2238', '1-21-2238.png');
INSERT INTO detalle_eventos VALUES (1, 22, 22, '1-22-4095', '1-22-4095.png');


--
-- TOC entry 2116 (class 0 OID 20299)
-- Dependencies: 187
-- Data for Name: eventos; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO eventos VALUES (1, 'ASAMBLEA MUNDIAL DE DELEGADOS, PERÚ 2023', '2023-01-07', '2023-12-31', 'A', '00:00:00', 'TEST');
INSERT INTO eventos VALUES (2, 'CONGRESO PÚBLICO MUNDIAL , PERÚ 2023', '2023-05-31', '2025-01-01', 'A', NULL, NULL);
INSERT INTO eventos VALUES (3, 'EVENTO 03', '2023-05-31', '2023-06-30', 'A', NULL, NULL);


--
-- TOC entry 2158 (class 0 OID 0)
-- Dependencies: 186
-- Name: eventos_evento_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('eventos_evento_id_seq', 3, true);


--
-- TOC entry 2114 (class 0 OID 17782)
-- Dependencies: 185
-- Data for Name: participantes; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO participantes VALUES (6, 'CINDHY MEDALY', 'GUEVARA GARCIA', 1, '01149674', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (4, 'JOAN MANUEL', 'ZARRIA SINARAHUA', 1, '76621421', '1996-06-07', 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (7, 'YOLITA', 'SINARAHUA SATALAYA', 1, '01065258', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'web', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (8, 'NIEVES YARITZA', 'GUEVARA GARCIA', 1, '11223344', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (9, 'NAYRA FRANCISQUITA', 'GUEVARA GARCIA', 1, '77889911', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (10, 'DANA MAYLI', 'GUEVARA GARCIA', 1, '44332211', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (11, 'TONY MARTIN', 'HUANSI SINARAHUA', 1, '44335566', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (12, 'GRIMANEZ', 'GUEVARA MACHOA', 1, '00998877', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, '2023-05-16 22:10:36.126');
INSERT INTO participantes VALUES (13, 'JHOY', 'MACEDO CHUJUTALLI', 1, '55544331', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, '2023-05-17 15:48:46');
INSERT INTO participantes VALUES (14, 'DENIS', 'SINARAHUA SATALAYA', 1, '00091112', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, '2023-05-17 15:49:55');
INSERT INTO participantes VALUES (15, 'LOYCITH', 'SINARAHUA SATALAYA', 2, '88991111', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, '2023-05-17 16:04:44');
INSERT INTO participantes VALUES (16, 'JOAN MANUEL', 'TORRES FLORES', 1, '11223399', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 16, '2023-05-23 20:04:37');
INSERT INTO participantes VALUES (17, 'JOAN MANUEL', 'CCC', 1, '11665533', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, '2023-05-23 20:07:43');
INSERT INTO participantes VALUES (20, 'CINDHY MEDALY', 'CCCCC', 1, '33311133', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, '2023-05-23 20:11:29');
INSERT INTO participantes VALUES (21, 'JORGE ', 'GARCIA CHAVEZ', 1, '00881133', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, '2023-05-26 13:01:04');
INSERT INTO participantes VALUES (22, 'MIGUEL ANGEL', 'CALLE Z', 1, '00991166', NULL, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'A', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 22, '2023-06-08 16:19:10');


--
-- TOC entry 2159 (class 0 OID 0)
-- Dependencies: 184
-- Name: participantes_participante_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('participantes_participante_id_seq', 22, true);


--
-- TOC entry 2131 (class 0 OID 21784)
-- Dependencies: 202
-- Data for Name: permisos; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO permisos VALUES (1, 1, 1, 4, 'S', 'admin', '2023-05-23 16:04:36', 'A');
INSERT INTO permisos VALUES (2, 1, 1, 4, 'E', 'admin', '2023-05-23 16:48:13', 'A');
INSERT INTO permisos VALUES (3, 1, 1, 4, 'S', 'admin', '2023-05-23 17:14:09', 'A');
INSERT INTO permisos VALUES (4, 1, 1, 4, 'E', 'admin', '2023-05-23 17:18:18', 'A');
INSERT INTO permisos VALUES (5, 1, 1, 4, 'E', 'admin', '2023-05-23 17:18:21', 'A');
INSERT INTO permisos VALUES (6, 1, 1, 4, 'E', 'admin', '2023-05-23 17:18:25', 'A');
INSERT INTO permisos VALUES (7, 1, 1, 4, 'S', 'admin', '2023-05-23 17:20:31', 'A');


--
-- TOC entry 2160 (class 0 OID 0)
-- Dependencies: 201
-- Name: permisos_permiso_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('permisos_permiso_id_seq', 7, true);


--
-- TOC entry 2125 (class 0 OID 21607)
-- Dependencies: 196
-- Data for Name: programas; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO programas VALUES (1, 'PROGRAMA 01', '2023-05-01', 1, 1, 'A');
INSERT INTO programas VALUES (2, 'PROMAGRA 02', '2023-05-31', 1, 1, 'A');


--
-- TOC entry 2161 (class 0 OID 0)
-- Dependencies: 195
-- Name: programas_programa_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('programas_programa_id_seq', 2, true);


--
-- TOC entry 2127 (class 0 OID 21654)
-- Dependencies: 198
-- Data for Name: registros; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO registros VALUES (6, 6, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (4, 4, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, 26, 'N', NULL, NULL, '2023-05-10', '12:22:00', '2023-05-31', '12:22:00', NULL);
INSERT INTO registros VALUES (7, 7, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (8, 8, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (9, 9, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (10, 10, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (11, 11, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (12, 12, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (13, 13, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (14, 14, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (15, 15, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (16, 16, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (17, 17, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (20, 20, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO registros VALUES (21, 21, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, 'LATAM', '9863', '2023-05-26', '12:22:00', '2023-05-26', '12:22:00', 'CAJAMARCA');
INSERT INTO registros VALUES (22, 22, NULL, '959543793', NULL, 'jm.zs@hotmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


--
-- TOC entry 2162 (class 0 OID 0)
-- Dependencies: 197
-- Name: registros_registro_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('registros_registro_id_seq', 22, true);


--
-- TOC entry 2123 (class 0 OID 21598)
-- Dependencies: 194
-- Data for Name: tipos_programa; Type: TABLE DATA; Schema: eventos; Owner: -
--

INSERT INTO tipos_programa VALUES (1, 'ALIMENTOS', 'A');
INSERT INTO tipos_programa VALUES (2, 'COLISEO', 'A');


--
-- TOC entry 2163 (class 0 OID 0)
-- Dependencies: 193
-- Name: tipos_programa_tp_id_seq; Type: SEQUENCE SET; Schema: eventos; Owner: -
--

SELECT pg_catalog.setval('tipos_programa_tp_id_seq', 2, true);


SET search_path = public, pg_catalog;

--
-- TOC entry 2117 (class 0 OID 20307)
-- Dependencies: 188
-- Data for Name: pais; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO pais VALUES (1, 'Alemania');
INSERT INTO pais VALUES (2, 'Argentina');
INSERT INTO pais VALUES (3, 'Australia');
INSERT INTO pais VALUES (4, 'Bolivia');
INSERT INTO pais VALUES (5, 'Brasil');
INSERT INTO pais VALUES (6, 'Canada');
INSERT INTO pais VALUES (7, 'Chile');
INSERT INTO pais VALUES (8, 'China');
INSERT INTO pais VALUES (9, 'Colombia');
INSERT INTO pais VALUES (10, 'Corea');
INSERT INTO pais VALUES (11, 'Costa Rica');
INSERT INTO pais VALUES (12, 'Cuba');
INSERT INTO pais VALUES (13, 'Ecuador');
INSERT INTO pais VALUES (14, 'Egipto');
INSERT INTO pais VALUES (15, 'El Salvador');
INSERT INTO pais VALUES (16, 'España');
INSERT INTO pais VALUES (17, 'Estados Unidos');
INSERT INTO pais VALUES (18, 'Francia');
INSERT INTO pais VALUES (19, 'Guatemala');
INSERT INTO pais VALUES (20, 'Haiti');
INSERT INTO pais VALUES (21, 'Holanda');
INSERT INTO pais VALUES (22, 'Honduras');
INSERT INTO pais VALUES (23, 'Inglaterra');
INSERT INTO pais VALUES (24, 'Italia');
INSERT INTO pais VALUES (25, 'Japon');
INSERT INTO pais VALUES (26, 'Mexico');
INSERT INTO pais VALUES (27, 'Nicaragua');
INSERT INTO pais VALUES (28, 'Noruega');
INSERT INTO pais VALUES (29, 'Nueva Zelanda');
INSERT INTO pais VALUES (30, 'Panama');
INSERT INTO pais VALUES (31, 'Paraguay');
INSERT INTO pais VALUES (33, 'Portugal');
INSERT INTO pais VALUES (34, 'Puerto Rico');
INSERT INTO pais VALUES (35, 'Republica Dominicana');
INSERT INTO pais VALUES (36, 'Rusia');
INSERT INTO pais VALUES (37, 'Uruguay');
INSERT INTO pais VALUES (38, 'Venezuela');
INSERT INTO pais VALUES (32, 'Perú');
INSERT INTO pais VALUES (0, 'No Determinado');


--
-- TOC entry 2164 (class 0 OID 0)
-- Dependencies: 189
-- Name: pais_idpais_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('pais_idpais_seq', 1, false);


--
-- TOC entry 2119 (class 0 OID 20313)
-- Dependencies: 190
-- Data for Name: tipodoc; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO tipodoc VALUES (4, 'Pasaporte');
INSERT INTO tipodoc VALUES (6, 'Otros');
INSERT INTO tipodoc VALUES (2, 'Certificado de Nacimiento');
INSERT INTO tipodoc VALUES (3, 'Carnet Extranjeria');
INSERT INTO tipodoc VALUES (5, 'Tarjeta de Servicio Militar');
INSERT INTO tipodoc VALUES (1, 'Documento de Identidad (DNI, Cédula de Identidad)');
INSERT INTO tipodoc VALUES (0, 'Ninguno');


--
-- TOC entry 2165 (class 0 OID 0)
-- Dependencies: 191
-- Name: tipodoc_idtipodoc_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('tipodoc_idtipodoc_seq', 1, false);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 2105 (class 0 OID 17615)
-- Dependencies: 176
-- Data for Name: log_sistema; Type: TABLE DATA; Schema: seguridad; Owner: -
--

INSERT INTO log_sistema VALUES (1, NULL, '2023-05-01 08:16:09', 'admin', NULL, 0, 8, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (2, NULL, '2023-05-01 08:16:24', 'admin', NULL, 0, 9, '::1', 'insertar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (3, NULL, '2023-05-01 08:58:55', 'admin', NULL, 0, 1, '::1', 'modificar', 'eventos.eventos');
INSERT INTO log_sistema VALUES (4, NULL, '2023-05-01 11:21:42', 'admin', NULL, 0, 9, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (5, NULL, '2023-05-01 11:21:46', 'admin', NULL, 0, 8, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (6, NULL, '2023-05-01 11:22:04', 'admin', NULL, 0, 10, '::1', 'insertar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (7, NULL, '2023-05-01 22:16:12', 'admin', NULL, 0, 10, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (8, NULL, '2023-05-01 22:16:17', 'admin', NULL, 0, 9, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (9, NULL, '2023-05-01 22:31:35', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.programas');
INSERT INTO log_sistema VALUES (10, NULL, '2023-05-01 22:33:01', 'admin', NULL, 0, 1, '::1', 'modificar', 'eventos.programas');
INSERT INTO log_sistema VALUES (11, NULL, '2023-05-02 17:37:00', 'admin', NULL, 0, 1, '::1', 'modificar', 'eventos.eventos');
INSERT INTO log_sistema VALUES (12, NULL, '2023-05-02 17:37:28', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.eventos');
INSERT INTO log_sistema VALUES (159, NULL, '2023-05-09 22:35:47', 'admin', NULL, 0, 4, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (160, NULL, '2023-05-09 22:35:47', 'admin', NULL, 0, 4, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (161, NULL, '2023-05-09 22:35:47', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (162, NULL, '2023-05-09 22:35:47', 'admin', NULL, 0, 161, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (163, NULL, '2023-05-09 22:35:47', 'admin', NULL, 0, 162, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (164, NULL, '2023-05-10 07:52:34', 'admin', NULL, 0, 5, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (165, NULL, '2023-05-10 07:52:34', 'admin', NULL, 0, 5, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (166, NULL, '2023-05-10 07:52:34', 'admin', NULL, 0, 5, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (167, NULL, '2023-05-10 07:52:35', 'admin', NULL, 0, 166, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (172, NULL, '2023-05-10 07:56:27', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (173, NULL, '2023-05-10 07:56:27', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.registros');
INSERT INTO log_sistema VALUES (174, NULL, '2023-05-10 07:56:27', 'admin', NULL, 0, 173, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (177, NULL, '2023-05-10 11:23:05', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.eventos');
INSERT INTO log_sistema VALUES (191, NULL, '2023-05-10 11:33:48', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (192, NULL, '2023-05-10 11:33:48', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.registros');
INSERT INTO log_sistema VALUES (193, NULL, '2023-05-10 11:33:48', 'admin', NULL, 0, 192, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (196, NULL, '2023-05-10 12:52:57', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (197, NULL, '2023-05-10 12:52:57', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.registros');
INSERT INTO log_sistema VALUES (33, NULL, '2023-05-03 11:23:26', 'admin', NULL, 0, 19, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (34, NULL, '2023-05-03 11:23:26', 'admin', NULL, 0, 33, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (35, NULL, '2023-05-03 11:23:26', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (36, NULL, '2023-05-03 11:24:42', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (37, NULL, '2023-05-03 11:24:42', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (38, NULL, '2023-05-03 11:30:06', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (39, NULL, '2023-05-03 11:30:06', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (40, NULL, '2023-05-03 11:32:11', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (41, NULL, '2023-05-03 11:32:11', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (42, NULL, '2023-05-03 11:32:19', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (43, NULL, '2023-05-03 11:32:19', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (198, NULL, '2023-05-10 12:52:57', 'admin', NULL, 0, 197, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (199, NULL, '2023-05-14 10:07:41', 'web', NULL, NULL, 7, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (200, NULL, '2023-05-14 10:07:41', 'web', NULL, NULL, 7, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (201, NULL, '2023-05-14 10:07:41', 'web', NULL, NULL, 7, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (202, NULL, '2023-05-14 10:07:41', 'web', NULL, NULL, 201, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (203, NULL, '2023-05-14 10:07:42', 'web', NULL, NULL, 202, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (204, NULL, '2023-05-16 11:34:46', 'admin', NULL, 0, 11, '::1', 'insertar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (207, NULL, '2023-05-16 20:34:26', 'admin', NULL, 0, 12, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (216, NULL, '2023-05-16 20:50:52', 'admin', NULL, 0, 10, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (217, NULL, '2023-05-16 20:50:52', 'admin', NULL, 0, 10, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (218, NULL, '2023-05-16 20:50:53', 'admin', NULL, 0, 10, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (219, NULL, '2023-05-16 20:50:53', 'admin', NULL, 0, 218, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (228, NULL, '2023-05-17 15:48:46', 'admin', NULL, 0, 13, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (229, NULL, '2023-05-17 15:48:46', 'admin', NULL, 0, 13, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (230, NULL, '2023-05-17 15:48:46', 'admin', NULL, 0, 13, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (231, NULL, '2023-05-17 15:48:46', 'admin', NULL, 0, 230, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (240, NULL, '2023-05-22 17:04:11', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (243, NULL, '2023-05-22 19:34:15', 'admin', NULL, 0, 4, '::1', 'insertar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (245, NULL, '2023-05-23 09:04:12', 'admin', NULL, 0, 6, '::1', 'insertar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (246, NULL, '2023-05-23 16:04:37', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (249, NULL, '2023-05-23 17:18:18', 'admin', NULL, 0, 4, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (251, NULL, '2023-05-23 17:18:25', 'admin', NULL, 0, 6, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (253, NULL, '2023-05-23 17:41:24', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (260, NULL, '2023-05-23 20:07:43', 'admin', NULL, 0, 17, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (261, NULL, '2023-05-23 20:07:43', 'admin', NULL, 0, 17, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (69, NULL, '2023-05-03 23:25:13', 'admin', NULL, 0, 1, '::1', 'modificar', 'eventos.programas');
INSERT INTO log_sistema VALUES (70, NULL, '2023-05-03 23:25:24', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.programas');
INSERT INTO log_sistema VALUES (262, NULL, '2023-05-23 20:07:43', 'admin', NULL, 0, 17, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (72, NULL, '2023-05-03 23:39:25', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (73, NULL, '2023-05-03 23:39:25', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (74, NULL, '2023-05-03 23:39:38', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (75, NULL, '2023-05-03 23:39:38', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (76, NULL, '2023-05-03 23:48:21', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (263, NULL, '2023-05-23 20:07:43', 'admin', NULL, 0, 262, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (264, NULL, '2023-05-23 20:07:43', 'admin', NULL, 0, 263, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (77, NULL, '2023-05-03 23:48:21', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (78, NULL, '2023-05-03 23:48:23', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (168, NULL, '2023-05-10 07:53:29', 'admin', NULL, 0, 5, '::1', 'eliminar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (80, NULL, '2023-05-03 23:55:41', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (81, NULL, '2023-05-03 23:55:42', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (82, NULL, '2023-05-06 11:12:47', 'admin', NULL, 0, 45, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (83, NULL, '2023-05-06 11:12:47', 'admin', NULL, 0, 45, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (84, NULL, '2023-05-06 11:12:52', 'admin', NULL, 0, 45, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (85, NULL, '2023-05-06 11:16:39', 'admin', NULL, 0, 46, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (86, NULL, '2023-05-06 11:16:39', 'admin', NULL, 0, 46, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (87, NULL, '2023-05-06 11:16:42', 'admin', NULL, 0, 46, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (88, NULL, '2023-05-06 11:18:37', 'admin', NULL, 0, 47, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (89, NULL, '2023-05-06 11:18:37', 'admin', NULL, 0, 47, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (90, NULL, '2023-05-06 11:18:40', 'admin', NULL, 0, 47, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (91, NULL, '2023-05-06 13:54:46', 'admin', NULL, 0, 48, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (92, NULL, '2023-05-06 13:54:46', 'admin', NULL, 0, 48, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (93, NULL, '2023-05-06 13:56:36', 'admin', NULL, 0, 49, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (94, NULL, '2023-05-06 13:56:36', 'admin', NULL, 0, 49, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (95, NULL, '2023-05-06 14:24:20', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (96, NULL, '2023-05-06 14:24:20', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (175, NULL, '2023-05-10 08:50:57', 'admin', NULL, 0, 2, '::1', 'modificar', 'eventos.eventos');
INSERT INTO log_sistema VALUES (98, NULL, '2023-05-06 14:25:32', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (99, NULL, '2023-05-06 14:25:32', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (178, NULL, '2023-05-10 11:24:18', 'admin', NULL, 0, 6, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (101, NULL, '2023-05-06 14:26:50', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (102, NULL, '2023-05-06 14:26:51', 'admin', NULL, 0, 19, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (103, NULL, '2023-05-09 12:39:43', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (104, NULL, '2023-05-09 12:39:43', 'admin', NULL, 0, 1, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (179, NULL, '2023-05-10 11:24:18', 'admin', NULL, 0, 6, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (180, NULL, '2023-05-10 11:24:18', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (181, NULL, '2023-05-10 11:24:18', 'admin', NULL, 0, 180, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (182, NULL, '2023-05-10 11:24:19', 'admin', NULL, 0, 181, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (111, NULL, '2023-05-09 20:56:39', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (112, NULL, '2023-05-09 20:56:39', 'admin', NULL, 0, 111, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (113, NULL, '2023-05-09 20:56:39', 'admin', NULL, 0, 112, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (114, NULL, '2023-05-09 20:56:44', 'admin', NULL, 0, 113, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (194, NULL, '2023-05-10 11:34:15', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (195, NULL, '2023-05-10 11:34:15', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.registros');
INSERT INTO log_sistema VALUES (205, NULL, '2023-05-16 11:36:15', 'admin', NULL, 0, 12, '::1', 'insertar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (208, NULL, '2023-05-16 20:43:16', 'admin', NULL, 0, 8, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (209, NULL, '2023-05-16 20:43:17', 'admin', NULL, 0, 8, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (210, NULL, '2023-05-16 20:43:17', 'admin', NULL, 0, 8, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (211, NULL, '2023-05-16 20:43:17', 'admin', NULL, 0, 210, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (220, NULL, '2023-05-16 20:52:00', 'admin', NULL, 0, 11, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (221, NULL, '2023-05-16 20:52:01', 'admin', NULL, 0, 11, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (222, NULL, '2023-05-16 20:52:01', 'admin', NULL, 0, 11, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (223, NULL, '2023-05-16 20:52:01', 'admin', NULL, 0, 222, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (232, NULL, '2023-05-17 15:49:55', 'admin', NULL, 0, 14, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (233, NULL, '2023-05-17 15:49:55', 'admin', NULL, 0, 14, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (234, NULL, '2023-05-17 15:49:55', 'admin', NULL, 0, 14, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (235, NULL, '2023-05-17 15:49:55', 'admin', NULL, 0, 234, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (241, NULL, '2023-05-22 19:02:01', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (244, NULL, '2023-05-22 19:35:21', 'admin', NULL, 0, 5, '::1', 'insertar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (247, NULL, '2023-05-23 16:48:13', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (133, NULL, '2023-05-09 21:14:08', 'admin', NULL, 0, 7, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (134, NULL, '2023-05-09 21:14:09', 'admin', NULL, 0, 7, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (135, NULL, '2023-05-09 21:14:09', 'admin', NULL, 0, 134, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (136, NULL, '2023-05-09 21:14:13', 'admin', NULL, 0, 135, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (137, NULL, '2023-05-09 22:08:59', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (138, NULL, '2023-05-09 22:08:59', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (139, NULL, '2023-05-09 22:08:59', 'admin', NULL, 0, 138, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (140, NULL, '2023-05-09 22:09:03', 'admin', NULL, 0, 139, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (141, NULL, '2023-05-09 22:10:20', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (142, NULL, '2023-05-09 22:10:20', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (143, NULL, '2023-05-09 22:10:20', 'admin', NULL, 0, 1, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (144, NULL, '2023-05-09 22:10:20', 'admin', NULL, 0, 143, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (145, NULL, '2023-05-09 22:10:23', 'admin', NULL, 0, 144, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (146, NULL, '2023-05-09 22:13:56', 'admin', NULL, 0, 1, '::1', 'eliminar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (147, NULL, '2023-05-09 22:21:24', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (148, NULL, '2023-05-09 22:21:24', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (149, NULL, '2023-05-09 22:21:24', 'admin', NULL, 0, 2, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (150, NULL, '2023-05-09 22:21:24', 'admin', NULL, 0, 149, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (151, NULL, '2023-05-09 22:21:24', 'admin', NULL, 0, 150, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (152, NULL, '2023-05-09 22:28:25', 'admin', NULL, 0, 2, '::1', 'eliminar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (153, NULL, '2023-05-09 22:30:31', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (154, NULL, '2023-05-09 22:30:31', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (155, NULL, '2023-05-09 22:30:31', 'admin', NULL, 0, 3, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (156, NULL, '2023-05-09 22:30:31', 'admin', NULL, 0, 155, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (157, NULL, '2023-05-09 22:30:31', 'admin', NULL, 0, 156, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (158, NULL, '2023-05-09 22:30:34', 'admin', NULL, 0, 3, '::1', 'eliminar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (169, NULL, '2023-05-10 07:55:41', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (170, NULL, '2023-05-10 07:55:41', 'admin', NULL, 0, 4, '::1', 'modificar', 'eventos.registros');
INSERT INTO log_sistema VALUES (171, NULL, '2023-05-10 07:55:41', 'admin', NULL, 0, 170, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (176, NULL, '2023-05-10 11:22:55', 'admin', NULL, 0, 2, '::1', 'modificar', 'eventos.eventos');
INSERT INTO log_sistema VALUES (189, NULL, '2023-05-10 11:33:04', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (190, NULL, '2023-05-10 11:33:04', 'admin', NULL, 0, 6, '::1', 'modificar', 'eventos.registros');
INSERT INTO log_sistema VALUES (206, NULL, '2023-05-16 11:36:50', 'admin', NULL, 0, 12, '::1', 'modificar', 'seguridad.modulos');
INSERT INTO log_sistema VALUES (212, NULL, '2023-05-16 20:47:20', 'admin', NULL, 0, 9, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (213, NULL, '2023-05-16 20:47:20', 'admin', NULL, 0, 9, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (214, NULL, '2023-05-16 20:47:20', 'admin', NULL, 0, 9, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (215, NULL, '2023-05-16 20:47:20', 'admin', NULL, 0, 214, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (224, NULL, '2023-05-16 20:54:46', 'admin', NULL, 0, 12, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (225, NULL, '2023-05-16 20:54:46', 'admin', NULL, 0, 12, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (226, NULL, '2023-05-16 20:54:46', 'admin', NULL, 0, 12, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (227, NULL, '2023-05-16 20:54:46', 'admin', NULL, 0, 226, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (236, NULL, '2023-05-17 16:04:44', 'admin', NULL, 0, 15, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (237, NULL, '2023-05-17 16:04:44', 'admin', NULL, 0, 15, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (238, NULL, '2023-05-17 16:04:44', 'admin', NULL, 0, 15, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (239, NULL, '2023-05-17 16:04:44', 'admin', NULL, 0, 238, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (242, NULL, '2023-05-22 19:17:28', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.asistencias');
INSERT INTO log_sistema VALUES (248, NULL, '2023-05-23 17:14:09', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (250, NULL, '2023-05-23 17:18:21', 'admin', NULL, 0, 5, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (252, NULL, '2023-05-23 17:20:31', 'admin', NULL, 0, 7, '::1', 'insertar', 'eventos.permisos');
INSERT INTO log_sistema VALUES (254, NULL, '2023-05-23 20:04:37', 'admin', NULL, 0, 16, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (255, NULL, '2023-05-23 20:04:37', 'admin', NULL, 0, 16, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (256, NULL, '2023-05-23 20:04:37', 'admin', NULL, 0, 16, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (257, NULL, '2023-05-23 20:04:37', 'admin', NULL, 0, 256, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (258, NULL, '2023-05-23 20:04:39', 'admin', NULL, 0, 257, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (259, NULL, '2023-05-23 20:04:40', 'admin', NULL, 0, 258, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (265, NULL, '2023-05-23 20:07:44', 'admin', NULL, 0, 264, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (274, NULL, '2023-05-23 20:11:29', 'admin', NULL, 0, 20, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (275, NULL, '2023-05-23 20:11:29', 'admin', NULL, 0, 20, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (276, NULL, '2023-05-23 20:11:30', 'admin', NULL, 0, 20, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (277, NULL, '2023-05-23 20:11:30', 'admin', NULL, 0, 276, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (278, NULL, '2023-05-23 20:11:30', 'admin', NULL, 0, 277, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (279, NULL, '2023-05-23 20:11:30', 'admin', NULL, 0, 278, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (280, NULL, '2023-05-26 12:33:20', 'admin', NULL, 0, 1, '::1', 'insertar', 'eventos.asistencias_transporte');
INSERT INTO log_sistema VALUES (281, NULL, '2023-05-26 12:41:44', 'admin', NULL, 0, 2, '::1', 'insertar', 'eventos.asistencias_transporte');
INSERT INTO log_sistema VALUES (282, NULL, '2023-05-26 12:55:14', 'admin', NULL, 0, 3, '::1', 'insertar', 'eventos.asistencias_transporte');
INSERT INTO log_sistema VALUES (283, NULL, '2023-05-26 12:57:21', 'admin', NULL, 0, 4, '::1', 'insertar', 'eventos.asistencias_transporte');
INSERT INTO log_sistema VALUES (284, NULL, '2023-05-26 13:01:04', 'admin', NULL, 0, 21, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (285, NULL, '2023-05-26 13:01:04', 'admin', NULL, 0, 21, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (286, NULL, '2023-05-26 13:01:04', 'admin', NULL, 0, 21, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (287, NULL, '2023-05-26 13:01:04', 'admin', NULL, 0, 286, '::1', 'insertar', 'eventos.detalle_eventos');
INSERT INTO log_sistema VALUES (288, NULL, '2023-05-26 13:02:45', 'admin', NULL, 0, 5, '::1', 'insertar', 'eventos.asistencias_transporte');
INSERT INTO log_sistema VALUES (289, NULL, '2023-06-08 16:19:10', 'admin', NULL, 0, 22, '::1', 'insertar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (290, NULL, '2023-06-08 16:19:10', 'admin', NULL, 0, 22, '::1', 'insertar', 'eventos.registros');
INSERT INTO log_sistema VALUES (291, NULL, '2023-06-08 16:19:10', 'admin', NULL, 0, 22, '::1', 'modificar', 'eventos.participantes');
INSERT INTO log_sistema VALUES (292, NULL, '2023-06-08 16:19:10', 'admin', NULL, 0, 291, '::1', 'insertar', 'eventos.detalle_eventos');


--
-- TOC entry 2166 (class 0 OID 0)
-- Dependencies: 171
-- Name: log_sistema_idlog_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('log_sistema_idlog_seq', 1, false);


--
-- TOC entry 2167 (class 0 OID 0)
-- Dependencies: 175
-- Name: log_sistema_idlog_seq1; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('log_sistema_idlog_seq1', 292, true);


--
-- TOC entry 2112 (class 0 OID 17655)
-- Dependencies: 183
-- Data for Name: modulos; Type: TABLE DATA; Schema: seguridad; Owner: -
--

INSERT INTO modulos VALUES (0, 'Modulo Padre', '#', '#', 0, 1, 'C20210619155956', 'A');
INSERT INTO modulos VALUES (1, 'Seguridad', 'fa fa-fw fa-lock', '#', 0, 1, 'C20210927150852', 'A');
INSERT INTO modulos VALUES (2, 'Perfiles', '#', 'perfiles/index', 1, 1, 'C20210618222148', 'A');
INSERT INTO modulos VALUES (3, 'Modulos', '#', 'modulos/index', 1, 2, 'C20210618222158', 'A');
INSERT INTO modulos VALUES (4, 'Usuarios', '#', 'usuarios/index', 1, 3, 'C20210618222246', 'A');
INSERT INTO modulos VALUES (5, 'Permisos', '#', 'permisos/index', 1, 4, 'C20210618222223', 'A');
INSERT INTO modulos VALUES (7, 'Eventos', 'fa fa-fw fa-bus', '#', 0, 2, 'C20230420231728', 'A');
INSERT INTO modulos VALUES (8, 'Participantes', '#', 'participantes/index', 7, 3, 'C20230501112146', 'A');
INSERT INTO modulos VALUES (10, 'Programas', '#', 'programas/index', 7, 2, 'C20230501221612', 'A');
INSERT INTO modulos VALUES (9, 'Eventos', '#', 'eventos/index', 7, 1, 'C20230501221617', 'A');
INSERT INTO modulos VALUES (11, 'Control de Asistencias', '#', 'asistencias/index', 7, 4, 'C20230516113445', 'A');
INSERT INTO modulos VALUES (12, 'Control llegadas de Visitantes', '#', 'llegadas/index', 7, 5, 'C20230516203426', 'A');


--
-- TOC entry 2168 (class 0 OID 0)
-- Dependencies: 172
-- Name: modulos_modulo_id_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('modulos_modulo_id_seq', 1, false);


--
-- TOC entry 2169 (class 0 OID 0)
-- Dependencies: 182
-- Name: modulos_modulo_id_seq1; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('modulos_modulo_id_seq1', 12, true);


--
-- TOC entry 2107 (class 0 OID 17629)
-- Dependencies: 178
-- Data for Name: perfiles; Type: TABLE DATA; Schema: seguridad; Owner: -
--

INSERT INTO perfiles VALUES (0, 'DEVELOPER', 'A');
INSERT INTO perfiles VALUES (1, 'ADMINISTRADOR', 'A');
INSERT INTO perfiles VALUES (2, 'SUB ADMINISTRADOR', 'A');


--
-- TOC entry 2170 (class 0 OID 0)
-- Dependencies: 173
-- Name: perfiles_perfil_id_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('perfiles_perfil_id_seq', 1, false);


--
-- TOC entry 2171 (class 0 OID 0)
-- Dependencies: 177
-- Name: perfiles_perfil_id_seq1; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('perfiles_perfil_id_seq1', 2, true);


--
-- TOC entry 2108 (class 0 OID 17636)
-- Dependencies: 179
-- Data for Name: permisos; Type: TABLE DATA; Schema: seguridad; Owner: -
--

INSERT INTO permisos VALUES (0, 2);
INSERT INTO permisos VALUES (0, 3);
INSERT INTO permisos VALUES (0, 4);
INSERT INTO permisos VALUES (0, 5);
INSERT INTO permisos VALUES (0, 9);
INSERT INTO permisos VALUES (0, 10);
INSERT INTO permisos VALUES (0, 8);
INSERT INTO permisos VALUES (0, 11);
INSERT INTO permisos VALUES (0, 12);


--
-- TOC entry 2110 (class 0 OID 17643)
-- Dependencies: 181
-- Data for Name: usuarios; Type: TABLE DATA; Schema: seguridad; Owner: -
--

INSERT INTO usuarios VALUES (1, 'developer', '$2y$10$/IrqMi3NCWd.sYHKBzJP2OSZZHF14457zEkD4LhkapuDey5Ni2vS.', 'MANUEL', 'MANUEL', 0, 'A');
INSERT INTO usuarios VALUES (2, 'admin', '$2y$10$ucE9j2QWNJJmvT.Zco1rnuQ5cCrBHO.uqjPaZuBOExBweZhe6kXQS', NULL, NULL, 0, 'A');


--
-- TOC entry 2172 (class 0 OID 0)
-- Dependencies: 174
-- Name: usuarios_usuario_id_seq; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('usuarios_usuario_id_seq', 1, false);


--
-- TOC entry 2173 (class 0 OID 0)
-- Dependencies: 180
-- Name: usuarios_usuario_id_seq1; Type: SEQUENCE SET; Schema: seguridad; Owner: -
--

SELECT pg_catalog.setval('usuarios_usuario_id_seq1', 2, true);


SET search_path = eventos, pg_catalog;

--
-- TOC entry 1968 (class 2606 OID 21766)
-- Name: pk_asistencias; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY asistencias
    ADD CONSTRAINT pk_asistencias PRIMARY KEY (asistencia_id);


--
-- TOC entry 1972 (class 2606 OID 21812)
-- Name: pk_asistencias_transporte; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY asistencias_transporte
    ADD CONSTRAINT pk_asistencias_transporte PRIMARY KEY (at_id);


--
-- TOC entry 1960 (class 2606 OID 21725)
-- Name: pk_detalle_eventos; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY detalle_eventos
    ADD CONSTRAINT pk_detalle_eventos PRIMARY KEY (evento_id, participante_id, registro_id);


--
-- TOC entry 1954 (class 2606 OID 20305)
-- Name: pk_eventos; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY eventos
    ADD CONSTRAINT pk_eventos PRIMARY KEY (evento_id);


--
-- TOC entry 1952 (class 2606 OID 17790)
-- Name: pk_participantes; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY participantes
    ADD CONSTRAINT pk_participantes PRIMARY KEY (participante_id);


--
-- TOC entry 1970 (class 2606 OID 21789)
-- Name: pk_permisos; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT pk_permisos PRIMARY KEY (permiso_id);


--
-- TOC entry 1964 (class 2606 OID 21613)
-- Name: pk_programas; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT pk_programas PRIMARY KEY (programa_id);


--
-- TOC entry 1966 (class 2606 OID 21662)
-- Name: pk_registros; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY registros
    ADD CONSTRAINT pk_registros PRIMARY KEY (registro_id);


--
-- TOC entry 1962 (class 2606 OID 21604)
-- Name: pk_tipos_programa; Type: CONSTRAINT; Schema: eventos; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tipos_programa
    ADD CONSTRAINT pk_tipos_programa PRIMARY KEY (tp_id);


SET search_path = public, pg_catalog;

--
-- TOC entry 1956 (class 2606 OID 20322)
-- Name: pais_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY pais
    ADD CONSTRAINT pais_pkey PRIMARY KEY (idpais);


--
-- TOC entry 1958 (class 2606 OID 20324)
-- Name: tipodoc_pkey; Type: CONSTRAINT; Schema: public; Owner: -; Tablespace: 
--

ALTER TABLE ONLY tipodoc
    ADD CONSTRAINT tipodoc_pkey PRIMARY KEY (idtipodoc);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 1942 (class 2606 OID 17626)
-- Name: log_sistema_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: -; Tablespace: 
--

ALTER TABLE ONLY log_sistema
    ADD CONSTRAINT log_sistema_pkey PRIMARY KEY (idlog);


--
-- TOC entry 1950 (class 2606 OID 17661)
-- Name: modulos_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: -; Tablespace: 
--

ALTER TABLE ONLY modulos
    ADD CONSTRAINT modulos_pkey PRIMARY KEY (modulo_id);


--
-- TOC entry 1944 (class 2606 OID 17635)
-- Name: perfiles_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: -; Tablespace: 
--

ALTER TABLE ONLY perfiles
    ADD CONSTRAINT perfiles_pkey PRIMARY KEY (perfil_id);


--
-- TOC entry 1946 (class 2606 OID 17640)
-- Name: permisos_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: -; Tablespace: 
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (perfil_id, modulo_id);


--
-- TOC entry 1948 (class 2606 OID 17652)
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: seguridad; Owner: -; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (usuario_id);


SET search_path = eventos, pg_catalog;

--
-- TOC entry 1986 (class 2606 OID 21767)
-- Name: fk_eventos_asistencias; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias
    ADD CONSTRAINT fk_eventos_asistencias FOREIGN KEY (evento_id) REFERENCES eventos(evento_id);


--
-- TOC entry 1992 (class 2606 OID 21813)
-- Name: fk_eventos_asistencias_transporte; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias_transporte
    ADD CONSTRAINT fk_eventos_asistencias_transporte FOREIGN KEY (evento_id) REFERENCES eventos(evento_id);


--
-- TOC entry 1980 (class 2606 OID 21726)
-- Name: fk_eventos_detalle_eventos; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY detalle_eventos
    ADD CONSTRAINT fk_eventos_detalle_eventos FOREIGN KEY (evento_id) REFERENCES eventos(evento_id);


--
-- TOC entry 1989 (class 2606 OID 21790)
-- Name: fk_eventos_permisos; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT fk_eventos_permisos FOREIGN KEY (evento_id) REFERENCES eventos(evento_id);


--
-- TOC entry 1984 (class 2606 OID 21619)
-- Name: fk_eventos_programas; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT fk_eventos_programas FOREIGN KEY (evento_id) REFERENCES eventos(evento_id);


--
-- TOC entry 1979 (class 2606 OID 20335)
-- Name: fk_pais_participantes; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY participantes
    ADD CONSTRAINT fk_pais_participantes FOREIGN KEY (idpais) REFERENCES public.pais(idpais);


--
-- TOC entry 1988 (class 2606 OID 21777)
-- Name: fk_participantes_asistencias; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias
    ADD CONSTRAINT fk_participantes_asistencias FOREIGN KEY (participante_id) REFERENCES participantes(participante_id);


--
-- TOC entry 1993 (class 2606 OID 21818)
-- Name: fk_participantes_asistencias_transporte; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias_transporte
    ADD CONSTRAINT fk_participantes_asistencias_transporte FOREIGN KEY (participante_id) REFERENCES participantes(participante_id);


--
-- TOC entry 1981 (class 2606 OID 21731)
-- Name: fk_participantes_detalle_eventos; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY detalle_eventos
    ADD CONSTRAINT fk_participantes_detalle_eventos FOREIGN KEY (participante_id) REFERENCES participantes(participante_id);


--
-- TOC entry 1991 (class 2606 OID 21800)
-- Name: fk_participantes_permisos; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT fk_participantes_permisos FOREIGN KEY (participante_id) REFERENCES participantes(participante_id);


--
-- TOC entry 1985 (class 2606 OID 21663)
-- Name: fk_participantes_registros; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY registros
    ADD CONSTRAINT fk_participantes_registros FOREIGN KEY (participante_id) REFERENCES participantes(participante_id);


--
-- TOC entry 1987 (class 2606 OID 21772)
-- Name: fk_programas_asistencias; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY asistencias
    ADD CONSTRAINT fk_programas_asistencias FOREIGN KEY (programa_id) REFERENCES programas(programa_id);


--
-- TOC entry 1990 (class 2606 OID 21795)
-- Name: fk_programas_permisos; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT fk_programas_permisos FOREIGN KEY (programa_id) REFERENCES programas(programa_id);


--
-- TOC entry 1982 (class 2606 OID 21736)
-- Name: fk_registros_detalle_eventos; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY detalle_eventos
    ADD CONSTRAINT fk_registros_detalle_eventos FOREIGN KEY (registro_id) REFERENCES registros(registro_id);


--
-- TOC entry 1978 (class 2606 OID 20330)
-- Name: fk_tipodoc_participantes; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY participantes
    ADD CONSTRAINT fk_tipodoc_participantes FOREIGN KEY (idtipodoc) REFERENCES public.tipodoc(idtipodoc);


--
-- TOC entry 1983 (class 2606 OID 21614)
-- Name: fk_tipos_programa_programas; Type: FK CONSTRAINT; Schema: eventos; Owner: -
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT fk_tipos_programa_programas FOREIGN KEY (tp_id) REFERENCES tipos_programa(tp_id);


SET search_path = seguridad, pg_catalog;

--
-- TOC entry 1975 (class 2606 OID 17672)
-- Name: fk_modulos_permisos; Type: FK CONSTRAINT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT fk_modulos_permisos FOREIGN KEY (modulo_id) REFERENCES modulos(modulo_id);


--
-- TOC entry 1977 (class 2606 OID 17752)
-- Name: fk_padres_modulos; Type: FK CONSTRAINT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY modulos
    ADD CONSTRAINT fk_padres_modulos FOREIGN KEY (modulo_padre) REFERENCES modulos(modulo_id);


--
-- TOC entry 1973 (class 2606 OID 17682)
-- Name: fk_perfiles_log_sistema; Type: FK CONSTRAINT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY log_sistema
    ADD CONSTRAINT fk_perfiles_log_sistema FOREIGN KEY (idperfil) REFERENCES perfiles(perfil_id);


--
-- TOC entry 1974 (class 2606 OID 17667)
-- Name: fk_perfiles_permisos; Type: FK CONSTRAINT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY permisos
    ADD CONSTRAINT fk_perfiles_permisos FOREIGN KEY (perfil_id) REFERENCES perfiles(perfil_id);


--
-- TOC entry 1976 (class 2606 OID 17677)
-- Name: fk_perfiles_usuarios; Type: FK CONSTRAINT; Schema: seguridad; Owner: -
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT fk_perfiles_usuarios FOREIGN KEY (perfil_id) REFERENCES perfiles(perfil_id);


-- Completed on 2023-06-10 16:20:49

--
-- PostgreSQL database dump complete
--

