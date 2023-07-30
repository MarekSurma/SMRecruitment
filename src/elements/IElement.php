<?php
interface IElement {
    public function toJson(): string;
    public function compareTo(IElement $other): int;
    public function getValue();
}
