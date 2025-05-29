# Legacy Installation

## Overview:
**General**
- [Requirements](#requirements)
- [Composer](#composer)
- [Basic configuration](#basic-configuration)

## Requirements:
We work on stable, supported and up-to-date versions of packages. We recommend you to do the same.

| Package       | Version |
|---------------|---------|
| PHP           | ^8.2    |
| sylius/sylius | ^2.0    |
| MySQL         | ^8.4    |
| NodeJS        | ^20.x   |

## Composer:
```bash
  composer require sylius/product-bundle-plugin
```

## Basic configuration:
1. Add plugin dependencies to your `config/bundles.php` file (if not added automatically):

    ```php
    # config/bundles.php
    
    return [
        ...
        Sylius\ProductBundlePlugin\SyliusProductBundlePlugin::class  => ['all' => true],
    ];
    ```

1. Import required config in your `config/packages/_sylius.yaml` file:
    ```yaml
    # config/packages/_sylius.yaml
    
    imports:
          ...
          - { resource: "@SyliusProductBundlePlugin/config/config.yaml" }
    ```

1. Import routing in your `config/routes.yaml` file:

    ```yaml
    
    # config/routes.yaml
    ...
    sylius_product_bundle:
        resource: "@SyliusProductBundlePlugin/config/routes.yaml"
    ```
1. Extend enities

   OrderItem:
    ```php
   <?php

   declare(strict_types=1);

   namespace App\Entity\Order;

   use Doctrine\ORM\Mapping as ORM;
   use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;
   use Sylius\ProductBundlePlugin\Entity\ProductBundleOrderItemsAwareTrait;
   use Sylius\Component\Core\Model\OrderItem as BaseOrderItem;
   
   #[ORM\Entity]
   #[ORM\Table(name: 'sylius_order_item')]
   class OrderItem extends BaseOrderItem implements OrderItemInterface
   {
   use ProductBundleOrderItemsAwareTrait;
   
       public function __construct()
       {
           parent::__construct();
           $this->initializeProductBundleOrderItems();
       }
   }
    ```
   
   Product:
   ```php
   <?php

   declare(strict_types=1);

   namespace App\Entity\Product;

   use Doctrine\ORM\Mapping as ORM;
   use Sylius\ProductBundlePlugin\Entity\ProductBundlesAwareTrait;
   use Sylius\ProductBundlePlugin\Entity\ProductInterface;
   use Sylius\Component\Core\Model\Product as BaseProduct;
   
   #[ORM\Entity]
   #[ORM\Table(name: 'sylius_product')]
   class Product extends BaseProduct implements ProductInterface
   {
     use ProductBundlesAwareTrait;
   }
    ```

1. Install assets:
    ```bash
    bin/console assets:install --symlink
    ```

1. Add entrypoint import:
    ```yaml
    // assets/admin/entrypoint.js
    import '@vendor/sylius/product-bundle-plugin/assets/admin/entrypoint'
    ```
    ```yaml
    // assets/shop/entrypoint.js
    import '@vendor/sylius/product-bundle-plugin/assets/shop/entrypoint'
    ```

1. Build assets:
    ```bash
      yarn install && yarn encore dev
    ```

1. Database update:
   ```bash
     bin/console doctrine:migrations:migrate
   ```
   **Note:** If you are running it on production, add the `-e prod` flag to this command.
   
   **Clear application cache by using command:**
   ```bash
     bin/console cache:clear
   ```

