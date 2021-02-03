<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203134523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE killer ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE killer ADD CONSTRAINT FK_D16FBE0BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_D16FBE0BF92F3E70 ON killer (country_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE killer DROP FOREIGN KEY FK_D16FBE0BF92F3E70');
        $this->addSql('DROP INDEX IDX_D16FBE0BF92F3E70 ON killer');
        $this->addSql('ALTER TABLE killer DROP country_id');
    }
}
