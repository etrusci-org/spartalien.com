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
    crea_year   TEXT NOT NULL,
    runtime     INTEGER NOT NULL,
    bandcamp_id TEXT DEFAULT NULL,

    FOREIGN KEY (artist_id) REFERENCES artist(id),
    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (bandcamp_id)
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
    UNIQUE (name),
    UNIQUE (bandcamp_id)
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


CREATE TABLE phy (
    id          INTEGER NOT NULL,
    name        TEXT NOT NULL,
    description TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE phy_media (
    phy_id INTEGER NOT NULL,
    code   TEXT NOT NULL,

    FOREIGN KEY (phy_id) REFERENCES phy(id),
    PRIMARY KEY (phy_id, code)
);


CREATE TABLE visual (
    id          INTEGER NOT NULL,
    pub_date    TEXT NOT NULL,
    name        TEXT NOT NULL,
    tool        TEXT NOT NULL,
    description TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE visual_media (
    visual_id INTEGER NOT NULL,
    code      TEXT NOT NULL,

    FOREIGN KEY (visual_id) REFERENCES visual(id),
    PRIMARY KEY (visual_id, code)
);


CREATE TABLE stuff (
    id          INTEGER NOT NULL,
    name        TEXT NOT NULL,
    description TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (name)
);


CREATE TABLE stuff_media (
    stuff_id INTEGER NOT NULL,
    code     TEXT NOT NULL,

    FOREIGN KEY (stuff_id) REFERENCES stuff(id),
    PRIMARY KEY (stuff_id, code)
);


CREATE TABLE news (
    id       INTEGER NOT NULL,
    pub_date TEXT NOT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (pub_date)
);


CREATE TABLE news_text (
    news_id INTEGER NOT NULL,
    text    TEXT NOT NULL,

    FOREIGN KEY (news_id) REFERENCES news(id),
    PRIMARY KEY (news_id, text)
);


CREATE TABLE mention (
    id          INTEGER NOT NULL,
    subject     TEXT NOT NULL,
    year        TEXT NOT NULL,
    description TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (subject)
);


CREATE TABLE mention_media (
    mention_id INTEGER NOT NULL,
    code       TEXT NOT NULL,

    FOREIGN KEY (mention_id) REFERENCES mention(id),
    PRIMARY KEY (mention_id, code)
);


CREATE TABLE exit (
    id          INTEGER NOT NULL,
    text        TEXT NOT NULL,
    description TEXT DEFAULT NULL,
    url         TEXT DEFAULT NULL,

    PRIMARY KEY (id AUTOINCREMENT),
    UNIQUE (url)
);


CREATE TABLE p420_session (
    num          INTEGER NOT NULL,
    pub_date     TEXT NOT NULL,
    runtime      INTEGER NOT NULL,
    mixcloud_key TEXT DEFAULT NULL,

    PRIMARY KEY (num),
    UNIQUE (mixcloud_key)
);


CREATE TABLE p420_tracklist (
    session_num INTEGER NOT NULL,
    start_time  INTEGER NOT NULL,
    artist      TEXT NOT NULL,
    track       TEXT NOT NULL,

    FOREIGN KEY (session_num) REFERENCES p420_session(num),
    PRIMARY KEY (session_num, start_time)
);


COMMIT;
