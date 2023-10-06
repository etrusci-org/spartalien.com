BEGIN TRANSACTION;


CREATE TABLE IF NOT EXISTS activity (
    client_hash   TEXT NOT NULL,
    last_seen     INTEGER NOT NULL,
    last_location TEXT DEFAULT NULL,

    PRIMARY KEY (client_hash)
);


COMMIT;
