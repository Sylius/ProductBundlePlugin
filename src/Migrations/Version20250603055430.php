<?php

/*
 * This file is part of the Sylius ProductBundle Plugin package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\ProductBundlePlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractMigration;

final class Version20250603055430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial migration';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_product_bundle (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, is_packed_product TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1B3DD9A24584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_product_bundle_item (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, product_bundle_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_9600D2B9A80EF684 (product_variant_id), INDEX IDX_9600D2B99F5A6F5E (product_bundle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_product_bundle_order_item (id INT AUTO_INCREMENT NOT NULL, product_variant_id INT NOT NULL, order_item_id INT NOT NULL, product_bundle_item_id INT NOT NULL, quantity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_C51B4283A80EF684 (product_variant_id), INDEX IDX_C51B4283E415FB15 (order_item_id), INDEX IDX_C51B4283B7FE950B (product_bundle_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle ADD CONSTRAINT FK_1B3DD9A24584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item ADD CONSTRAINT FK_9600D2B9A80EF684 FOREIGN KEY (product_variant_id) REFERENCES sylius_product_variant (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item ADD CONSTRAINT FK_9600D2B99F5A6F5E FOREIGN KEY (product_bundle_id) REFERENCES sylius_product_bundle (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item ADD CONSTRAINT FK_C51B4283A80EF684 FOREIGN KEY (product_variant_id) REFERENCES sylius_product_variant (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item ADD CONSTRAINT FK_C51B4283E415FB15 FOREIGN KEY (order_item_id) REFERENCES sylius_order_item (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item ADD CONSTRAINT FK_C51B4283B7FE950B FOREIGN KEY (product_bundle_item_id) REFERENCES sylius_product_bundle_item (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle DROP FOREIGN KEY FK_1B3DD9A24584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item DROP FOREIGN KEY FK_9600D2B9A80EF684
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item DROP FOREIGN KEY FK_9600D2B99F5A6F5E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item DROP FOREIGN KEY FK_C51B4283A80EF684
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item DROP FOREIGN KEY FK_C51B4283E415FB15
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item DROP FOREIGN KEY FK_C51B4283B7FE950B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sylius_product_bundle
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sylius_product_bundle_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE sylius_product_bundle_order_item
        SQL);
    }
}
