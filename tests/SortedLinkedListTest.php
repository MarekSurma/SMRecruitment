<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once 'src/elements/IElement.php';
require_once 'src/elements/IntElement.php';
require_once 'src/elements/StringElement.php';
require_once 'src/Node.php';
require_once 'src/SortedLinkedList.php';

final class SortedLinkedListTest extends TestCase
{
    public function testInsertIntegers(): void
    {
        $list = new SortedLinkedList();
        $list->insert(new IntElement(5));
        $list->insert(new IntElement(3));
        $list->insert(new IntElement(7));
        $this->assertSame('[3, 5, 7]', $list->toString());
    }

    public function testInsertStrings(): void
    {
        $list = new SortedLinkedList();
        $list->insert(new StringElement('dog'));
        $list->insert(new StringElement('cat'));
        $list->insert(new StringElement('apple'));
        $this->assertSame('[apple, cat, dog]', $list->toString());
    }

    public function testInsertMixedTypes(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $list = new SortedLinkedList();
        $list->insert(new IntElement(5));
        $list->insert(new StringElement('cat'));
    }

    public function testDeleteCurrent(): void
    {
        $list = new SortedLinkedList();
        $list->insert(new IntElement(5));
        $list->insert(new IntElement(3));
        $list->insert(new IntElement(7));

        $list->rewind();
        $list->next(); // Move to the first element
        $list->next(); // Move to the second element
        $list->deleteCurrent();

        $this->assertSame('[3, 5]', $list->toString());
    }

    public function testDeleteCurrentNoCurrentElement(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $list = new SortedLinkedList();
        $list->deleteCurrent();
    }

    public function testIteration(): void {
        $list = new SortedLinkedList();
        $list->insert(new IntElement(5));
        $list->insert(new IntElement(3));
        $list->insert(new IntElement(7));

        $expectedValues = [3, 5, 7];
        $index = 0;

        foreach ($list as $element) {
            $this->assertInstanceOf(IntElement::class, $element);
            $this->assertEquals($expectedValues[$index], $element->getValue());
            $index++;
        }

        $this->assertEquals(count($expectedValues), $index, "Iterated over the expected number of elements");
    }

    public function testToJson(): void
    {
        $list = new SortedLinkedList();
        $list->insert(new StringElement('dog'));
        $list->insert(new StringElement('cat'));
        $this->assertSame('[{"value":"cat"},{"value":"dog"}]', $list->toJson());
    }

    public function testElementExists(): void {
        $list = new SortedLinkedList();
        $list->insert(new StringElement('apple'));
        $list->insert(new StringElement('banana'));

        // Test for existing elements
        $this->assertTrue($list->elementExists(new StringElement('apple')), "Apple should exist in the list");
        $this->assertTrue($list->elementExists(new StringElement('banana')), "Banana should exist in the list");

        // Test for a non-existing element
        $this->assertFalse($list->elementExists(new StringElement('cherry')), "Cherry should not exist in the list");
    }

    public function testIntElementExists(): void {
        $list = new SortedLinkedList();
        $list->insert(new IntElement(10));
        $list->insert(new IntElement(20));

        // Test for existing elements
        $this->assertTrue($list->elementExists(new IntElement(10)), "10 should exist in the list");
        $this->assertTrue($list->elementExists(new IntElement(20)), "20 should exist in the list");

        // Test for a non-existing element
        $this->assertFalse($list->elementExists(new IntElement(30)), "30 should not exist in the list");
    }
}
