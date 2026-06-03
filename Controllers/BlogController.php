<?php
require_once __DIR__ . '/../Models/PostModel.php';

class BlogController
{
    private PostModel $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    public function index(): void
    {
        $category   = $_GET['category'] ?? '';
        $trang      = max(1, (int)($_GET['trang'] ?? 1));
        $limit      = 6;
        $offset     = ($trang - 1) * $limit;
        $posts      = $this->postModel->getPublished($category, $limit, $offset);
        $tongTrang  = (int)ceil($this->postModel->countPublished($category) / $limit);
        $categories = $this->postModel->getCategories();
        require_once __DIR__ . '/../Views/Blog.php';
    }

    public function detail(): void
    {
        $slug = $_GET['slug'] ?? '';
        $post = $this->postModel->findBySlug($slug);
        if (!$post) {
            http_response_code(404);
            header('Location: /index.php?page=blog');
            exit;
        }
        $related = $this->postModel->getRelated($post['Category'], (int)$post['Id']);
        require_once __DIR__ . '/../Views/BlogDetail.php';
    }
}
