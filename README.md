# Calculator Via Container

This is a case study that aims to show one of the possible ways of using a dependency injection container in PHP language.


## How it works

We are given a `Calculator` class with a magic `__call` method (more on [magic methods](https://github.com/kudashevs/calculator-via-magic)).
During the instantiation process, the `Calculator` class initializes a `Container`, registers all the known operations it
needs to perform calculations, and assigns the container's instance to a property for further use. When the `__call` method
is triggered, a `Calculator` instance asks the container if there is an `Operation` that corresponds to a received method name.
If the suitable `Operation` exists, the container creates an instance of the operation with all its required dependencies,
and calculations happen on this instance. If not, it throws an exception as if there were no such method.

```php
$calculator = new Calculator();
echo $calculator->addition(1, 2); // results in 3
```
for more usage examples, please see the [examples](examples/) folder.