# Overview
In this project I assume that this is a list which can be followed in only one direction so a list element has no reference to the previous element in the list.

As a user of such library I would expect the following things:
- I expect the ability of adding, removing, and iterating through the list
- I want to be able to iterate through this list easier it would be nice if it implemented an Iterator interface which plays nicely with foreach loop
- I want to have the allowed list element types defined. In this case it should be int or string so there are only these two types of elements defined
- If this was a respectable PHP library, it should also be added to the Packagist repository. This was not done here.

## Testing
I added a little docker configuration so that tests can be run outside of the host system.
In order to initiate tests you can run:

```docker build -t my-phpunit-tests . && docker run my-phpunit-tests```

## Here are some examples on how to use the list class:

### Example 1: Creating a List and Inserting Integer Elements
```
$list = new SortedLinkedList();
$list->insert(new IntElement(5));
$list->insert(new IntElement(3));
$list->insert(new IntElement(10));

echo $list->toString(); // Output: '[3, 5, 10]'
```

### Example 2: Deleting the Current Element
```$list = new SortedLinkedList();
$list->insert(new IntElement(5));
$list->next(); // Move to the first element
$list->deleteCurrent();

echo $list->toString(); // Output: '[]'
```

### Example 3: Checking if an Element Exists
```$list = new SortedLinkedList();
$list->insert(new StringElement("apple"));

if ($list->elementExists(new StringElement("apple"))) {
    echo "Apple exists in the list!";
} else {
    echo "Apple doesn't exist in the list!";
}
// Output: "Apple exists in the list!"
```

### Example 4: Iterating through the list
```$list = new SortedLinkedList();
$list->insert(new IntElement(5));
$list->insert(new IntElement(3));
$list->insert(new IntElement(7));

foreach ($list as $element) {
    echo $element->getValue() . " ";
}
// Output: "3 5 7 "
```

### Example 5: Converting List to JSON
```$list = new SortedLinkedList();
$list->insert(new IntElement(5));
$list->insert(new IntElement(3));

$json = $list->toJson();
echo $json; // Output: '[{"value":3},{"value":5}]'
```