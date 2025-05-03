<?php

class User {
    private $user_id;
    private $name;
    private $email;
    private $password;
    private $role;

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getEmail() { return $this->email; }
    public function setEmail($email) { $this->email = $email; }

    public function getPassword() { return $this->password; }
    public function setPassword($password) { $this->password = $password; }

    public function getRole() { return $this->role; }
    public function setRole($role) { $this->role = $role; }
}
?>