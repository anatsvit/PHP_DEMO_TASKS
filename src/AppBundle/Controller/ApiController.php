<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * Список задач
     * @Route("/api/v1/task", name="tasklist")
     */
    public function listAction(Request $request)
    {
        $tasks = $this->get('app.task')->getTasks(1000, 1);
        
        if (!empty($tasks)) {
            $tasks = array_map(function($task) {
                return $task->toArrayShort();
            }, $tasks);
        }
        
        return new \Symfony\Component\HttpFoundation\JsonResponse($tasks);
    }
    
    /**
     * Задача
     * @Route("/api/v1/task/{id}", name="task", requirements={"id"="\d+"})
     */
    public function taskAction(Request $request)
    {
        $task = $this->get('app.task')
                     ->getTaskById($request->get('id'));
        $taskAsArray = [];
        
        if ($task) {
            $taskAsArray = $task->toArrayFull();
        }
        
        return new \Symfony\Component\HttpFoundation\JsonResponse($taskAsArray);
    }
}
