
--- gestion de iglesias

TRUNCATE iglesias.cargo_miembro RESTART IDENTITY;
TRUNCATE iglesias.controlactmisionera RESTART IDENTITY;
TRUNCATE iglesias.educacion_miembro RESTART IDENTITY;
TRUNCATE iglesias.eleccion RESTART IDENTITY;
TRUNCATE iglesias.institucion RESTART IDENTITY;
TRUNCATE iglesias.laboral_miembro RESTART IDENTITY;
TRUNCATE iglesias.otras_propiedades RESTART IDENTITY;
TRUNCATE iglesias.otrospastores RESTART IDENTITY;
TRUNCATE iglesias.parentesco_miembro RESTART IDENTITY;

TRUNCATE iglesias.historial_altasybajas RESTART IDENTITY;
TRUNCATE iglesias.control_traslados RESTART IDENTITY;
TRUNCATE iglesias.capacitacion_miembro RESTART IDENTITY;
TRUNCATE iglesias.historial_traslados RESTART IDENTITY;
TRUNCATE iglesias.temp_traslados;
TRUNCATE iglesias.miembro RESTART IDENTITY;


TRUNCATE public.procesos RESTART IDENTITY;
TRUNCATE seguridad.log_sistema RESTART IDENTITY;

--- gestion de asambleas

TRUNCATE asambleas.agenda RESTART IDENTITY CASCADE;
TRUNCATE asambleas.delegados RESTART IDENTITY CASCADE;

TRUNCATE asambleas.detalle_asistencia RESTART IDENTITY CASCADE;
TRUNCATE asambleas.asistencia RESTART IDENTITY CASCADE;
TRUNCATE asambleas.comentarios RESTART IDENTITY CASCADE;
TRUNCATE asambleas.detalle_propuestas RESTART IDENTITY CASCADE;

TRUNCATE asambleas.foros RESTART IDENTITY CASCADE;
TRUNCATE asambleas.traduccion_propuestas_elecciones RESTART IDENTITY CASCADE;
TRUNCATE asambleas.traduccion_propuestas_temas RESTART IDENTITY CASCADE;

TRUNCATE asambleas.propuestas_elecciones RESTART IDENTITY CASCADE;
TRUNCATE asambleas.propuestas_origen RESTART IDENTITY CASCADE;
TRUNCATE asambleas.propuestas_temas RESTART IDENTITY CASCADE;
TRUNCATE asambleas.traduccion_resoluciones RESTART IDENTITY CASCADE;
TRUNCATE asambleas.resoluciones RESTART IDENTITY CASCADE;
TRUNCATE asambleas.resultados RESTART IDENTITY CASCADE;
TRUNCATE asambleas.votos RESTART IDENTITY CASCADE;
TRUNCATE asambleas.votaciones RESTART IDENTITY CASCADE;

TRUNCATE asambleas.asambleas RESTART IDENTITY CASCADE;

--- usuario admin para produccion, luego borrar.
INSERT INTO seguridad.usuarios
(usuario_id, usuario_user, usuario_pass, usuario_nombres, usuario_referencia, perfil_id, estado, idmiembro, idtipoacceso)
VALUES(56, 'admin', '$2y$10$/IrqMi3NCWd.sYHKBzJP2OSZZHF14457zEkD4LhkapuDey5Ni2vS.', NULL, NULL, 1, 'A', 87, 4);
