<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190417213447 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointment DROP INDEX UNIQ_FE38F8449395C3F3, ADD INDEX IDX_FE38F8449395C3F3 (customer_id)');
        $this->addSql('ALTER TABLE appointment DROP INDEX UNIQ_FE38F844A76ED395, ADD INDEX IDX_FE38F844A76ED395 (user_id)');
        $this->addSql('ALTER TABLE appointment DROP INDEX UNIQ_FE38F844DA6A219, ADD INDEX IDX_FE38F844DA6A219 (place_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE appointment DROP INDEX IDX_FE38F844A76ED395, ADD UNIQUE INDEX UNIQ_FE38F844A76ED395 (user_id)');
        $this->addSql('ALTER TABLE appointment DROP INDEX IDX_FE38F8449395C3F3, ADD UNIQUE INDEX UNIQ_FE38F8449395C3F3 (customer_id)');
        $this->addSql('ALTER TABLE appointment DROP INDEX IDX_FE38F844DA6A219, ADD UNIQUE INDEX UNIQ_FE38F844DA6A219 (place_id)');
    }
}
