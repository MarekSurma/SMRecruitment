<?php
require_once 'Node.php';
require_once 'elements/IntElement.php';
require_once 'elements/StringElement.php';

class SortedLinkedList implements Iterator {
    private ?Node $head = null;
    private ?Node $currentNode = null;
    private ?string $elementType = null;

    public function insert(IElement $element): void {
        if ($this->elementType === null) {
            $this->elementType = get_class($element);
        } elseif ($this->elementType !== get_class($element)) {
            throw new InvalidArgumentException("Mixed element types are not allowed in the list.");
        }

        $newNode = new Node($element);
        if ($this->head === null || $element->compareTo($this->head->element) < 0) {
            $newNode->next = $this->head;
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next !== null && $element->compareTo($current->next->element) >= 0) {
                $current = $current->next;
            }
            $newNode->next = $current->next;
            $current->next = $newNode;
        }
    }

    public function deleteCurrent(): void {
        if ($this->currentNode === null) {
            throw new InvalidArgumentException("No current element to delete.");
        }

        if ($this->head === $this->currentNode) {
            $this->head = $this->currentNode->next;
        } else {
            $previous = $this->head;
            while ($previous->next !== $this->currentNode) {
                $previous = $previous->next;
            }
            $previous->next = $this->currentNode->next;
        }

        $this->currentNode = null;
    }

    public function elementExists(IElement $element): bool {
        $current = $this->head;
        while ($current !== null) {
            if ($element->compareTo($current->element) === 0) {
                return true;
            }
            $current = $current->next;
        }
        return false;
    }

    public function rewind(): void {
        $this->currentNode = $this->head;
    }

    public function next(): void {
        if ($this->currentNode === null) {
            $this->currentNode = $this->head;
        } else {
            $this->currentNode = $this->currentNode->next;
        }
    }

    public function current(): ?IElement {
        return  $this->currentNode?->element;
    }

    public function key(): ?int {
        return $this->currentNode !== null ? spl_object_id($this->currentNode) : null;
    }

    public function valid(): bool {
        return $this->currentNode !== null;
    }

    public function toString(): string {
        $values = [];
        $current = $this->head;
        while ($current !== null) {
            $values[] = $current->element->getValue();
            $current = $current->next;
        }
        return '[' . implode(', ', $values) . ']';
    }

    public function toJson(): string {
        $elements = [];
        $current = $this->head;
        while ($current !== null) {
            $elements[] = json_decode($current->element->toJson(), true);
            $current = $current->next;
        }
        return json_encode($elements);
    }
}
