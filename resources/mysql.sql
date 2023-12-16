-- #! mysql

-- BANS

-- #{ table.bans
CREATE TABLE IF NOT EXISTS bans(id INT AUTO_INCREMENT PRIMARY KEY, banned_user VARCHAR(30) NOT NULL, event VARCHAR(25), expired TEXT, reason TEXT, staff VARCHAR(30))
-- #}

------------------------------------------

--DURATION (of any shit)

-- #{ table.duration
CREATE TABLE IF NOT EXISTS duration(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, voted TEXT, donated TEXT, muted TEXT, lastplayed TEXT, totalonline TEXT, warnings INT)
-- #}

------------------------------------------

--KILLS AND MURDERS

-- #{ table.murders
CREATE TABLE IF NOT EXISTS murders(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT)
-- #}

-- #{ table.kills
CREATE TABLE IF NOT EXISTS kills(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT)
-- #}

------------------------------------------

--ELO (better called points)

-- #{ table.points
CREATE TABLE IF NOT EXISTS points(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT)
-- #}

------------------------------------------

--STAFF (anything staff, LOL)

-- #{ table.staff.stats
CREATE TABLE IF NOT EXISTS staff_stats(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, kicks INT, silenceds INT, reports INT)
-- #}

------------------------------------------

--WON EVENTS (Yes, it will have records of all the events you won, damn pro....)

-- #{ table.won_events
CREATE TABLE IF NOT EXISTS won_events(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, username VARCHAR(30) NOT NULL, title TEXT, description VARCHAR(100), prize VARCHAR(30))
-- #}

------------------------------------------

--KITS
-- #{ table.kits
CREATE TABLE IF NOT EXISTS kits(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, username VARCHAR(30) NOT NULL)
-- #}

------------------------------------------

--user data, obviously

-- #{ table.user_data
CREATE TABLE IF NOT EXISTS user_data(xuid VARCHAR(18) NOT NULL UNIQUE, name VARCHAR(30) NOT NULL, custom_name VARCHAR(30) NULL, alias VARCHAR(25) NULL, language TEXT, skin LONGTEXT, coin INT)
-- #}

------------------------------------------

--SETTINGS (the shitty settings you make that don't even help me masturbate)

-- #{ table.settings
CREATE TABLE IF NOT EXISTS settings(xuid VARCHAR(18) NOT NULL UNIQUE, name VARCHAR(30) NOT NULL, scoreboard BOOLEAN, queue BOOLEAN, cps BOOLEAN, auto_join BOOLEAN)
-- #}

------------------------------------------

-- #{ alter.table.bans
ALTER TABLE bans AUTO_INCREMENT = 0
-- #}