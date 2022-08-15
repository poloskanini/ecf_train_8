<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220815170822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure ADD is_planning TINYINT(1) NOT NULL, ADD is_newsletter TINYINT(1) NOT NULL, ADD is_boissons TINYINT(1) NOT NULL, ADD is_sms TINYINT(1) NOT NULL, ADD is_concours TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structure DROP is_planning, DROP is_newsletter, DROP is_boissons, DROP is_sms, DROP is_concours');
    }
}
