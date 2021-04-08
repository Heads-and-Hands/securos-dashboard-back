create table if not exists public.migrations
(
	id serial not null
		constraint migrations_pkey
			primary key,
	migration varchar(255) not null,
	batch integer not null
);

alter table public.migrations owner to securos_dashboard;

create table if not exists public.failed_jobs
(
    id bigserial not null
        constraint failed_jobs_pkey
            primary key,
    connection text not null,
    queue text not null,
    payload text not null,
    exception text not null,
    failed_at timestamp(0) default CURRENT_TIMESTAMP not null
);

create table if not exists public.video_cameras
(
    id serial not null
        constraint video_cameras_pkey
            primary key,
    name varchar(255),
    ip varchar(255),
    type smallint not null,
    ip_decode bigint not null,
    ip_server varchar(255),
    ip_server_decode bigint not null,
    status smallint not null,
    status_exploitation smallint not null,
    passport text null,
    approval_at timestamp(0),
    creation_at timestamp(0),
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table public.video_cameras owner to securos_dashboard;

create table if not exists public.job_checks
(
    id serial not null
        constraint video_cameras_pkey
            primary key,
    name varchar(255),
    done boolean default false,
    created_at timestamp(0),
    updated_at timestamp(0)
);

alter table public.job_checks owner to securos_dashboard;

