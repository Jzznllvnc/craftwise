-- Add Google OAuth fields to users table
-- Run this SQL script in your database to add support for Google Sign-In

ALTER TABLE users
ADD COLUMN google_id VARCHAR(255) NULL UNIQUE AFTER email,
ADD COLUMN oauth_provider VARCHAR(50) NULL AFTER google_id,
ADD COLUMN profile_picture VARCHAR(500) NULL AFTER oauth_provider,
ADD COLUMN email_verified TINYINT(1) DEFAULT 0 AFTER profile_picture;

-- Create index for faster lookups
CREATE INDEX idx_google_id ON users(google_id);
CREATE INDEX idx_oauth_provider ON users(oauth_provider);

-- Update existing users to mark them as email verified (since they registered normally)
UPDATE users SET email_verified = 1 WHERE oauth_provider IS NULL;
