-- #! mysql

-- #{ table.bans
CREATE TABLE IF NOT EXISTS bans(id INT AUTO_INCREMENT PRIMARY KEY, banned_user VARCHAR(30) NOT NULL, event VARCHAR(25), expired TEXT, reason TEXT, staff VARCHAR(30))
-- #}

-- #{ table.duration
CREATE TABLE IF NOT EXISTS duration(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, voted TEXT, donated TEXT, muted TEXT, lastplayed TEXT, totalonline TEXT, warnings INT)
-- #}

-- #{ table.stats
CREATE TABLE IF NOT EXISTS stats(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, kills INT, donated TEXT, deaths INT, coin INT)
-- #}

-- #{ table.staff.stats
CREATE TABLE IF NOT EXISTS staff_stats(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, kicks INT, silenceds INT, reports INT)
-- #}

-- #{ table.kits
CREATE TABLE IF NOT EXISTS kits(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, username VARCHAR(30) NOT NULL)
-- #}

-- #{ table.user_data
CREATE TABLE IF NOT EXISTS user_data(xuid VARCHAR(18) NOT NULL UNIQUE, name VARCHAR(30) NOT NULL, custom_name VARCHAR(30) NULL, alias VARCHAR(25) NULL, skin LONGTEXT)
-- #}

-- #{ alter.table.bans
ALTER TABLE bans AUTO_INCREMENT = 0
-- #}