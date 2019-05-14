<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190514174705 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE language_id language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C182F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_64C19C182F1BAF4 ON category (language_id)');
        $this->addSql('ALTER TABLE blog_post ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_BA5AE01D82F1BAF4 ON blog_post (language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D82F1BAF4');
        $this->addSql('DROP INDEX IDX_BA5AE01D82F1BAF4 ON blog_post');
        $this->addSql('ALTER TABLE blog_post DROP language_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C182F1BAF4');
        $this->addSql('DROP INDEX IDX_64C19C182F1BAF4 ON category');
        $this->addSql('ALTER TABLE category CHANGE language_id language_id INT DEFAULT 0');
    }
}
