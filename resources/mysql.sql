-- #! mysql
-- #{ claude

-- # { init.deaths
CREATE TABLE IF NOT EXISTS deaths(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo1 INT, gapple1 INT, nodebuff1 INT, trapping1 INT, bridge1 INT, classic1 INT);
-- # }

-- # { init.murders
CREATE TABLE IF NOT EXISTS murders(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, combo INT, gapple INT, nodebuff INT, trapping INT, bridge INT, classic INT);
-- # }

-- # { init.bans
CREATE TABLE IF NOT EXISTS bans(id INT AUTO_INCREMENT PRIMARY KEY, banned_user VARCHAR(30) NOT NULL, event VARCHAR(25), expired TEXT, reason TEXT, staff VARCHAR(30));
-- # }

-- # { init.duration
CREATE TABLE IF NOT EXISTS duration(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, firstplayed TEXT, warnings INT, voted TEXT, donated TEXT, muted TEXT, lastplayed TEXT, totalonline TEXT);
-- # }

-- # { init.staff.stats
CREATE TABLE IF NOT EXISTS staff_stats(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, kicks INT, silenceds INT, reports INT);
-- # }

-- # { init.won.events
CREATE TABLE IF NOT EXISTS won_events(xuid VARCHAR(18) NOT NULL UNIQUE PRIMARY KEY, name VARCHAR(30) NOT NULL, title TEXT, description VARCHAR(100), prize VARCHAR(30));
-- # }

-- # { init.user.data
CREATE TABLE IF NOT EXISTS user_data(xuid VARCHAR(18) NOT NULL UNIQUE, name VARCHAR(30) NOT NULL, custom_name VARCHAR(30) NULL, alias VARCHAR(25) NULL, language TEXT, skin LONGTEXT, coin INT, points INT, wins INT, address VARCHAR(18), device TEXT, control TEXT);
-- # }

-- # { init.settings
CREATE TABLE IF NOT EXISTS settings(xuid VARCHAR(18) NOT NULL UNIQUE, scoreboard BOOLEAN, queue BOOLEAN, cps BOOLEAN, auto_join BOOLEAN);
-- # }

-- # { alter.bans
ALTER TABLE bans AUTO_INCREMENT = 0;
-- # }

-- # { duration
-- #  :xuid string
-- #  :firstplayed string
-- #  :warnings int
-- #  :voted string
-- #  :donated string
-- #  :muted string
-- #  :lastplayed string
-- #  :totalonline string
INSERT INTO duration(xuid, firstplayed, warnings, voted, donated, muted, lastplayed, totalonline) VALUES (:xuid, :firstplayed, :warnings, :voted, :donated, :muted, :lastplayed, :totalonline) ON DUPLICATE KEY UPDATE firstplayed=VALUES(firstplayed), warnings=VALUES(warnings), voted=VALUES(voted), donated=VALUES(donated), muted=VALUES(muted), lastplayed=VALUES(lastplayed), totalonline=VALUES(totalonline);
-- # }

-- # { murders
-- #  :xuid string
-- #  :combo int
-- #  :gapple int
-- #  :nodebuff int
-- #  :trapping int
-- #  :bridge int
-- #  :classic int
INSERT INTO murders(xuid, combo, gapple, nodebuff, trapping, bridge, classic) VALUES (:xuid, :combo, :gapple, :nodebuff, :trapping, :bridge, :classic)
-- # }

-- # { deaths
-- #   :xuid string
-- #   :combo1 int
-- #   :gapple1 int
-- #   :nodebuff1 int
-- #   :trapping1 int
-- #   :bridge1 int
-- #   :classic1 int
INSERT INTO deaths(xuid, combo1, gapple1, nodebuff1, trapping1, bridge1, classic1) VALUES (:xuid, :combo1, :gapple1, :nodebuff1, :trapping1, :bridge1, :classic1)
-- # }

-- # { won_events
-- #  :xuid string
-- #  :name string
-- #  :title string
-- #  :description string
-- #  :prize string
INSERT INTO won_events(xuid, name, title, description, prize) VALUES (:xuid, :name, :title, :description, :prize)
-- # }

-- # { user_data
-- # :xuid string
-- # :name string
-- # :custom_name string
-- # :alias string
-- # :language string
-- # :skin string
-- # :coin int
-- # :points int
-- # :wins int
-- # :address string
-- # :device string
-- # :control string
INSERT INTO user_data(xuid, name, custom_name, alias, language, skin, coin, wins, address, device, control) VALUES (:xuid, :name, :custom_name, :alias, :language, :skin, :coin, :points, :wins, :address, :device, :control);
-- # }

-- # { settings
-- #  :xuid string
-- #  :scoreboard bool
-- #  :queue bool
-- #  :cps bool
-- #  :auto_join bool
INSERT INTO settings(xuid, scoreboard, queue, cps, auto_join) VALUES (:xuid, :scoreboard, :queue, :cps, :auto_join)
-- # }

-- #}