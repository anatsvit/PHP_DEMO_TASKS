<?php

namespace AppBundle\Service;

use Symfony\Component\DependencyInjection\Container;

class Task
{
    /**
     * @var Container 
     */
    private $container;
    
    public function __construct(Container $container) 
    {
        $this->container = $container;
    }
    
    /**
    * Возвращает задачи 
    * @param countPerPage integer
    * @param page integer
    * @return array
    */
    public function getTasks($countPerPage, $page)
    {
        $tasks = [];
        
        if ($countPerPage > 0 && $page >= 1 && $page <= $this->getMaxPage($countPerPage)) {
            $startTask = (($page - 1) * $countPerPage) + 1;
            $endTask = $page * $countPerPage;
            //здесь может быть выборка из бд или сначала из кэша, для упрощения генерируем
            for ($i = $startTask; $i <= $endTask; $i++) {
                $tasks[] = \AppBundle\Entity\Task::createById($i);
            }
        }
        
        return $tasks;
    }
    
    public function getTaskById($taskId)
    {
        $task = null;
        
        if ($taskId >= 1) {
            //здесь может быть поиск по id в бд, для упрощения создаем
            $task = \AppBundle\Entity\Task::createById($taskId);
        }
        
        return $task;
    }

    private function getMaxPage($countPerPage)
    {
        $countOfTasks = 1000;
        
        //...
        
        return ceil($countOfTasks / $countPerPage);
    }
}
