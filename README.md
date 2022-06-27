# magento2-default-async-events
This module is an add-on for the Aligent [magento-async-events](https://github.com/aligent/magento-async-events) module, and adds event triggers for:
- Order save
- Shipment save
- Customer save

## Installation
1. Install the module via composer:
```
composer require aligent/magento2-default-async-events
```
2. (Optional) Install the Aligent [magento2-eventbridge-notifier](https://github.com/aligent/magento2-eventbridge-notifier) module in order to send events to AWS EventBridge
```
composer require aligent/magento2-eventbride-notifier
```
3. Enable modules
```
bin/magento module:enable Aligent_AsyncEvents Aligent_DefaultAsyncEvents Aligent_EventBridge
```
4. Run setup upgrade
```
bin/magento setup:upgrade
```

## Configuration
Configuration options can be found under `Stores -> Configuration -> Services -> Async Events`
- Enable/Disable publication of order events
- Select order statuses for which to send events
- Enable/Disable publication of shipment events
- Enable/Disable publication of customer events

## Event Subscription
This module defines 3 events:
- `sales.order.saved`
- `sales.shipment.saved`
- `customer.saved`

These events can be subscribed to using the REST endpoint `V1/async_event` as described in the [wiki](https://github.com/aligent/magento-async-events/wiki/II.-Getting-Started#creating-subscriptions).
Your API user will require appropriate permissions to subscribe.
