
GRANT CONNECT ON DATABASE smi_aminiasdimor TO smi_user;

GRANT USAGE ON SCHEMA public TO smi_user;
GRANT USAGE ON SCHEMA iglesias TO smi_user;
GRANT USAGE ON SCHEMA seguridad TO smi_user;

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO smi_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA iglesias TO smi_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA seguridad TO smi_user;


-- GRANT ALL PRIVILEGES ON DATABASE smi_aminiasdimor TO smi_user; -- no funciono

GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO smi_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA iglesias TO smi_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA seguridad TO smi_user;


-- referencia: https://www.it-swarm-es.com/es/postgresql/dar-todos-los-permisos-un-usuario-en-una-base-de-datos/1044566155/


-------------------------


-- PARA PRODUCCION

GRANT CONNECT ON DATABASE smisystem_bd TO smisystem_user;

GRANT USAGE ON SCHEMA public TO smisystem_user;
GRANT USAGE ON SCHEMA eventos TO smisystem_user;
GRANT USAGE ON SCHEMA seguridad TO smisystem_user;


GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO smisystem_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA eventos TO smisystem_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA seguridad TO smisystem_user;


-- GRANT ALL PRIVILEGES ON DATABASE smisystem_bd TO smisystem_user; -- no funciono

GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO smisystem_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA eventos TO smisystem_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA seguridad TO smisystem_user;




------------ para el test


GRANT CONNECT ON DATABASE smi_bd TO smi_user;

GRANT USAGE ON SCHEMA public TO smi_user;
GRANT USAGE ON SCHEMA iglesias TO smi_user;
GRANT USAGE ON SCHEMA seguridad TO smi_user;
GRANT USAGE ON SCHEMA asambleas TO smi_user;

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO smi_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA iglesias TO smi_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA seguridad TO smi_user;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA asambleas TO smi_user;


-- GRANT ALL PRIVILEGES ON DATABASE smi_bd TO smi_user; -- no funciono

GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO smi_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA iglesias TO smi_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA seguridad TO smi_user;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA asambleas TO smi_user;
