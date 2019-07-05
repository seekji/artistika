<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190704183410 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE adw_geoip_ipgeobase_location');
        $this->addSql('DROP TABLE adw_geoip_maxmind_location');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adw_geoip_ipgeobase_location (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, country_fullname VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, region VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, district VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, city VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, ip_min BIGINT NOT NULL, ip_max BIGINT NOT NULL, INDEX search_geoip_range (ip_min, ip_max), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE adw_geoip_maxmind_location (id INT AUTO_INCREMENT NOT NULL, ip_min BIGINT NOT NULL, ip_max BIGINT NOT NULL, city VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, country VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, code VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
    }
}
