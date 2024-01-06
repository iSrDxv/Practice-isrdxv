-- #! mysql
-- #{ claude

-- # { init.kills
CREATE TABLE IF NOT EXISTS kills(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT);
-- # }

-- # { init.murders
CREATE TABLE IF NOT EXISTS murders(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT);
-- # }

-- # { init.bans
CREATE TABLE IF NOT EXISTS bans(id INT AUTO_INCREMENT PRIMARY KEY, banned_user VARCHAR(30) NOT NULL, event VARCHAR(25), expired TEXT, reason TEXT, staff VARCHAR(30));
-- # }

-- # { init.duration
CREATE TABLE IF NOT EXISTS duration(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, voted TEXT, donated TEXT, muted TEXT, lastplayed TEXT, totalonline TEXT, time_join_server TEXT, warnings INT);
-- # }

-- # { init.staff.stats
CREATE TABLE IF NOT EXISTS staff_stats(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, kicks INT, silenceds INT, reports INT);
-- # }

-- # { init.won.events
CREATE TABLE IF NOT EXISTS won_events(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, title TEXT, description VARCHAR(100), prize VARCHAR(30));
-- # }

-- # { init.points
CREATE TABLE IF NOT EXISTS points(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT);
-- # }

-- # { init.user.data
CREATE TABLE IF NOT EXISTS user_data(xuid VARCHAR(18) NOT NULL UNIQUE, name VARCHAR(30) NOT NULL, custom_name VARCHAR(30) NULL, alias VARCHAR(25) NULL, language TEXT, skin LONGTEXT, coin INT);
-- # }

-- # { alter.bans
ALTER TABLE bans AUTO_INCREMENT = 0;
-- # }

-- # { insert.duration
-- #  :xuid string
-- #  :voted string
-- #  :donated string
-- #  :muted string
-- #  :lastplayed string
-- #  :totalonline string
-- #  :time_join_server string
-- #  :warnings int
INSERT OR REPLACE INTO duration(xuid, voted, donated, muted, lastplayed, totalonline, warnings) VALUES (:xuid, :voted, :donated, :muted, :lastplayed, :totalonline, :time_join_server, :warnings)
-- # }

-- # { insert.murders
-- #  :xuid string
-- #  :combo int
-- #  :gapple int
-- #  :nodebuff int
-- #  :trapping int
-- #  :bridge int
-- #  :classic int
INSERT OR REPLACE INTO murders(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- # }

-- # { insert.kills
-- #   :xuid string
-- #   :combo int
-- #   :gapple int
-- #   :nodebuff int
-- #   :trapping int
-- #   :bridge int
-- #   :classic int
INSERT OR REPLACE INTO kills(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- # }

-- # { points
-- #  :xuid string
-- #  :combo int
-- #  :gapple int
-- #  :nodebuff int
-- #  :trapping int
-- #  :bridge int
-- #  :classic int
INSERT OR REPLACE INTO points(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- # }

-- # { won_events
-- #  :xuid string
-- #  :name string
-- #  :title string
-- #  :description string
-- #  :prize string
INSERT OR REPLACE INTO won_events(xuid, name, title, description, prize) VALUES (:xuid, :name, :title, :description, :prize)
-- # }

-- # { user_data
-- # :xuid string
-- # :name string
-- # :custom_name string
-- # :alias string
-- # :language string
-- # :skin string
INSERT OR REPLACE INTO user_data(xuid, name, custom_name, alias, language, skin, coin) VALUES (:xuid, :name, :custom_name, :alias, :language, :skin, :coin)
-- # }

-- # { settings
-- #  :xuid string
-- #  :scoreboard bool
-- #  :queue bool
-- #  :cps bool
-- #  :auto_join bool
INSERT OR REPLACE INTO settings(xuid, scoreboard, queue, cps, auto_jon) VALUES (:xuid, :scoreboard, :queue, :cps, :auto_join)
-- # }

-- #}