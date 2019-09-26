<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190922132733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE visit ADD specialist_id int, add client_id int');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE visit drop column specialist_id, drop column client_id');
    }
}
