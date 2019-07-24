<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724195243 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_slider (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, picture_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_FD5E675571F7E88B (event_id), INDEX IDX_FD5E6755EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_slider ADD CONSTRAINT FK_FD5E675571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event_slider ADD CONSTRAINT FK_FD5E6755EE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE event ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE city_id city_id INT DEFAULT NULL, CHANGE hall_id hall_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_slider');
        $this->addSql('ALTER TABLE event DROP created_at, DROP updated_at, CHANGE city_id city_id INT NOT NULL, CHANGE hall_id hall_id INT NOT NULL');
    }
}
