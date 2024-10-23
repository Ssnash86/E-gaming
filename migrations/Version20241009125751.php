<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009125751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_jeux (categorie_id INT NOT NULL, jeux_id INT NOT NULL, INDEX IDX_407C325ABCF5E72D (categorie_id), INDEX IDX_407C325AEC2AA9D2 (jeux_id), PRIMARY KEY(categorie_id, jeux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, jeux_id INT NOT NULL, texte LONGTEXT NOT NULL, INDEX IDX_67F068BCA76ED395 (user_id), INDEX IDX_67F068BCEC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE img_jeux (id INT AUTO_INCREMENT NOT NULL, jeux_id INT DEFAULT NULL, img LONGTEXT NOT NULL, INDEX IDX_F9444435EC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, cp INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel VARCHAR(10) NOT NULL, UNIQUE INDEX UNIQ_29791883A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE information_jeux (id INT AUTO_INCREMENT NOT NULL, stocks INT DEFAULT NULL, studio VARCHAR(255) NOT NULL, date_parution DATETIME NOT NULL, description_jeux LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, information_jeux_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, reduction INT DEFAULT NULL, img LONGTEXT NOT NULL, img_3d LONGTEXT DEFAULT NULL, prime TINYINT(1) NOT NULL, img_log LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_3755B50DF11B0943 (information_jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, solo TINYINT(1) DEFAULT NULL, multi TINYINT(1) DEFAULT NULL, duo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur_information_jeux (joueur_id INT NOT NULL, information_jeux_id INT NOT NULL, INDEX IDX_5BA03EDBA9E2D76C (joueur_id), INDEX IDX_5BA03EDBF11B0943 (information_jeux_id), PRIMARY KEY(joueur_id, information_jeux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plateforme (id INT AUTO_INCREMENT NOT NULL, ps4 TINYINT(1) NOT NULL, xbox TINYINT(1) NOT NULL, pc TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plateforme_information_jeux (plateforme_id INT NOT NULL, information_jeux_id INT NOT NULL, INDEX IDX_A14C2C5A391E226B (plateforme_id), INDEX IDX_A14C2C5AF11B0943 (information_jeux_id), PRIMARY KEY(plateforme_id, information_jeux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie_jeux ADD CONSTRAINT FK_407C325ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_jeux ADD CONSTRAINT FK_407C325AEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE img_jeux ADD CONSTRAINT FK_F9444435EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50DF11B0943 FOREIGN KEY (information_jeux_id) REFERENCES information_jeux (id)');
        $this->addSql('ALTER TABLE joueur_information_jeux ADD CONSTRAINT FK_5BA03EDBA9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joueur_information_jeux ADD CONSTRAINT FK_5BA03EDBF11B0943 FOREIGN KEY (information_jeux_id) REFERENCES information_jeux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plateforme_information_jeux ADD CONSTRAINT FK_A14C2C5A391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plateforme_information_jeux ADD CONSTRAINT FK_A14C2C5AF11B0943 FOREIGN KEY (information_jeux_id) REFERENCES information_jeux (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_jeux DROP FOREIGN KEY FK_407C325ABCF5E72D');
        $this->addSql('ALTER TABLE categorie_jeux DROP FOREIGN KEY FK_407C325AEC2AA9D2');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCEC2AA9D2');
        $this->addSql('ALTER TABLE img_jeux DROP FOREIGN KEY FK_F9444435EC2AA9D2');
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883A76ED395');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50DF11B0943');
        $this->addSql('ALTER TABLE joueur_information_jeux DROP FOREIGN KEY FK_5BA03EDBA9E2D76C');
        $this->addSql('ALTER TABLE joueur_information_jeux DROP FOREIGN KEY FK_5BA03EDBF11B0943');
        $this->addSql('ALTER TABLE plateforme_information_jeux DROP FOREIGN KEY FK_A14C2C5A391E226B');
        $this->addSql('ALTER TABLE plateforme_information_jeux DROP FOREIGN KEY FK_A14C2C5AF11B0943');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE categorie_jeux');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE img_jeux');
        $this->addSql('DROP TABLE information');
        $this->addSql('DROP TABLE information_jeux');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE joueur_information_jeux');
        $this->addSql('DROP TABLE plateforme');
        $this->addSql('DROP TABLE plateforme_information_jeux');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
