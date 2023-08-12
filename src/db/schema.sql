BEGIN TRANSACTION;


CREATE TABLE artist (
    id          INTEGER NOT NULL,
    name        TEXT NOT NULL,
    url         TEXT DEFAULT NULL,
    description TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE label (
    id          INTEGER NOT NULL,
    name        TEXT NOT NULL,
    url         TEXT DEFAULT NULL,
    description TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE track (
    id          INTEGER NOT NULL,
    artist_id   INTEGER NOT NULL,
    name        TEXT NOT NULL,
    runtime     INTEGER NOT NULL,
    bandcamp_id TEXT DEFAULT NULL,

    FOREIGN KEY (artist_id) REFERENCES artist(id),
    PRIMARY KEY (id AUTOINCREMENT)
);


CREATE TABLE track_credit (
    track_id INTEGER NOT NULL,
    line     TEXT NOT NULL,

    FOREIGN KEY (track_id) REFERENCES track(id),
    PRIMARY KEY (track_id, line)
);


CREATE TABLE track_dist (
    track_id INTEGER NOT NULL,
    platform TEXT NOT NULL,
    url      TEXT NOT NULL,

    FOREIGN KEY (track_id) REFERENCES track(id),
    PRIMARY KEY (track_id, platform, url)
);


CREATE TABLE rls (
    id          INTEGER NOT NULL,
    artist_id   INTEGER NOT NULL,
    rls_type_id INTEGER NOT NULL,
    label_id    INTEGER DEFAULT NULL,
    name        TEXT NOT NULL,
    pub_date    TEXT NOT NULL,
    upd_date    TEXT DEFAULT NULL,
    description TEXT DEFAULT NULL,
    is_freedl   INTEGER DEFAULT 0,
    bandcamp_id TEXT DEFAULT NULL,

    FOREIGN KEY (artist_id) REFERENCES artist(id),
    FOREIGN KEY (rls_type_id) REFERENCES rls_type(id),
    FOREIGN KEY (label_id) REFERENCES label(id),
    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE rls_type (
    id   INTEGER NOT NULL,
    name TEXT NOT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE rls_credit (
    rls_id INTEGER NOT NULL,
    line   TEXT NOT NULL,

    FOREIGN KEY (rls_id) REFERENCES rls(id),
    PRIMARY KEY (rls_id, line)
);


CREATE TABLE rls_tracklist (
    rls_id   INTEGER NOT NULL,
    track_id INTEGER NOT NULL,

    FOREIGN KEY (track_id) REFERENCES track(id),
    PRIMARY KEY (rls_id, track_id)
);


CREATE TABLE rls_media (
    rls_id INTEGER NOT NULL,
    code   TEXT NOT NULL,

    FOREIGN KEY (rls_id) REFERENCES rls(id),
    PRIMARY KEY (rls_id, code)
);


CREATE TABLE rls_dist (
    rls_id      INTEGER NOT NULL,
    platform    TEXT NOT NULL,
    url         TEXT NOT NULL,

    FOREIGN KEY (rls_id) REFERENCES rls(id),
    PRIMARY KEY (rls_id, platform, url)
);


COMMIT;
