<?php declare(strict_types=1);

use BSTree\BSTree;
use PHPUnit\Framework\TestCase;

class BSTreeTest extends TestCase
{
    public function testIsEmpty(): void
    {
        $tree = new BSTree();
        $this->assertTrue($tree->isEmpty());
    }

    public function testNotEmptyTree(): void
    {
        $tree = new BSTree();
        $tree->insert(1);
        $this->assertFalse($tree->isEmpty());
    }

    public function testHasElement(): void
    {
        $tree = new BSTree();
        $tree->insert(1);
        $this->assertTrue($tree->has(1));
    }

    public function testElementIsNotExists(): void
    {
        $tree = new BSTree();
        $this->assertFalse($tree->has(1));
    }

    public function testPrefixTraverse(): void
    {
        $tree = new BSTree();

        $tree->insert(8);
        $tree->insert(3);
        $tree->insert(9);
        $tree->insert(11);
        $tree->insert(7);
        $tree->insert(2);

        $expected = [8, 3, 2, 7, 9, 11];

        $this->assertEquals($expected, iterator_to_array($tree));
    }

    public function testRemoveNodeWithoutAnyChild(): void
    {
        $tree = new BSTree();

        $tree->insert(2);
        $tree->insert(3);
        $tree->insert(1);

        $tree->remove(1);

        $expected = [2, 3];
        $this->assertEquals($expected, iterator_to_array($tree));
    }

    public function testRemoveNodeWithOneChild(): void
    {
        $tree = new BSTree();

        $tree->insert(2);
        $tree->insert(3);
        $tree->insert(1);
        $tree->insert(4);

        $tree->remove(1);

        $expected = [2, 3, 4];

        $this->assertEquals($expected, iterator_to_array($tree));
    }

    public function testRemoveNodeWithTwoChild(): void
    {
        $tree = new BSTree();

        $tree->insert(2);
        $tree->insert(3);
        $tree->insert(1);
        $tree->insert(4);

        $tree->remove(3);

        $expected = [2, 1, 4];

        $this->assertEquals($expected, iterator_to_array($tree));
    }

    public function testRemoveNodeRecursive(): void
    {
        $tree = new BSTree();

        $tree->insert(5);
        $tree->insert(9);
        $tree->insert(4);
        $tree->insert(6);
        $tree->insert(7);

        $tree->remove(5);

        $expected = [6, 4, 9, 7];

        $this->assertEquals($expected, iterator_to_array($tree));
    }

    public function testMax(): void
    {
        $tree = new BSTree();
        $tree->insert(4);
        $tree->insert(3);
        $tree->insert(10);

        $this->assertEquals(10, $tree->max());
    }

    public function testMin(): void
    {
        $tree = new BSTree();
        $tree->insert(4);
        $tree->insert(3);
        $tree->insert(10);

        $this->assertEquals(3, $tree->min());
    }

    public function testRemoveRootNode(): void
    {
        $tree = new BSTree();
        $tree->insert(5);
        $tree->remove(5);

        $this->assertTrue($tree->isEmpty());
    }

    public function testRemoveTheSameValues(): void
    {
        $tree = new BSTree();
        $tree->insert(1);
        $tree->insert(1);

        $tree->remove(1);

        $expected = [1];

        $this->assertEquals($expected, iterator_to_array($tree));
    }

    public function testCountable(): void
    {
        $tree = new BSTree();
        $tree->insert(1);
        $tree->insert(2);
        $tree->insert(3);

        $this->assertCount(3, $tree);
    }
}