<?php
/**
 * Created by PhpStorm.
 * User: meetalodariya
 * Date: 29/12/19
 * Time: 8:14 PM
 */

namespace App\Controller;


use App\Entity\Task;
use App\Form\MicroPostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TaskController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/form" , name="form_test")
     */
    public function new(Request $request)
    {
        // creates a task object and initializes some data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setName('meet patel');
        $task->setDueDate(new \DateTime('tomorrow'));


        $form = $this->createForm(MicroPostType::class,$task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $data = $form->getData();
            echo ($data->getTask());exit;




            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            return $this->redirectToRoute('task_success');
        }

      /*  $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
          //  ->add('name' , TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->createForm(TaskType::class, $task, [
                'action' => $this->generateUrl('submit_form'),
                'method' => 'POST',
            ]);*/

        return $this->render('new.html.twig', [
            'form' => $form->createView(),  ]);
    }


}