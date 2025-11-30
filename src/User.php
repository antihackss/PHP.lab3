<?php
namespace App;

class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($username, $email, $password, $bgColor = '#ffffff', $textColor = '#000000', $fontSize = '16px')
    {
        $sql = "INSERT INTO {$this->table} (username, email, password, bg_color, text_color, font_size) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([$username, $email, $hashedPassword, $bgColor, $textColor, $fontSize]);
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function updateSettings($userId, $bgColor, $textColor, $fontSize)
    {
        $sql = "UPDATE {$this->table} SET bg_color = ?, text_color = ?, font_size = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$bgColor, $textColor, $fontSize, $userId]);
    }
}