# Calculator Via Container

This is a case study that aims to show one of the possible ways of using a DI Container in PHP language.


## How it works

We are given a `Calculator` class with a magic `__call` method (more on [magic methods](https://github.com/kudashevs/calculator-via-magic)).
During the instantiation process, the `Calculator` class initializes a `Container`, registers all the known operations it
needs to perform calculations, and assigns the container's instance to a property for further use. When the `__call` method
is triggered, a `Calculator` instance asks the container if there is an `Operation` that corresponds to the received method
name. If the suitable `Operation` exists, the container creates an operation's instance with all its required dependencies,
and calculations occurs on this instance. If not, it throws an exception as if there were no such method.

```php
$calculator = new Calculator();
echo $calculator->addition(1, 2); // results in 3
```
for more usage examples, please see the [examples](examples/) folder.

## Notes

By default, the package provides four classes that correspond to the basic math operations (addition, subtraction,
multiplication, division). Each class extends an `Operation` class. The `Operation` class is an abstract class that
obligates its subclasses to implement the `performCalculation` method. It also provides a default implementation for
a `calculate` method and the constructor (every subclass must inject a `Validator` instance during the instantiation). 
The `Division` class uses a `DivisionValidator` with an extended argument validation. For more information see the
[DivisionProvider](src/Providers/DivisionProvider.php) file.

The validation of input arguments is defined in the [Validator](src/Validators/Validator.php) interface. By using the `final`
keyword and the mandatory constructor injection, we force all the `Operation` implementations to use some validation.


## Things to learn

[//]: # (@todo don't forget to update the line numbers)
Things that you can learn from this case study:
- a PSR-11 compatible DI Container, how it works, and [how you can use it](src/Calculator.php#L48)
- how to [use the singleton pattern](src/Container.php#L39) (one of the possible implementations)
- how to [use recursion to resolve dependencies](src/Container.php#L100)
- how to [use final to force the subclasses to use the predefined behavior](src/Operations/Operation.php#L31)


## License

The MIT License (MIT). Please see the [License file](LICENSE.md) for more information.