<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Post;

class IndexController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Constructor method is used to inject dependencies to the controller.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // This is the default "index" action of the controller. It displays the
    // Posts page containing the recent posts.
    public function indexAction()
    {
        // Get recent posts
        $posts = $this->entityManager->getRepository(Post::class)
            ->findBy([],['id' => 'ASC']); //Get all posts ordered by id in ascending order

        // Render the view template
        return new ViewModel([
            'posts' => $posts
        ]);
    }
}