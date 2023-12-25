-- #! mysql

-- #{ table.bans
CREATE TABLE IF NOT EXISTS bans(id INT AUTO_INCREMENT PRIMARY KEY, banned_user VARCHAR(30) NOT NULL, event VARCHAR(25), expired TEXT, reason TEXT, staff VARCHAR(30))
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS duration(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, voted TEXT, donated TEXT, muted TEXT, lastplayed TEXT, totalonline TEXT, time_join_server TEXT, warnings INT)
-- #}

-- #{ duration
-- # { insert
-- #  :xuid string
-- #  :voted string
-- #  :donated string
-- #  :muted string
-- #  :lastplayed string
-- #  :totalonline string
-- #  :time_join_server string
-- #  :warnings int
INSERT INTO duration(xuid, voted, donated, muted, lastplayed, totalonline, warnings) VALUES (:xuid, :voted, :donated, :muted, :lastplayed, :totalonline, :time_join_server, :warnings)
-- #}
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS murders(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT)
-- #}

-- #{ murders
-- # { insert
-- #  :xuid string
-- #  :combo int
-- #  :gapple int
-- #  :nodebuff int
-- #  :trapping int
-- #  :bridge int
-- #  :classic int
INSERT INTO murders(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- #}
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS kills(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT)
-- #}

-- #{ kills
-- # { insert
-- #   :xuid string
-- #   :combo int
-- #   :gapple int
-- #   :nodebuff int
-- #   :trapping int
-- #   :bridge int
-- #   :classic int
INSERT INTO kills(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- #}
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS points(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT)
-- #}

-- #{ points
-- #  { insert
-- #  :xuid string
-- #  :combo int
-- #  :gapple int
-- #  :nodebuff int
-- #  :trapping int
-- #  :bridge int
-- #  :classic int
INSERT INTO points(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- #}
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS staff_stats(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, kicks INT, silenceds INT, reports INT)
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS won_events(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, title TEXT, description VARCHAR(100), prize VARCHAR(30))
-- #}

-- #{ won_events
-- #  { insert
-- #  :xuid string
-- #  :name string
-- #  :title string
-- #  :description string
-- #  :prize string
INSERT INTO won_events(xuid, name, title, description, prize) VALUES (:xuid, :username, :title, :description, :prize)
-- #}
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS kits(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, username VARCHAR(30) NOT NULL)
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS user_data(xuid VARCHAR(18) NOT NULL UNIQUE, name VARCHAR(30) NOT NULL, custom_name VARCHAR(30) NULL, alias VARCHAR(25) NULL, language TEXT, skin LONGTEXT, coin INT)
-- #}

-- #{ user_data
-- #  { insert
-- # :xuid string
-- # :name string
-- # :custom_name string
-- # :alias string
-- # :language: string
-- # :skin string
INSERT INTO user_data(xuid, name, custom_name, alias, language, skin, coin) VALUES (:xuid, :name, :custom_name, :alias, :language, :skin, :coin)
-- #}
-- #}

-- #{ query.declarartion
CREATE TABLE IF NOT EXISTS settings(xuid VARCHAR(18) NOT NULL UNIQUE, scoreboard BOOLEAN, queue BOOLEAN, cps BOOLEAN, auto_join BOOLEAN)
-- #}

-- #{ settings
-- #  { insert
-- #  :xuid string
-- #  :scoreboard bool
-- #  :queue bool
-- #  :cps bool
-- #  :auto_join bool
INSERT INTO settings(xuid, scoreboard, queue, cps, auto_jon) VALUES (:xuid, :scoreboard, :cps, :auto_join)
-- #}
-- #}

-- #{ alter.table.bans
ALTER TABLE bans AUTO_INCREMENT = 0
-- #}