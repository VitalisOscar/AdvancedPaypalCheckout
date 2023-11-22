## Advanced PayPal Checkout
You can set up the project by following the steps below:
- Clone or download the project
- Setup configurations in `order.php`, `token.php` and `capture.php` as shown:
```php
$config = [
    'BASE_URL' => '<PayPal API base url e.g https://api-m.sandbox.paypal.com/ when in sandbox>',
    'CLIENT_ID' => '<PayPal Client ID>',
    'CLIENT_SECRET' => '<Paypal Client Secret>',
];
```
- Update `index.html`, in the <head> section with the correct paypal client id in the script that loads PayPal's client SDK
```html
    <script src="https://www.paypal.com/sdk/js?components=buttons,card-fields&client-id=<PAYPAL CLIENT ID>"></script>
```

Note that sample configurations have been set for a sandbox paypal account, so the project should still work without the configurations being modified in code.
If you wish to, you can replace the sample values with your own configurations.

- Update the `BASE_URL` variable in the script in `index.html` to the base url of where you are serving the application from e.g http://localhost/paypal-test/
```html
const BASE_URL = 'http://localhost/paypal-test/'
```

- Serve the project on a webserver of choice, open in a browser, and you are ready to make payments

You can open [https://developer.paypal.com/api/rest/sandbox/card-testing/#link-creditcardgeneratorfortesting](https://developer.paypal.com/api/rest/sandbox/card-testing/#link-creditcardgeneratorfortesting) to get sample credit cards to use in making payments while in sandbox