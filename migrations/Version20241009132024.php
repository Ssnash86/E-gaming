<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009132024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_jeux (id INT AUTO_INCREMENT NOT NULL, jeux_id INT NOT NULL, orders_id INT NOT NULL, quantite INT NOT NULL, prix_unit DOUBLE PRECISION NOT NULL, INDEX IDX_7AA48F1AEC2AA9D2 (jeux_id), INDEX IDX_7AA48F1ACFFE9AD6 (orders_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, total DOUBLE PRECISION NOT NULL, numero_commande VARCHAR(255) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_jeux ADD CONSTRAINT FK_7AA48F1AEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE order_jeux ADD CONSTRAINT FK_7AA48F1ACFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_jeux DROP FOREIGN KEY FK_7AA48F1AEC2AA9D2');
        $this->addSql('ALTER TABLE order_jeux DROP FOREIGN KEY FK_7AA48F1ACFFE9AD6');
        $this->addSql('DROP TABLE order_jeux');
        $this->addSql('DROP TABLE orders');
    }
}
