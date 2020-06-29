<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200626203054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(254) NOT NULL, is_active TINYINT(1) NOT NULL, roles VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, name_user_id INT NOT NULL, name_ouvrage_id INT NOT NULL, content LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_9474526CAF05962B (name_user_id), INDEX IDX_9474526C8D765437 (name_ouvrage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ouvrage (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, sub_title VARCHAR(255) DEFAULT NULL, resume LONGTEXT NOT NULL, author VARCHAR(100) NOT NULL, editor VARCHAR(255) DEFAULT NULL, isbnumber VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, date_reservation DATETIME DEFAULT NULL, dewey VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_52A8CBD8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CAF05962B FOREIGN KEY (name_user_id) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D765437 FOREIGN KEY (name_ouvrage_id) REFERENCES ouvrage (id)');
        $this->addSql('ALTER TABLE ouvrage ADD CONSTRAINT FK_52A8CBD8A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CAF05962B');
        $this->addSql('ALTER TABLE ouvrage DROP FOREIGN KEY FK_52A8CBD8A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D765437');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE ouvrage');
    }
}
