<?php

class PageController extends BaseController
{
    /**
     * Display the Privacy Policy page.
     */
    public function privacyPolicy()
    {
        $pageTitle = "Privacy Policy - CraftWise";
        require_once BASE_PATH . 'includes/header.php';
        require_once BASE_PATH . 'app/views/pages/privacy.php';
        require_once BASE_PATH . 'includes/footer.php';
    }

    /**
     * Display the Terms of Service page.
     */
    public function termsOfService()
    {
        $pageTitle = "Terms of Service - CraftWise";
        require_once BASE_PATH . 'includes/header.php';
        require_once BASE_PATH . 'app/views/pages/terms.php';
        require_once BASE_PATH . 'includes/footer.php';
    }
}

