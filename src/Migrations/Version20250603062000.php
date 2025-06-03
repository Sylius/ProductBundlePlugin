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
use Sylius\Bundle\CoreBundle\Doctrine\Migrations\AbstractPostgreSQLMigration;

final class Version20250603062000 extends AbstractPostgreSQLMigration
{
    public function getDescription(): string
    {
        return 'initial migration';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE sylius_product_bundle_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE sylius_product_bundle_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE sylius_product_bundle_order_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_product_bundle (id INT NOT NULL, product_id INT NOT NULL, is_packed_product BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_1B3DD9A24584665A ON sylius_product_bundle (product_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_product_bundle_item (id INT NOT NULL, product_variant_id INT NOT NULL, product_bundle_id INT NOT NULL, quantity INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9600D2B9A80EF684 ON sylius_product_bundle_item (product_variant_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9600D2B99F5A6F5E ON sylius_product_bundle_item (product_bundle_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_product_bundle_order_item (id INT NOT NULL, product_variant_id INT NOT NULL, order_item_id INT NOT NULL, product_bundle_item_id INT NOT NULL, quantity INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C51B4283A80EF684 ON sylius_product_bundle_order_item (product_variant_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C51B4283E415FB15 ON sylius_product_bundle_order_item (order_item_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C51B4283B7FE950B ON sylius_product_bundle_order_item (product_bundle_item_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle ADD CONSTRAINT FK_1B3DD9A24584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item ADD CONSTRAINT FK_9600D2B9A80EF684 FOREIGN KEY (product_variant_id) REFERENCES sylius_product_variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item ADD CONSTRAINT FK_9600D2B99F5A6F5E FOREIGN KEY (product_bundle_id) REFERENCES sylius_product_bundle (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item ADD CONSTRAINT FK_C51B4283A80EF684 FOREIGN KEY (product_variant_id) REFERENCES sylius_product_variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item ADD CONSTRAINT FK_C51B4283E415FB15 FOREIGN KEY (order_item_id) REFERENCES sylius_order_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item ADD CONSTRAINT FK_C51B4283B7FE950B FOREIGN KEY (product_bundle_item_id) REFERENCES sylius_product_bundle_item (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP SEQUENCE sylius_product_bundle_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE sylius_product_bundle_item_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE sylius_product_bundle_order_item_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle DROP CONSTRAINT FK_1B3DD9A24584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item DROP CONSTRAINT FK_9600D2B9A80EF684
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_item DROP CONSTRAINT FK_9600D2B99F5A6F5E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item DROP CONSTRAINT FK_C51B4283A80EF684
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item DROP CONSTRAINT FK_C51B4283E415FB15
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE sylius_product_bundle_order_item DROP CONSTRAINT FK_C51B4283B7FE950B
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
