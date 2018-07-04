<?php declare(strict_types=1);

namespace BSTree;

use InvalidArgumentException;
use IteratorAggregate;
use RuntimeException;
use SplStack;
use Traversable;

class BSTree implements IteratorAggregate
{
    /**
     * @var BSTreeNode|null
     */
    private $root;

    /**
     * @return Traversable
     */
    public function traversable(): Traversable
    {
        $pendingNodes = new SplStack();
        $node = $this->root;

        while ($pendingNodes->isEmpty() === false || $node !== null) {
            if ($node === null) {
                $node = $pendingNodes->pop();
            }

            yield $node->getData();

            if ($node->getRight()) {
                $pendingNodes->push($node->getRight());
            }

            $node = $node->getLeft();
        }
    }

    /**
     * @param int $data
     */
    public function insert(int $data): void
    {
        if ($this->isEmpty()) {
            $this->root = new BSTreeNode($data);
            return;
        }

        $node = $this->root;
        while (true) {
            if ($data <= $node->getData()) {
                $left = $node->getLeft();
                if ($left === null) {
                    $node->setLeft(new BSTreeNode($data));
                    break;
                }
                /**
                 * @var BSTreeNode $node
                 */
                $node = $left;

            } else {
                $right = $node->getRight();
                if ($right === null) {
                    $node->setRight(new BSTreeNode($data));
                    break;
                }
                /**
                 * @var BSTreeNode $node
                 */
                $node = $right;
            }
        }
    }

    /**
     * @param int $data
     *
     * @return bool
     */
    public function has(int $data): bool
    {
        return (bool)$this->find($data);
    }

    /**
     * @return int
     */
    public function min(): int
    {
        if ($this->isEmpty()) {
            throw new RuntimeException('Tree is empty');
        }

        return $this->minNode($this->root)->getData();
    }

    /**
     * @return int
     */
    public function max(): int
    {
        if ($this->isEmpty()) {
            throw new RuntimeException('Tree is empty');
        }

        return $this->maxNode($this->root)->getData();
    }


    /**
     * @param int $data
     *
     * @return BSTreeNode|null
     */
    private function find(int $data): ?BSTreeNode
    {
        $node = $this->root;

        while ($node !== null && $node->getData() !== $data) {
            if ($data < $node->getData()) {
                /**
                 * @var BSTreeNode $node
                 */
                $node = $node->getLeft();
            } else {
                /**
                 * @var BSTreeNode $node
                 */
                $node = $node->getRight();
            }
        }

        return $node;
    }

    /**
     * @param BSTreeNode $node
     *
     * @return BSTreeNode
     */
    private function minNode(BSTreeNode $node): BSTreeNode
    {
        $left = $node->getLeft();

        return $left
            ? $this->minNode($left)
            : $node;
    }

    /**
     * @param BSTreeNode $node
     *
     * @return BSTreeNode
     */
    private function maxNode(BSTreeNode $node): BSTreeNode
    {
        $right = $node->getRight();

        return $right
            ? $this->maxNode($right)
            : $node;
    }

    /**
     * @param int $data
     *
     * @return bool
     */
    public function remove(int $data): bool
    {
        $node = $this->find($data);

        if ($node === null) {
            return false;
        }

        $this->removeNode($node);

        return true;
    }

    /**
     * @param BSTreeNode $node
     */
    private function removeNode(BSTreeNode $node): void
    {
        $right = $node->getRight();
        $left  = $node->getLeft();

        if ($left === null && $right === null) {
            $this->detachNode($node);
        } else if ($left !== null && $right !== null) {
            $next = $this->minNode($node->getRight());
            $data = $next->getData();

            $this->removeNode($next);
            $node->setData($data);
        } else {
            /**
             * @var BSTreeNode $child
             */
            $child = $left ?? $right;
            $node->setData($child->getData());
            $this->detachNode($child);
        }
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->root === null;
    }

    /**
     * @param BSTreeNode $node
     */
    private function detachNode(BSTreeNode $node): void
    {
        if ($node === $this->root) {
            $this->root = null;
            return;
        }

        $parent = $node->getParent();
        if ($parent === null) {
            throw new InvalidArgumentException(sprintf('Can not detach node for value %d', $node->getData()));
        }

        if ($parent->getLeft() === $node) {
            $parent->setLeft(null);

        } else if ($parent->getRight() === $node) {
            $parent->setRight(null);

        } else {
            throw new InvalidArgumentException(sprintf('Can not detach node for value %d', $node->getData()));
        }
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return $this->traversable();
    }
}