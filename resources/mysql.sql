-- #! mysql

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

-- #{ won_events
-- #  { insert
-- #  :xuid string
-- #  :name string
-- #  :title string
-- #  :description string
-- #  :prize string
INSERT INTO won_events(xuid, name, title, description, prize) VALUES (:xuid, :name, :title, :description, :prize)
-- #}
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

-- #{ settings
-- #  { insert
-- #  :xuid string
-- #  :scoreboard bool
-- #  :queue bool
-- #  :cps bool
-- #  :auto_join bool
INSERT INTO settings(xuid, scoreboard, queue, cps, auto_jon) VALUES (:xuid, :scoreboard, :queue, :cps, :auto_join)
-- #}
-- #}