<?php

require __DIR__.'/vendor/autoload.php'; // ใช้ Autoload Composer เพื่อโหลด Firebase SDK

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseConfig {
    private $database;
    private $auth;

    public function __construct() {
        $this->initializeFirebase();
    }

    private function initializeFirebase() {
        // เส้นทางไปยัง Firebase Credentials File
        $serviceAccount = 'D:/Seven Smile/Exchange/firebase_project/serviceAccountKey.json';

        // สร้าง Factory สำหรับ Firebase
        $factory = (new Factory)->withServiceAccount($serviceAccount);

        // กำหนดฐานข้อมูลและการตรวจสอบสิทธิ์ (Auth)
        $this->database = $factory->createDatabase();
        $this->auth = $factory->createAuth();
    }

    public function getDatabase() {
        return $this->database;
    }

    public function getAuth() {
        return $this->auth;
    }
}

// ตัวอย่างการใช้งาน
$firebase = new FirebaseConfig();
$database = $firebase->getDatabase();
$auth = $firebase->getAuth();

?>
