<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TaskRepository")
 */
class Task
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;
    
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;
    
    /**
     * Создать задачу по Id
     * @param integer $taskId
     * @return Task
     */
    public static function createById($taskId)
    {   
        return (new self)->setId($taskId)
                         ->setTitle('Задача ' . $taskId)
                         ->setAuthor('Автор ' . $taskId)
                         ->setStatus('Статус ' . $taskId)
                         ->setDescription('Описание ' . $taskId)
                         ->setDate((new \DateTime())->setTimestamp(time() + ($taskId * 60 * 60)));
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Task
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Task
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Task
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Возвращает задачу в виде массива (Полная информация)
     * @return array
     */
    public function toArrayFull()
    {
        return [
            'id'          => $this->getId(),
            'title'       => $this->getTitle(),
            'date'        => $this->getDate()->format('d.m.Y H:i:s'),
            'author'      => $this->getAuthor(),
            'status'      => $this->getStatus(),
            'description' => $this->getDescription(),
        ];
    }
    
    /**
     * Возвращает задачу в виде массива (Короткая информация)
     * @return array
     */
    public function toArrayShort()
    {
        return [
            'id'          => $this->getId(),
            'title'       => $this->getTitle(),
            'date'        => $this->getDate()->format('d.m.Y H:i:s'),
        ];
    }
}
