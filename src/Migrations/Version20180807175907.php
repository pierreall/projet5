<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180807175907 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('ALTER TABLE comment CHANGE ouvrage_id name_ouvrage_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D765437 FOREIGN KEY (name_ouvrage_id) REFERENCES ouvrage (id)');
        $this->addSql('CREATE INDEX IDX_9474526C8D765437 ON comment (name_ouvrage_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D765437');
        $this->addSql('DROP INDEX IDX_9474526C8D765437 ON comment');
        $this->addSql('ALTER TABLE comment CHANGE name_ouvrage_id ouvrage_id INT NOT NULL');
    }
}
