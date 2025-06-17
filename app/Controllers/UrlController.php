<?php
class UrlController {
    public function index() {
        include '../views/home.php';
    }

    public function shortenUrl() {
        $inputUrl = $_POST['url'] ?? '';
        if (!preg_match('/^https?:\/\/[\w\-\.]+\.[a-z]{2,}(\/\S*)?$/i', $inputUrl)) {
            echo 'Geçersiz URL';
            return;
        }

        $urlModel = new Url();
        $existing = $urlModel->findByOriginal($inputUrl);
        if ($existing) {
            echo "Kısa URL: http://localhost/{$existing['short_code']}";
            return;
        }

        $shortCode = $this->generateShortCode();
        $urlModel->save($inputUrl, $shortCode);
        echo "Yeni Kısa URL: http://localhost/{$shortCode}";
    }

    public function redirect($shortCode) {
        $urlModel = new Url();
        $original = $urlModel->findByShortCode($shortCode);
        if ($original) {
            header("Location: {$original['original_url']}");
            exit;
        } else {
            echo "URL bulunamadı.";
        }
    }

    private function generateShortCode($length = 12) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $bytes = random_bytes($length);
        $code = '';
        foreach (str_split($bytes) as $b) {
            $code .= $chars[ord($b) % strlen($chars)];
        }
        return $code;
    }
}
