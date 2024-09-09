<?php

namespace Categories;

require_once "Database/Connection.php";

use Database\Connection;

class Category
{
    protected int $id;
    protected string $title;
    protected int $isArchived;
    protected string $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getIsArchived(): int
    {
        return $this->isArchived;
    }

    public function setIsArchived(int $isArchived): void
    {
        $this->isArchived = $isArchived;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAllAvailableCategories() {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT * FROM categories WHERE is_archived = 0');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
