<?php
require_once 'IElement.php';

class StringElement implements IElement {
    private string $value;

    public function __construct(string $value) {
        $this->value = $value;
    }

    public function toJson(): string {
        return json_encode(['value' => $this->value]);
    }

    public function compareTo(IElement $other): int {
        if ($other instanceof StringElement) {
            return strcmp($this->value, $other->getValue());
        }
        throw new InvalidArgumentException("Cannot compare StringElement with non-StringElement.");
    }

    public function getValue(): string {
        return $this->value;
    }
}
