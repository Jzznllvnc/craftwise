<?php

class GoogleOAuthHelper
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct()
    {
        $this->clientId = GOOGLE_CLIENT_ID;
        $this->clientSecret = GOOGLE_CLIENT_SECRET;
        $this->redirectUri = GOOGLE_REDIRECT_URI;
    }

    /**
     * Generate the Google OAuth authorization URL
     * @return string The authorization URL to redirect users to
     */
    public function getAuthorizationUrl()
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => 'openid https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type' => 'online',
            'prompt' => 'select_account'
        ];

        return GOOGLE_AUTH_URL . '?' . http_build_query($params);
    }

    /**
     * Exchange authorization code for access token
     * @param string $code The authorization code from Google
     * @return array|false The token response or false on failure
     */
    public function getAccessToken($code)
    {
        $params = [
            'code' => $code,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code'
        ];

        $ch = curl_init(GOOGLE_TOKEN_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable for development
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("Google OAuth: cURL error: {$curlError}");
            return false;
        }

        if ($httpCode !== 200) {
            error_log("Google OAuth: Failed to get access token. HTTP Code: {$httpCode}");
            return false;
        }

        return json_decode($response, true);
    }

    /**
     * Get user information from Google using access token
     * @param string $accessToken The access token
     * @return array|false User information or false on failure
     */
    public function getUserInfo($accessToken)
    {
        $ch = curl_init(GOOGLE_USERINFO_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable for development
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            error_log("Google OAuth: Failed to get user info. HTTP Code: {$httpCode}");
            return false;
        }

        return json_decode($response, true);
    }

    /**
     * Verify that Google OAuth is properly configured
     * @return bool True if configured, false otherwise
     */
    public function isConfigured()
    {
        return !empty($this->clientId) && 
               !empty($this->clientSecret) && 
               strpos($this->clientId, 'your-') !== 0 &&
               strpos($this->clientSecret, 'your-') !== 0;
    }
}
