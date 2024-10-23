<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241016060830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50DF11B0943');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50DF11B0943 FOREIGN KEY (information_jeux_id) REFERENCES information_jeux (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50DF11B0943');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50DF11B0943 FOREIGN KEY (information_jeux_id) REFERENCES information_jeux (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
