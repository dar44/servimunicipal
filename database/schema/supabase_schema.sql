-- Supabase PostgreSQL schema generated from Laravel migrations
-- Run this script in your Supabase project's SQL editor or psql client.

CREATE TABLE users (
    id bigserial PRIMARY KEY,
    name varchar(255) NOT NULL,
    surname varchar(255) NOT NULL,
    dni varchar(255) NOT NULL UNIQUE,
    email varchar(255) NOT NULL UNIQUE,
    email_verified_at timestamp with time zone,
    password varchar(255) NOT NULL,
    phone varchar(255) NOT NULL,
    role varchar(255),
    image varchar(255),
    remember_token varchar(100),
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);

CREATE TABLE password_reset_tokens (
    email varchar(255) PRIMARY KEY,
    token varchar(255) NOT NULL,
    created_at timestamp with time zone
);

CREATE TABLE sessions (
    id varchar(255) PRIMARY KEY,
    user_id bigint REFERENCES users(id) ON DELETE SET NULL,
    ip_address varchar(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);
CREATE INDEX sessions_user_id_index ON sessions (user_id);
CREATE INDEX sessions_last_activity_index ON sessions (last_activity);

CREATE TABLE cache (
    key varchar(255) PRIMARY KEY,
    value text NOT NULL,
    expiration integer NOT NULL
);

CREATE TABLE cache_locks (
    key varchar(255) PRIMARY KEY,
    owner varchar(255) NOT NULL,
    expiration integer NOT NULL
);

CREATE TABLE jobs (
    id bigserial PRIMARY KEY,
    queue varchar(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);
CREATE INDEX jobs_queue_index ON jobs (queue);

CREATE TABLE job_batches (
    id varchar(255) PRIMARY KEY,
    name varchar(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);

CREATE TABLE failed_jobs (
    id bigserial PRIMARY KEY,
    uuid varchar(255) NOT NULL UNIQUE,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE recintos (
    id bigserial PRIMARY KEY,
    name varchar(255) NOT NULL,
    description varchar(255) NOT NULL,
    ubication varchar(255) NOT NULL,
    province varchar(255) NOT NULL,
    postal_code varchar(255) NOT NULL,
    image varchar(255),
    state text NOT NULL DEFAULT 'Disponible' CHECK (state IN ('Disponible','No disponible','Bloqueado')),
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);

CREATE TABLE reservas (
    id bigserial PRIMARY KEY,
    user_id bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    recinto_id bigint NOT NULL REFERENCES recintos(id) ON DELETE CASCADE,
    price double precision NOT NULL,
    start_at timestamp with time zone NOT NULL,
    end_at timestamp with time zone NOT NULL,
    status text NOT NULL DEFAULT 'activa' CHECK (status IN ('activa','cancelada')),
    paid boolean NOT NULL DEFAULT false,
    observations varchar(255),
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);

CREATE TABLE cursos (
    id bigserial PRIMARY KEY,
    name varchar(255) NOT NULL,
    description varchar(255),
    location varchar(255),
    begining_date date,
    end_date date,
    price numeric(8,2) NOT NULL DEFAULT 0,
    state text NOT NULL DEFAULT 'Disponible' CHECK (state IN ('Disponible','No disponible','Cancelado')),
    capacity integer NOT NULL DEFAULT 0,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    image varchar(255)
);

CREATE TABLE inscripciones (
    id bigserial PRIMARY KEY,
    user_id bigint NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    curso_id bigint NOT NULL REFERENCES cursos(id) ON DELETE CASCADE,
    status text NOT NULL DEFAULT 'activa' CHECK (status IN ('activa','cancelada')),
    paid boolean NOT NULL DEFAULT false,
    cancelled_by bigint REFERENCES users(id) ON DELETE SET NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);

