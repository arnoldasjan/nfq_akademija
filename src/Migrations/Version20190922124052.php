<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190922124052 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE visit (id SERIAL NOT NULL PRIMARY KEY , event VARCHAR(255) NOT NULL, created_at timestamp NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE visit');
    }
}
