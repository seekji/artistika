<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812202135 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE page_slides (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, picture_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, small_text VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, sort INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_D716D68F71F7E88B (event_id), INDEX IDX_D716D68FEE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, is_published TINYINT(1) NOT NULL, template INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_page_slides (page_id INT NOT NULL, page_slides_id INT NOT NULL, INDEX IDX_C0AA88FDC4663E4 (page_id), INDEX IDX_C0AA88FDAF9E4E92 (page_slides_id), PRIMARY KEY(page_id, page_slides_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_slides ADD CONSTRAINT FK_D716D68F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE page_slides ADD CONSTRAINT FK_D716D68FEE45BDBF FOREIGN KEY (picture_id) REFERENCES media__media (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE page_page_slides ADD CONSTRAINT FK_C0AA88FDC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_page_slides ADD CONSTRAINT FK_C0AA88FDAF9E4E92 FOREIGN KEY (page_slides_id) REFERENCES page_slides (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_page_slides DROP FOREIGN KEY FK_C0AA88FDAF9E4E92');
        $this->addSql('ALTER TABLE page_page_slides DROP FOREIGN KEY FK_C0AA88FDC4663E4');
        $this->addSql('DROP TABLE page_slides');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_page_slides');
    }
}
