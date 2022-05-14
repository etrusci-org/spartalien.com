BEGIN TRANSACTION;
DROP TABLE IF EXISTS "audioRelease";
CREATE TABLE IF NOT EXISTS "audioRelease" (
	"id"	INTEGER,
	"catalogID"	TEXT DEFAULT 's9ar',
	"audioCatalogIDs"	TEXT DEFAULT '[]',
	"releaseName"	TEXT,
	"artistIDs"	TEXT DEFAULT '[1]',
	"labelID"	INTEGER,
	"audioReleaseTypeID"	INTEGER,
	"releasedOn"	TEXT,
	"updatedOn"	TEXT,
	"description"	TEXT,
	"credits"	TEXT,
	"thanks"	TEXT,
	"relatedMedia"	TEXT,
	"freeToDownload"	INTEGER DEFAULT 0,
	"bandcampID"	TEXT,
	"bandcampHost"	TEXT DEFAULT '//spartalien.bandcamp.com',
	"bandcampSlug"	TEXT,
	"spotifyHost"	TEXT DEFAULT '//open.spotify.com',
	"spotifySlug"	TEXT,
	FOREIGN KEY("audioReleaseTypeID") REFERENCES "audioReleaseType"("id"),
	FOREIGN KEY("labelID") REFERENCES "label"("id"),
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "audio";
CREATE TABLE IF NOT EXISTS "audio" (
	"id"	INTEGER,
	"catalogID"	TEXT,
	"audioName"	TEXT,
	"audioRuntime"	INTEGER,
	"artistIDs"	TEXT DEFAULT '[1]',
	"bandcampID"	TEXT,
	"bandcampHost"	TEXT DEFAULT '//spartalien.bandcamp.com',
	"bandcampSlug"	TEXT,
	"spotifyHost"	TEXT DEFAULT '//open.spotify.com',
	"spotifySlug"	TEXT,
	PRIMARY KEY("id")
);
DROP TABLE IF EXISTS "artist";
CREATE TABLE IF NOT EXISTS "artist" (
	"id"	INTEGER,
	"artistName"	TEXT UNIQUE,
	"artistURL"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "audioReleaseType";
CREATE TABLE IF NOT EXISTS "audioReleaseType" (
	"id"	INTEGER,
	"typeName"	TEXT UNIQUE,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "label";
CREATE TABLE IF NOT EXISTS "label" (
	"id"	INTEGER,
	"labelName"	TEXT UNIQUE,
	"labelURL"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "news";
CREATE TABLE IF NOT EXISTS "news" (
	"id"	INTEGER,
	"postedOn"	TEXT,
	"items"	TEXT DEFAULT '[]',
	PRIMARY KEY("id" AUTOINCREMENT)
);
COMMIT;
