BEGIN TRANSACTION;
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
DROP TABLE IF EXISTS "audio";
CREATE TABLE IF NOT EXISTS "audio" (
	"id"	INTEGER,
	"audioName"	TEXT,
	"audioRuntime"	INTEGER,
	"artistIDs"	TEXT DEFAULT '[1]',
	"bandcampID"	TEXT,
	"bandcampHost"	TEXT DEFAULT '//spartalien.bandcamp.com',
	"bandcampSlug"	TEXT,
	"spotifyHost"	TEXT DEFAULT '//open.spotify.com',
	"spotifySlug"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "p420trackHistory";
CREATE TABLE IF NOT EXISTS "p420trackHistory" (
	"id"	INTEGER,
	"sessionNum"	INTEGER NOT NULL,
	"timeStart"	INTEGER,
	"artistName"	TEXT,
	"trackName"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("sessionNum") REFERENCES "p420session"("sessionNum")
);
DROP TABLE IF EXISTS "visual";
CREATE TABLE IF NOT EXISTS "visual" (
	"id"	INTEGER,
	"createdOn"	TEXT,
	"visualName"	TEXT UNIQUE,
	"description"	TEXT,
	"tags"	TEXT DEFAULT '[]',
	"media"	TEXT DEFAULT '[]',
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "stuff";
CREATE TABLE IF NOT EXISTS "stuff" (
	"id"	INTEGER,
	"stuffName"	TEXT UNIQUE,
	"description"	TEXT,
	"media"	TEXT DEFAULT '[]',
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "p420session";
CREATE TABLE IF NOT EXISTS "p420session" (
	"id"	INTEGER,
	"sessionNum"	INTEGER NOT NULL UNIQUE,
	"sessionDate"	TEXT NOT NULL,
	"sessionDur"	INTEGER NOT NULL DEFAULT 0,
	"mixcloudHost"	TEXT NOT NULL DEFAULT '//mixcloud.com',
	"mixcloudSlug"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "exit";
CREATE TABLE IF NOT EXISTS "exit" (
	"id"	INTEGER,
	"linkText"	TEXT NOT NULL,
	"url"	TEXT NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
DROP TABLE IF EXISTS "audioRelease";
CREATE TABLE IF NOT EXISTS "audioRelease" (
	"id"	INTEGER,
	"audioIDs"	TEXT DEFAULT '[]',
	"releaseName"	TEXT,
	"artistIDs"	TEXT DEFAULT '[1]',
	"labelID"	INTEGER,
	"audioReleaseTypeID"	INTEGER,
	"releasedOn"	TEXT,
	"updatedOn"	TEXT,
	"description"	TEXT,
	"credits"	TEXT DEFAULT '[]',
	"thanks"	TEXT DEFAULT '[]',
	"relatedMedia"	TEXT DEFAULT '[]',
	"freeToDownload"	INTEGER DEFAULT 0,
	"bandcampID"	TEXT,
	"bandcampHost"	TEXT DEFAULT '//spartalien.bandcamp.com',
	"bandcampSlug"	TEXT,
	"spotifyHost"	TEXT DEFAULT '//open.spotify.com',
	"spotifySlug"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("audioReleaseTypeID") REFERENCES "audioReleaseType"("id"),
	FOREIGN KEY("labelID") REFERENCES "label"("id")
);
COMMIT;
