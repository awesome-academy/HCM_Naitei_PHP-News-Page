<?php
namespace App\Repositories\Admin;

use App\Repositories\RepositoryInterface;

interface AdminRepositoryInterface extends RepositoryInterface
{
    public function getModel();
    public function chartCountPosts();
}
