<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use JMS\Serializer\SerializerInterface as JMSSerializer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractFOSRestController
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var JMSSerializer
     */
    private $serializer;


    public function __construct(ArticleRepository $articleRepository, JMSSerializer $serializer){
        $this->articleRepository = $articleRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Get(
     *     path = "/articles.{_format}/{id}",
     *     requirements = {"id"="\d+"}
     * )
     * @View()
     */
    public function getArticle($id)
    {
        $article = $this->articleRepository->find($id);

        return $article;
    }
}
