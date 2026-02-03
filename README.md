# Validation

[![tests](https://github.com/jjgrainger/Validation/actions/workflows/tests.yml/badge.svg)](https://github.com/jjgrainger/Validation/actions/workflows/tests.yml) [![codecov](https://codecov.io/gh/jjgrainger/Validation/graph/badge.svg?token=44C6GE576O)](https://codecov.io/gh/jjgrainger/Validation) [![Latest Stable Version](https://badgen.net/github/release/jjgrainger/Validation/stable)](https://packagist.org/packages/jjgrainger/Validation) [![Total Downloads](https://badgen.net/packagist/dt/jjgrainger/Validation)](https://packagist.org/packages/jjgrainger/Validation) [![License](https://badgen.net/github/license/jjgrainger/Validation)](https://packagist.org/packages/jjgrainger/Validation)


> Extensible PHP validation

Work in progress...

```php
use Validation\Validator;

// Create a Validator with an array of attributes and rules to validate against.
$validator = Validator::make([
    'name' => 'required',
    'email' => 'required|email',
    'password' => 'required',
    'confirm_password' => 'required|same:password',
]);

// Run input through the Validator and receive the result.
$result = $validator->validate([
    'name' => 'Test',
    'email' => 'example@example.com',
    'password' => 'secret',
    'password_confirm' => 'secret',
]);

// Check results and display messsages.
if ($result->fails()) {
    // Get the first message for an attribute.
    $message = $result->first('name');

    // Get all messages.
    $messages = $result->messages();
}
```
