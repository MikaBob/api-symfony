<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use JMS\Serializer\SerializerInterface as JMSSerializer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     *      name = "api_article_get",
     *      path = "/articles.{_format}/{id}",
     *      requirements = {"id"="\d+"}
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
     *      name = "api_article_get_with_tags",
     *      path = "/articles.{_format}/{tag1}/{tag2?}"
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

    /**
     * @Post("/articles", name = "api_article_post")
     * @ParamConverter("article", converter="fos_rest.request_body")
     * @View(StatusCode = 201)
     */
    public function createArticle(Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($article);
        $em->flush();

        return $this->view($article, Response::HTTP_CREATED, ['Location' => $this->generateUrl('api_article_get', ['id' => $article->getId(), '_format' => 'json', UrlGeneratorInterface::ABSOLUTE_URL])]);
    }
}
