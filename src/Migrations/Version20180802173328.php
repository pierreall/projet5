<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180802173328 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ouvrage_user');
        $this->addSql('ALTER TABLE ouvrage ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ouvrage ADD CONSTRAINT FK_52A8CBD8A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('CREATE INDEX IDX_52A8CBD8A76ED395 ON ouvrage (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ouvrage_user (ouvrage_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9799C8C315D884B5 (ouvrage_id), INDEX IDX_9799C8C3A76ED395 (user_id), PRIMARY KEY(ouvrage_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ouvrage_user ADD CONSTRAINT FK_9799C8C315D884B5 FOREIGN KEY (ouvrage_id) REFERENCES ouvrage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ouvrage_user ADD CONSTRAINT FK_9799C8C3A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ouvrage DROP FOREIGN KEY FK_52A8CBD8A76ED395');
        $this->addSql('DROP INDEX IDX_52A8CBD8A76ED395 ON ouvrage');
        $this->addSql('ALTER TABLE ouvrage DROP user_id');
    }
}
