# Validation

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
