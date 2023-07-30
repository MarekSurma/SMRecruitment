<?php
require_once 'elements/IElement.php';

class Node {
    public ?Node $next = null;
    public IElement $element;

    public function __construct(IElement $element) {
        $this->element = $element;
    }
}
