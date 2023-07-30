<?php
require_once 'IElement.php';

class IntElement implements IElement {
    private int $value;

    public function __construct(int $value) {
        $this->value = $value;
    }

    public function toJson(): string {
        return json_encode(['value' => $this->value]);
    }

    public function compareTo(IElement $other): int {
        if ($other instanceof IntElement) {
            return $this->value <=> $other->getValue();
        }
        throw new InvalidArgumentException("Cannot compare IntElement with non-IntElement.");
    }

    public function getValue(): int {
        return $this->value;
    }
}
