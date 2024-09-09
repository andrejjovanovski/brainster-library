<?php
namespace Clients;
require_once "./Database/Connection.php";

use Database\Connection;

class Client
{
    protected int $id;
    protected string $name;
    protected string $lastname;
    protected string $username;
    protected string $email;
    protected string $password;
    protected bool $isAdmin;


//    GETTERS
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getlastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

//    SETTERS
    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $lastname
     */
    public function setlastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }


    public function registerNewClient()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('INSERT INTO clients (name, last_name, username, email, password) VALUES (:name, :last_name, :username, :email, :password)');

        $data = [
            'name' => $this->name,
            'last_name' => $this->lastname,
            'username' => $this->username,
            'email'=> $this->email,
            'password'=>$this->password
        ];

        return $stmt->execute($data);

    }

    public function clientLogin()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT * FROM clients WHERE username = :username');

        $stmt->execute(array('username'=>$this->username));
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }


    public function isUsernameAvailable()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT username FROM clients');

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);


    }

}