<?php


namespace App\Responder;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class PostListResponder
 * @package App\Responder
 */
class PostListResponder
{

    /**
     * @var Paginator
     */
    private Paginator $posts;

    /**
     * @var int
     */
    private int $pages;

    /**
     * @var int
     */
    private int $page;

    /**
     * @var int
     */
    private int $limit;

    /**
     * @var array
     */
    private array $range;

    /**
     * PostListResponder constructor.
     * @param array|Paginator $posts
     * @param int $pages
     * @param int $page
     * @param int $limit
     * @param array $range
     */
    public function __construct(Paginator $posts, int $pages, int $page, int $limit, array $range)
    {
        $this->posts = $posts;
        $this->pages = $pages;
        $this->page = $page;
        $this->limit = $limit;
        $this->range = $range;
    }

    /**
     * @return Paginator
     */
    public function getPosts(): Paginator
    {
        return $this->posts;
    }

    /**
     * @return int
     */
    public function getPages(): int
    {
        return $this->pages;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return array
     */
    public function getRange(): array
    {
        return $this->range;
    }

}
