<?php

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use Application\Controller\PostController;
use Application\Entity\Post;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\ServiceManager\ServiceManager;


class PostControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = false;
    private $id = 11;

    public function setUp():void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $services = $this->getApplicationServiceLocator();
        $config = $services->get('config');
        unset($config->database->host);
        $services->setAllowOverride(true);
        $services->setService('config', $config);
        $services->setAllowOverride(false);
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(IndexController::class); // as specified in router's controller name alias
        $this->assertControllerClass('IndexController');
        $this->assertMatchedRouteName('home');
    }

    public function testAddActionCanBeAccessed()
    {
        $this->dispatch('/posts/add', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(PostController::class); // as specified in router's controller name alias
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('posts');
    }

    public function testEditActionCanBeAccessed()
    {
        $this->dispatch('/posts/edit/2', 'GET');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(PostController::class); // as specified in router's controller name alias
        $this->assertControllerClass('PostController');
        $this->assertMatchedRouteName('posts');
    }

    public function testAddActionRedirectsAfterValidPost()
    {
        $postData = [
            'id'    => '',
            'title'  => 'Some title',
            'content' => 'some content',
        ];

        $this->dispatch('/posts/add', 'POST', $postData);

        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/application');
    }
}
