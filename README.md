DHL Paket Shipping Carrier Update Extension
===========================================

Companion module to the DHL Paket carrier that allows to rewrite the
shipping method's carrier code when placing an order.

Description
-----------

With the introduction of the
[Deutsche Post & DHL Shipping](https://marketplace.magento.com/dhl-shipping-m2.html) module,
a "feature" was removed that turned out to be popular amongst merchants:
the ability to configure multiple shipping methods for processing with DHL Paket.

See [GitHub issue #11](https://github.com/netresearch/dhl-shipping-m2/issues/11).

This module brings back the configuration and `sales_order_place_after` observer
as implemented in the legacy module: The admin user can select a list of
offline shipping methods in the module configuration.

```
Stores → Configuration → Sales → Post & DHL Shipping → DHL Parcel Germany → Checkout Presentation → Additional Shipping Methods for DHL Paket
```
Please note that the DHL service box in checkout will not be displayed for these additional shipping methods.  

The special methods "DHL Paket" and "DHL Paket Returns" can be ignored in the box
"Shipping Methods for DHL Paket".

When an order is placed with one of the selected methods, then the DHL Paket carrier
gets assigned to the order and further shipping fulfillment will be done with
the DHL Business Customer Shipping API. This solution was suggested in the
[issue discussion](https://github.com/netresearch/dhl-shipping-m2/issues/11#issuecomment-800547526).

The module applies very basic sanity checks:

* Is the configured shipping origin located in Germany?
* Is the selected shipping method configured for carrier reassignment?

These conditions can be modified or extended via DI configuration, e.g. if only orders
placed in a certain store must be reassigned.

Requirements
------------
* PHP >= 7.2

Compatibility
-------------
* Magento >= 2.3.0+

Installation Instructions
-------------------------

Install sources:

    composer require dhl/module-carrier-update

Enable module:

    ./bin/magento module:enable Dhl_CarrierUpdate

Flush cache and compile:

    ./bin/magento cache:flush
    ./bin/magento setup:di:compile

Uninstallation
--------------

To unregister the module from the application, run the following command:

    ./bin/magento module:uninstall --remove-data Dhl_CarrierUpdate
    composer update

This will automatically remove source files and update package dependencies.

Support
-------
This module does not receive official maintenance or support.

GitHub issues can be created to open discussions with other users of the module.
Contributions (pull requests) will be processed.

License
-------
[OSL - Open Software Licence 3.0](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2022 DHL Paket GmbH
