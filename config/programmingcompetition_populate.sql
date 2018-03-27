USE programmingcompetition;

-- create backend admin user
INSERT INTO `teams` (`owner_id`, `team_name`, `deleted`, `backendLogin`, `backendPassword`, `quick_access_code`, `admin`)
VALUES ('1', 'Administrator', '0', 'admin', 'admin', 'none', '1');