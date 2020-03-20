<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Entity\Post;
use Application\Form\CommentForm;

/**
 * This is the Post controller class of the application where
 * creation, deletion and editing is managed.
 */
class PostController extends AbstractActionController
{
    /**
    * Entity manager.
    * @var Doctrine\ORM\EntityManager
    */
    private $entityManager;

    /**
    * Post manager.
    * @var Application\Service\PostManager
    */
    private $postManager;

    /**
    * Constructor is used for injecting dependencies into the controller.
    */
    public function __construct($entityManager, $postManager)
    {
    $this->entityManager = $entityManager;
    $this->postManager = $postManager;
    }

    /**
     * This method displays a form that allows a user to enter a
     * post title and content to be added to the blog list.
     *
     */
    public function addAction()
    {
        // Create the form.
        $form = new PostForm();

        // Get POST data.
        $data = $this->params()->fromPost();

        // Fill form with data.
        $form->setData($data);
        if ($form->isValid()) {
            // Get validated form data.
            $data = $form->getData();

            // Add new post to database.
            $this->postManager->addNewPost($data);

            // Redirect the user to main page
            return $this->redirect()->toRoute('application');
        }

        // Render the view template.
        return new ViewModel([
        'form' => $form
        ]);
    }

    /**
     * This method displays a form that allows a user to edit a
     * post's title and content to be added to the blog list.
     *
     */
    public function editAction()
    {
        // Create the form.
        $form = new PostForm();

        // Get post ID.
        $postId = $this->params()->fromRoute('id', -1);

        // Find existing post in the database.
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // If it is a POST request, we will be saving entered data
        // to the database
        if ($this->getRequest()->isPost()) {
            // Get POST data.
            $data = $this->params()->fromPost();

            // Fill form with data.
            $form->setData($data);

            if ($form->isValid()) {
                // Get validated form data.
                $data = $form->getData();

                // Add new post to database.
                $this->postManager->updatePost($post, $data);

                // Redirect the user to main page.
                return $this->redirect()->toRoute('application');
            }
        }
        // If we get here, it means we are just fetching the
        // already stored values
        else {
            $data = [
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
            ];

            $form->setData($data);
        }

        // Render the view template.
        return new ViewModel([
            'form' => $form,
            'post' => $post
        ]);
    }

    /**
     * This method deletes a post using post id.
     */
    public function deleteAction()
    {
        // Get 'id' from the URL
        $postId = $this->params()->fromRoute('id', -1);

        // Find the post using the id
        $post = $this->entityManager->getRepository(Post::class)
            ->findOneById($postId);

        // Return 404 if post doesn't exist
        if ($post == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Remove the post
        $this->postManager->removePost($post);

        // Redirect the user to main page.
        return $this->redirect()->toRoute('application');
    }
}
