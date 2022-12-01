-- Drop tables if they do not exist.

DROP TABLE IF EXISTS "member_of_parliament" CASCADE;
DROP TABLE IF EXISTS "club" CASCADE;
DROP TABLE IF EXISTS "speech" CASCADE;
DROP TABLE IF EXISTS "session" CASCADE;
DROP TABLE IF EXISTS "voting" CASCADE;
DROP TABLE IF EXISTS "vote" CASCADE;


CREATE TABLE "member_of_parliament" (
    "id" int4 NOT NULL PRIMARY KEY,
    "name" varchar(255) NOT NULL,
    "day_of_election" date,
    "list" varchar(255) NOT NULL,
    "district" varchar(255) NOT NULL,
    "number_of_votes" int4 NOT NULL,
    "date_of_oath" date,
    "experience_in_parliament" varchar NOT NULL,
    "function_in_club" varchar(255),
    "date_of_birth" date,
    "place_of_birth" varchar(255),
    "education" varchar,
    "finished_school" varchar,
    "profession" varchar(255) NOT NULL
);

CREATE TABLE "club" (
    "id" int4 NOT NULL PRIMARY KEY,
    "name" varchar(255) NOT NULL,
    "abbreviation" varchar(255) NOT NULL
);

ALTER TABLE "member_of_parliament"
ADD COLUMN "club_id" int4 REFERENCES "club" ("id");

CREATE TABLE "speech" (
    "id" int4 NOT NULL PRIMARY KEY,
    "number" int4 NOT NULL,
    "text" text NOT NULL,
    "member_of_parliament_id" int4 NOT NULL REFERENCES "member_of_parliament" ("id")
);

CREATE TABLE "session" (
    "number" int4 NOT NULL PRIMARY KEY,
    "when" varchar(255) NOT NULL
);

ALTER TABLE "speech"
ADD COLUMN "session_number" int4 NOT NULL REFERENCES "session" ("number");

CREATE TABLE "voting" (
    "id" int4 NOT NULL PRIMARY KEY,
    "group_name" varchar NOT NULL,
    "name" varchar NOT NULL
);

ALTER TABLE "voting"
ADD COLUMN "session_number" int4 NOT NULL REFERENCES "session" ("number");

CREATE TABLE "vote" (
    "id" int4 NOT NULL PRIMARY KEY,
    "type" varchar(255) NOT NULL,
    "member_of_parliament_id" int4 NOT NULL REFERENCES "member_of_parliament" ("id"),
    "voting_id" int4 NOT NULL REFERENCES "voting" ("id"),
    "club_of_the_mp_at_the_time" int4 NOT NULL REFERENCES "club" ("id"),

    CONSTRAINT vote_type CHECK (type IN ('za', 'przeciw', 'nieobecny', 'wstrzymano się')) 
);