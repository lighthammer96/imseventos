
--- eventos

TRUNCATE eventos.participantes RESTART IDENTITY CASCADE;
TRUNCATE eventos.detalle_eventos RESTART IDENTITY CASCADE;


--- usuario admin para produccion, luego borrar.
INSERT INTO seguridad.usuarios
(usuario_id, usuario_user, usuario_pass, usuario_nombres, usuario_referencia, perfil_id, estado, idmiembro, idtipoacceso)
VALUES(56, 'admin', '$2y$10$/IrqMi3NCWd.sYHKBzJP2OSZZHF14457zEkD4LhkapuDey5Ni2vS.', NULL, NULL, 1, 'A', 87, 4);
