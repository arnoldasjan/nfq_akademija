<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919172407 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE specialist (id SERIAL NOT NULL PRIMARY KEY, title VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE specialist');
    }
}
