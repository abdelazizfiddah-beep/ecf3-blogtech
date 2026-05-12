<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->createQueryBuilder('a')
            ->andWhere('a.status = :status')
            ->setParameter('status', 'published')
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_show_public', methods: ['GET'])]
    public function showArticle(Article $article): Response
    {
        return $this->render('home/show_article.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/category', name: 'app_category_index_public', methods: ['GET'])]
    public function listCategories(CategoryRepository $categoryRepository): Response
    {
        return $this->render('home/categories.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/{slug}', name: 'app_category_show_public', methods: ['GET'])]
    public function showCategory(Category $category): Response
    {
        $articles = $category->getArticles()->filter(function (Article $article) {
            return $article->getStatus() === 'published';
        });

        return $this->render('home/category_show.html.twig', [
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}
