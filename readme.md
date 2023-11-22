## Figma Design
[https://www.figma.com/file/MzYVvWTK8jx9iuEp77XIoz/MegaMind-EdTech?type=design&node-id=1%3A2&mode=design&t=5jj4SnKB0VGCzgWd-1](https://www.figma.com/file/MzYVvWTK8jx9iuEp77XIoz/MegaMind-EdTech?type=design&node-id=1%3A2&mode=design&t=5jj4SnKB0VGCzgWd-1)

## Fixing theme challenge
[https://docs.google.com/document/d/1X0d_MDRdbwvtsYCAxutMvJcxOysYCsuvFcOIzFodGzQ/edit?usp=sharing](https://docs.google.com/document/d/1X0d_MDRdbwvtsYCAxutMvJcxOysYCsuvFcOIzFodGzQ/edit?usp=sharing)


## Advanced PayPal Checkout
The payment process follows the following steps:
- A payment order request is initiated from the frontend when a user clicks 'Pay Now' or PayPal button
- The backend receives the order amount, sends a payload to paypal for order creation, returning an order id
- The order id is returned to the frontend.
- If the payment is approved i.e the user completes the payment via paypal or submits a valid card, paypal calls the capture payment function on the frontend.
- The function calls the capture payment backend endpoint, passing the order id received from paypal.
- The backend captures the payment from the payment source and the process is complete.

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
