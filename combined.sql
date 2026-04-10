-- Yggdrasil API Database Schema and Demo Data
-- MySQL version

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS yggdrasil_api;
USE yggdrasil_api;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id VARCHAR(32) NOT NULL PRIMARY KEY, -- Unsigned UUID (without hyphens)
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Password hash
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- User properties table
CREATE TABLE IF NOT EXISTS user_properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(32) NOT NULL,
    name VARCHAR(255) NOT NULL,
    value TEXT NOT NULL,
    signature TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Profiles table
CREATE TABLE IF NOT EXISTS profiles (
    id VARCHAR(32) NOT NULL PRIMARY KEY, -- Unsigned UUID (without hyphens)
    user_id VARCHAR(32) NOT NULL,
    name VARCHAR(16) NOT NULL UNIQUE, -- Minecraft username (16 chars max)
    model ENUM('default', 'slim') DEFAULT 'default',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Profile properties table (for textures and other properties)
CREATE TABLE IF NOT EXISTS profile_properties (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_id VARCHAR(32) NOT NULL,
    name VARCHAR(255) NOT NULL,
    value TEXT NOT NULL,
    signature TEXT,
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE
);

-- Tokens table
CREATE TABLE IF NOT EXISTS tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    access_token VARCHAR(255) NOT NULL UNIQUE,
    client_token VARCHAR(255) NOT NULL,
    user_id VARCHAR(32) NOT NULL,
    selected_profile_id VARCHAR(32),
    issued_at BIGINT NOT NULL, -- Timestamp in milliseconds
    expires_in_days INT DEFAULT 15,
    state ENUM('valid', 'temporarily_invalid', 'invalid') DEFAULT 'valid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (selected_profile_id) REFERENCES profiles(id) ON DELETE SET NULL
);

-- Sessions table (for join/hasJoined endpoints)
CREATE TABLE IF NOT EXISTS sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_id VARCHAR(32) NOT NULL,
    server_id VARCHAR(255) NOT NULL,
    ip VARCHAR(45), -- IPv4 or IPv6
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP DEFAULT TIMESTAMPADD(SECOND, 30, CURRENT_TIMESTAMP), -- 30 second expiration
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE
);

-- Truncate tables to avoid duplicate entries
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE sessions;
TRUNCATE TABLE tokens;
TRUNCATE TABLE profile_properties;
TRUNCATE TABLE profiles;
TRUNCATE TABLE user_properties;
TRUNCATE TABLE users;
SET FOREIGN_KEY_CHECKS = 1;

-- Create indexes for better performance
CREATE INDEX idx_tokens_access_token ON tokens(access_token);
CREATE INDEX idx_tokens_client_token ON tokens(client_token);
CREATE INDEX idx_profiles_name ON profiles(name);
CREATE INDEX idx_sessions_server_id ON sessions(server_id);
CREATE INDEX idx_sessions_expires_at ON sessions(expires_at);

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