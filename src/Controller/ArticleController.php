<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use JMS\Serializer\SerializerInterface as JMSSerializer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    /**
     * @Get(
     *     path = "/articles.{_format}/{tag1}/{tag2?}"
     * )
     * @ParamConverter("tag1", options={"mapping": {"tag1": "name"}})
     * @ParamConverter("tag2", options={"mapping": {"tag2": "name"}})
     *
     * @View()
     */
    public function getArticleWithTags(Tag $tag1 = null, Tag $tag2 = null) {

        if( $tag1 === null && $tag2 === null) {
            throw new HttpException(Response::HTTP_NOT_FOUND, "Tags do not exist.");
        }

        $articles = $tag1 === null ? []: $tag1->getArticles();
        $articles[] = $tag2 === null ? [] : $tag2->getArticles();

        return $articles;
    }
}
