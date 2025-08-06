# Supabase migration guide

The file [`database/schema/supabase_schema.sql`](../database/schema/supabase_schema.sql) contains a PostgreSQL script that recreates the current Laravel schema in a Supabase project. Run it through the Supabase SQL editor or any `psql` connection to apply the schema.

## Type equivalences

| Laravel schema builder | PostgreSQL in Supabase | Notes |
|------------------------|------------------------|-------|
| `$table->id()` | `bigserial` | Auto‑incrementing primary key |
| `$table->string()` | `varchar(255)` | Default length used where none specified |
| `$table->text()`, `$table->mediumText()`, `$table->longText()` | `text` | PostgreSQL uses a single `text` type |
| `$table->timestamp()` | `timestamp with time zone` | Laravel timestamps map to timestamptz |
| `$table->boolean()` | `boolean` | |
| `$table->float('x')` | `double precision` | Used for `reservas.price` |
| `$table->float('x',8,2)` | `numeric(8,2)` | Used for `cursos.price` |
| `$table->unsignedTinyInteger()` | `smallint` | Matches 0‑255 range |
| `$table->enum([...])` | `text` + `CHECK` constraint | Creates explicit allowed values |
| `$table->rememberToken()` | `varchar(100)` | |

## Notable schema adjustments

- **recintos**: original boolean `state` column replaced with `text` values `('Disponible','No disponible','Bloqueado')` and an optional `image` field.
- **reservas**: `beggining_date` and `end_date` were replaced by `start_at` and `end_at` timestamps; new `status` (`'activa'`/`'cancelada'`) and `paid` flag added; old boolean `state` removed.
- **cursos**: price stored as `numeric(8,2)` and state enforced via `CHECK` constraint.
- **inscripciones**: links users and courses with status and payment flags.

Apply the SQL script after creating a new Supabase project. This will create all required tables and constraints to mirror the Laravel application's structure.
