<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'app/models/Product.php';

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->productModel = new Product($pdo);
    }

    public function index()
    {
        // Pagination setup
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $productsPerPage = 6;
        $offset = ($page - 1) * $productsPerPage;

        $category = $_GET['category'] ?? null;
        $search = $_GET['search'] ?? null;
        $products = $this->productModel->getProducts($productsPerPage, $offset, $category, $search);
        $totalProducts = $this->productModel->getTotalProducts($category, $search);
        $totalPages = ceil($totalProducts / $productsPerPage);

        $data = [
            'title' => 'Our Product Catalog',
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'currentCategory' => $category,
            'currentSearch' => $search
        ];

        $this->view('products/index', $data);
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            header('Location: ' . BASE_URL . '/products');
            exit();
        }

        $data = [
            'title' => $product['name'],
            'product' => $product
        ];

        $this->view('products/show', $data);
    }
}
