-- Demo data for Yggdrasil API
-- MySQL version

USE yggdrasil_api;

-- Insert demo user
INSERT INTO users (id, email, password) VALUES
('123e4567e89b12d3a456426655440000', 'user@samuelchest.com', '$2y$10$examplehash');

-- Insert user property
INSERT INTO user_properties (user_id, name, value) VALUES
('123e4567e89b12d3a456426655440000', 'preferredLanguage', 'zh_CN');

-- Insert demo profile
INSERT INTO profiles (id, user_id, name, model) VALUES
('abcdef0123456789abcdef0123456789', '123e4567e89b12d3a456426655440000', 'PlayerOne', 'default');

-- Insert profile texture property
INSERT INTO profile_properties (profile_id, name, value) VALUES
('abcdef0123456789abcdef0123456789', 'textures', 'eyJ0aW1lc3RhbXAiOjE2MDAwMDAwMDAsInByb2ZpbGVJZCI6ImFiY2RlZjAxMjM0NTY3ODlhYmNkZWYwMTIzNDU2Nzg5IiwicHJvZmlsZU5hbWUiOiJQbGF5ZXIxIiwidGV4dHVyZXMiOnsiU0tJTlMiOnsidXJsIjoiaHR0cDovL2F1dGguc2FtdWVsY2hlc3QuY29tL3RleHR1cmVzL3NraW4ucG5nIn19fQ==');

-- Insert demo token
INSERT INTO tokens (access_token, client_token, user_id, selected_profile_id, issued_at, expires_in_days, state) VALUES
('3a1b2c3d4e5f6g7h8i9j0k', 'client-token-0987654321', '123e4567e89b12d3a456426655440000', 'abcdef0123456789abcdef0123456789', 1650000000000, 15, 'valid');

-- Insert a second demo profile for batch testing
INSERT INTO profiles (id, user_id, name, model) VALUES
('0987654321fedcba0987654321fedcba', '123e4567e89b12d3a456426655440000', 'PlayerTwo', 'slim');

-- Insert profile texture property for second profile
INSERT INTO profile_properties (profile_id, name, value) VALUES
('0987654321fedcba0987654321fedcba', 'textures', 'eyJ0aW1lc3RhbXAiOjE2MDAwMDAwMDAsInByb2ZpbGVJZCI6IjA5ODc2NTQzMjFmZWRjYmEwOTg3NjU0MzIxZmVkY2JhIiwicHJvZmlsZU5hbWUiOiJQbGF5ZXJ0d28iLCJ0ZXh0dXJlcyI6eyJTS0lOIjp7InVybCI6Imh0dHA6Ly9hdXRoLnNhbXVsZWNoZXN0LmNvbS90ZXh0dXJlcy9za2luYmFzZS5wbmcifX19');