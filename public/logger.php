<?php
class Logger {
    private $logFile;
    private $logDir;
    private $telegramBotToken;
    private $telegramChatId;

    public function __construct($botToken = '', $chatId = '') {
        $this->logDir = __DIR__ . '/logs';
        $this->logFile = $this->logDir . '/access_' . date('Y-m-d') . '.log';
        $this->telegramBotToken = $botToken;
        $this->telegramChatId = $chatId;
        
        // Create logs directory if it doesn't exist
        if (!file_exists($this->logDir)) {
            mkdir($this->logDir, 0755, true);
        }
        // Send hello message to Telegram when logger starts
        $this->sendToTelegram("🤖 Logger bot started! Hello!");
    }

    private function getClientIP() {
        $ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ip = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ip = $_SERVER['REMOTE_ADDR'];
        return $ip;
    }

    private function getLocationInfo($ip) {
        if ($ip == '127.0.0.1' || $ip == '::1') {
            return 'Localhost';
        }
        
        $details = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
        if ($details && $details->status == 'success') {
            return "{$details->city}, {$details->country}";
        }
        return 'Unknown Location';
    }

    private function getUserAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Unknown';
    }

    private function getRequestInfo() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        return "{$method} {$uri} {$protocol}";
    }

    private function sendToTelegram($message) {
        if (empty($this->telegramBotToken) || empty($this->telegramChatId)) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->telegramBotToken}/sendMessage";
        
        // Prepare the message data
        $data = array(
            'chat_id' => $this->telegramChatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        );

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        
        // Execute the request
        $result = curl_exec($ch);
        
        // Check for errors
        if (curl_errno($ch)) {
            error_log('Telegram API Error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        return $result;
    }

    private function formatTelegramMessage($logData) {
        $emoji = '🔔'; // You can change this emoji
        return sprintf(
            "%s <b>New Access Log</b>\n\n" .
            "🕒 <b>Time:</b> %s\n" .
            "🌐 <b>IP:</b> %s\n" .
            "📍 <b>Location:</b> %s\n" .
            "🔍 <b>Request:</b> %s\n" .
            "📱 <b>Device:</b> %s",
            $emoji,
            $logData['timestamp'],
            $logData['ip'],
            $logData['location'],
            $logData['request'],
            $logData['userAgent']
        );
    }

    public function logAccess() {
        $timestamp = date('Y-m-d H:i:s');
        $ip = $this->getClientIP();
        $location = $this->getLocationInfo($ip);
        $userAgent = $this->getUserAgent();
        $requestInfo = $this->getRequestInfo();

        // Prepare log data
        $logData = array(
            'timestamp' => $timestamp,
            'ip' => $ip,
            'location' => $location,
            'userAgent' => $userAgent,
            'request' => $requestInfo
        );

        // Format log entry for file
        $logEntry = sprintf(
            "[%s] IP: %s | Location: %s | User Agent: %s | Request: %s\n",
            $logData['timestamp'],
            $logData['ip'],
            $logData['location'],
            $logData['userAgent'],
            $logData['request']
        );

        // Save to log file
        file_put_contents($this->logFile, $logEntry, FILE_APPEND | LOCK_EX);

        // Send to Telegram
        $telegramMessage = $this->formatTelegramMessage($logData);
        $this->sendToTelegram($telegramMessage);
    }
}
?> 