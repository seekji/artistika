<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190811165727 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event ADD detail_picture_id INT DEFAULT NULL, ADD age INT DEFAULT NULL, ADD additional_text LONGTEXT DEFAULT NULL, ADD social_links LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7555F0D69 FOREIGN KEY (detail_picture_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7555F0D69 ON event (detail_picture_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7555F0D69');
        $this->addSql('DROP INDEX IDX_3BAE0AA7555F0D69 ON event');
        $this->addSql('ALTER TABLE event DROP detail_picture_id, DROP age, DROP additional_text, DROP social_links');
    }
}
