-- Yggdrasil API Database Schema
-- MySQL version

-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS yggdrasil_api CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

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
    expires_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP + INTERVAL 30 SECOND, -- 30 second expiration
    FOREIGN KEY (profile_id) REFERENCES profiles(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_tokens_access_token ON tokens(access_token);
CREATE INDEX idx_tokens_client_token ON tokens(client_token);
CREATE INDEX idx_profiles_name ON profiles(name);
CREATE INDEX idx_sessions_server_id ON sessions(server_id);
CREATE INDEX idx_sessions_expires_at ON sessions(expires_at);