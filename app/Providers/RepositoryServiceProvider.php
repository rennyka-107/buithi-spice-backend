<?php

namespace App\Providers;

use App\Repositories\CategoryRepository\CategoryRepository;
use App\Repositories\CategoryRepository\CategoryRepositoryInterface;
use App\Repositories\CommentRepository\CommentRepository;
use App\Repositories\CommentRepository\CommentRepositoryInterface;
use App\Repositories\PostRepository\PostRepository;
use App\Repositories\PostRepository\PostRepositoryInterface;
use App\Repositories\ProductRepository\ProductRepository;
use App\Repositories\ProductRepository\ProductRepositoryInterface;
use App\Repositories\SocialRepository\SocialRepository;
use App\Repositories\SocialRepository\SocialRepositoryInterface;
use App\Repositories\UserRepository\UserRepository;
use App\Repositories\UserRepository\UserRepositoryInterface;
use App\Services\CategoryService\CategoryService;
use App\Services\CategoryService\CategoryServiceInterface;
use App\Services\CommentService\CommentService;
use App\Services\CommentService\CommentServiceInterface;
use App\Services\PostService\PostService;
use App\Services\PostService\PostServiceInterface;
use App\Services\ProductService\ProductService;
use App\Services\ProductService\ProductServiceInterface;
use App\Services\SocialService\SocialService;
use App\Services\SocialService\SocialServiceInterface;
use App\Services\UserService\UserService;
use App\Services\UserService\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // User
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Post
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);

        // Category
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);

        // Social
        $this->app->bind(SocialServiceInterface::class, SocialService::class);
        $this->app->bind(SocialRepositoryInterface::class, SocialRepository::class);

        // Comment
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);

        // Product
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
