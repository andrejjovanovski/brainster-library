<?php

namespace Comments;
require_once "Database/Connection.php";

use Database\Connection;

class Comment
{
    protected int $id;
    protected int $bookID;
    protected int $clientID;
    protected string $comment;
    protected int $isApproved;
    protected string $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBookID(): int
    {
        return $this->bookID;
    }

    public function setBookID(int $bookID): void
    {
        $this->bookID = $bookID;
    }

    public function getClientID(): int
    {
        return $this->clientID;
    }

    public function setClientID(int $clientID): void
    {
        $this->clientID = $clientID;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getIsApproved(): int
    {
        return $this->isApproved;
    }

    public function setIsApproved(int $isApproved): void
    {
        $this->isApproved = $isApproved;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAllDeclinedComments()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT * FROM comments WHERE is_approved = 2');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllCommentsPendingApproval()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT * FROM comments WHERE is_approved = 0');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllApprovedCommentsByBookID()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT comments.*, clients.name as client_comment_name, clients.last_name as client_comment_lastname
                                             FROM comments 
                                             JOIN clients ON comments.client_id = clients.id
                                             WHERE comments.is_approved = 1 AND comments.book_id = :bookID AND client_id <> :clientID');
        $stmt->execute(array('bookID' => $this->getBookID(), 'clientID' => $this->clientID));
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllClientsCommentsByBookID()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('SELECT comments.*, clients.name as client_comment_name, clients.last_name as client_comment_lastname
                                             FROM comments 
                                             JOIN clients ON comments.client_id = clients.id
                                             WHERE comments.client_id = :clientID AND comments.book_id = :bookID');
        $stmt->execute(array('bookID' => $this->getBookID(), 'clientID' => $this->clientID));
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function addComment()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('INSERT INTO comments (book_id, client_id, comment) VALUES (:bookID, :clientID, :comment)');
        $data = [
            'bookID' => $this->bookID,
            'clientID' => $this->clientID,
            'comment' => $this->comment,
        ];

        return $stmt->execute($data);
    }

    public function deleteComment()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('DELETE FROM comments WHERE id = :id;');
        $stmt->bindValue(':id', $this->getId());
        return $stmt->execute();

    }

    public function approveComment()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('UPDATE comments SET is_approved = 1 WHERE id = :id');
        return $stmt->execute(array('id'=>$this->id));
    }

    public function declineComment()
    {
        $connectionObject = new Connection();
        $connection = $connectionObject->getConnection();

        $stmt = $connection->prepare('UPDATE comments SET is_approved = 2 WHERE id = :id');
        return $stmt->execute(array('id'=>$this->id));
    }
}