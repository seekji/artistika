<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190817183503 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page DROP meta_title, DROP meta_description, DROP meta_keywords');
        $this->addSql('ALTER TABLE city DROP meta_title, DROP meta_description, DROP meta_keywords');
        $this->addSql('ALTER TABLE event DROP meta_title, DROP meta_description, DROP meta_keywords');
        $this->addSql('ALTER TABLE news DROP meta_title, DROP meta_description, DROP meta_keywords');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city ADD meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE event ADD meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE news ADD meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE page ADD meta_title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD meta_keywords VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
