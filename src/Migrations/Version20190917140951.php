<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190917140951 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE client (id SERIAL AUTO_INCREMENT NOT NULL PRIMARY KEY, firstname VARCHAR(255) NOT NULL, surname VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE client');
    }
}
