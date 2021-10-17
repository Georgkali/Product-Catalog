<?php

namespace App\Models;



class Product
{
    private string $id;
    private string $productName;
    private int $qty;
    private string $userId;
    private string $category;
    private string $addDate;
    private ?string $lastEditDate;

    public function __construct(string $id, string $productName, int $qty, string $userId, string $category, string $addDate, ?string $lastEditDate = null)
    {
        $this->id = $id;
        $this->productName = $productName;
        $this->qty = $qty;
        $this->userId = $userId;
        $this->category = $category;
        $this->addDate = $addDate;
        $this->lastEditDate = $lastEditDate;
    }


    public function getId(): string
    {
        return $this->id;
    }


    public function getProductName(): string
    {
        return $this->productName;
    }


    public function getQty(): int
    {
        return $this->qty;
    }


    public function getCategory(): string
    {
        return $this->category;
    }


    public function getUserId(): string
    {
        return $this->userId;
    }


    public function getAddDate(): string
    {
        return $this->addDate;
    }


    public function getLastEditDate(): ?string
    {
        return $this->lastEditDate;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }


    public function setCategory(string $category): void
    {
        $this->category = $category;
    }


    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }


    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }


    public function setAddDate(string $addDate): void
    {
        $this->addDate = $addDate;
    }


    public function setLastEditDate(?string $lastEditDate): void
    {
        $this->lastEditDate = $lastEditDate;
    }
}
