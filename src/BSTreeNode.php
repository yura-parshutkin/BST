<?php declare(strict_types=1);

namespace BSTree;

class BSTreeNode
{
    /**
     * @var int
     */
    private $data;

    /**
     * @var BSTreeNode|null
     */
    private $left;

    /**
     * @var BSTreeNode|null
     */
    private $right;

    /**
     * @var BSTreeNode|null
     */
    private $parent;

    /**
     * @param int $data
     */
    public function __construct(int $data)
    {
        $this->data = $data;
    }

    /**
     * @return BSTreeNode|null
     */
    public function getLeft(): ?BSTreeNode
    {
        return $this->left;
    }

    /**
     * @param BSTreeNode|null $left
     *
     * @return BSTreeNode
     */
    public function setLeft(BSTreeNode $left = null): BSTreeNode
    {
        if ($left !== null) {
            $left->setParent($this);
        }

        $this->left = $left;

        return $this;
    }

    /**
     * @return BSTreeNode|null
     */
    public function getRight(): ?BSTreeNode
    {
        return $this->right;
    }

    /**
     * @param BSTreeNode|null $right
     *
     * @return BSTreeNode
     */
    public function setRight(BSTreeNode $right = null): BSTreeNode
    {
        if ($right !== null) {
            $right->setParent($this);
        }

        $this->right = $right;

        return $this;
    }

    /**
     * @return int
     */
    public function getData(): int
    {
        return $this->data;
    }

    /**
     * @return BSTreeNode|null
     */
    public function getParent(): ?BSTreeNode
    {
        return $this->parent;
    }

    /**
     * @param BSTreeNode|null $parent
     *
     * @return BSTreeNode|null
     */
    public function setParent(BSTreeNode $parent = null): ?BSTreeNode
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @param int $data
     *
     * @return BSTreeNode
     */
    public function setData(int $data): BSTreeNode
    {
        $this->data = $data;

        return $this;
    }
}