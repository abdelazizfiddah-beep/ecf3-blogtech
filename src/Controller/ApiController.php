<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class ApiController extends AbstractController
{
    #[Route('/articles', name: 'api_articles_list', methods: ['GET'])]
    public function listArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', 'published')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->json($articles);
    }

    #[Route('/articles/{id}', name: 'api_articles_detail', methods: ['GET'])]
    public function showArticle(Article $article): Response
    {
        if ($article->getStatus() !== 'published') {
            return $this->json(['error' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($article);
    }

    #[Route('/categories', name: 'api_categories_list', methods: ['GET'])]
    public function listCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->json($categories);
    }
}
