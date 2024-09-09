<?php

namespace Books;

require_once "Database/Connection.php";

use Database\Connection;

class Book
{
    protected int $id;
    protected string $title;
    protected int $authorID;
    protected int $publishedIn;
    protected int $totalPages;
    protected string $imageUrl;
    protected int $categoryID;

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

    public function getAuthorID(): int
    {
        return $this->authorID;
    }

    public function setAuthorID(int $authorID): void
    {
        $this->authorID = $authorID;
    }

    public function getPublishedIn(): int
    {
        return $this->publishedIn;
    }

    public function setPublishedIn(int $publishedIn): void
    {
        $this->publishedIn = $publishedIn;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getCategoryID(): int
    {
        return $this->categoryID;
    }

    public function setCategoryID(int $categoryID): void
    {
        $this->categoryID = $categoryID;
    }


    public function listAllBooks()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare("SELECT books.*, a.id as book_author_id, a.name as book_author_name, a.last_name as book_author_lastname, c.id as book_category_id, c.title as book_category_title FROM books
        JOIN authors a on a.id = books.author_id
        JOIN library.categories c on c.id = books.category_id");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBookById()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare("SELECT books.*, a.id as book_author_id, a.name as book_author_name, a.last_name as book_author_lastname, a.bio as book_author_bio, c.id as book_category_id, c.title as book_category_title FROM books
        JOIN authors a on a.id = books.author_id
        JOIN library.categories c on c.id = books.category_id
        WHERE books.id = :id");

        $stmt->bindParam('id', $this->id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}