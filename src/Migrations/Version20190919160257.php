<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919160257 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE client ADD added_time timestamp DEFAULT NULL, ADD specialist_needed INT NOT NULL, alter column serviced set DEFAULT false');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE client DROP added_time, DROP specialist_needed, alter column serviced set DEFAULT NULL');
    }
}
