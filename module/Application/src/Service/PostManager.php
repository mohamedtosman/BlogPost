<?php
namespace Application\Service;

use Application\Entity\Post;
use Zend\Filter\StaticFilter;

// The PostManager service is responsible for adding new posts.
class PostManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Constructor is used to inject dependencies into the service.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Add new post
     */
    public function addNewPost($data)
    {
        // Create new Post entity and fill it with the
        // appropriate data.
        $post = new Post();
        $post->setTitle($data['title']);
        $post->setContent($data['content']);
        $currentDate = date('Y-m-d H:i:s');
        $post->setDateCreated($currentDate);

        // Persist to databases and apply changes
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    /**
     * Update existing post
     */
    public function updatePost($post, $data)
    {
        // Update existing entity with new data.
        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    /**
     * Remove post from database
     */
    public function removePost($post)
    {
        // Remove post from database and apply changes
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}