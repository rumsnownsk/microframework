<?php

namespace App\Entities;


/**
 * @Entity()
 * @Table(name="books")
 */
class Book
{
    /**
     * @id
     * @Column(type="integer")
     * @GeneratedValue
     */
    public $id;

    /**
     * @Column(type="string",name="title_book", length=32, unique=true, nullable=true)
     */
    public $title;



}