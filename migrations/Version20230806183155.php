<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806183155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE blocker_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contribution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE contributor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE blocker (id INT NOT NULL, task_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_resolved BOOLEAN NOT NULL, solution VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2E815ED18DB60186 ON blocker (task_id)');
        $this->addSql('CREATE TABLE contribution (id INT NOT NULL, contributor_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EA351E157A19A357 ON contribution (contributor_id)');
        $this->addSql('CREATE TABLE contribution_media (contribution_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(contribution_id, media_id))');
        $this->addSql('CREATE INDEX IDX_F5FAABEFE5E5FBD ON contribution_media (contribution_id)');
        $this->addSql('CREATE INDEX IDX_F5FAABEEA9FDD75 ON contribution_media (media_id)');
        $this->addSql('CREATE TABLE contributor (id INT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE contributor_task (contributor_id INT NOT NULL, task_id INT NOT NULL, PRIMARY KEY(contributor_id, task_id))');
        $this->addSql('CREATE INDEX IDX_81368E6B7A19A357 ON contributor_task (contributor_id)');
        $this->addSql('CREATE INDEX IDX_81368E6B8DB60186 ON contributor_task (task_id)');
        $this->addSql('CREATE TABLE media (id INT NOT NULL, name VARCHAR(255) NOT NULL, file BYTEA NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE project (id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, documentation TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, due_date DATE DEFAULT NULL, is_finished BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN project.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN project.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE project_media (project_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(project_id, media_id))');
        $this->addSql('CREATE INDEX IDX_7979A892166D1F9C ON project_media (project_id)');
        $this->addSql('CREATE INDEX IDX_7979A892EA9FDD75 ON project_media (media_id)');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, documentation TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, due_date DATE DEFAULT NULL, is_finished BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB25166D1F9C ON task (project_id)');
        $this->addSql('COMMENT ON COLUMN task.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE task_task (task_source INT NOT NULL, task_target INT NOT NULL, PRIMARY KEY(task_source, task_target))');
        $this->addSql('CREATE INDEX IDX_21CD4F5E6423FBA0 ON task_task (task_source)');
        $this->addSql('CREATE INDEX IDX_21CD4F5E7DC6AB2F ON task_task (task_target)');
        $this->addSql('CREATE TABLE task_media (task_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(task_id, media_id))');
        $this->addSql('CREATE INDEX IDX_AD88BA2C8DB60186 ON task_media (task_id)');
        $this->addSql('CREATE INDEX IDX_AD88BA2CEA9FDD75 ON task_media (media_id)');
        $this->addSql('CREATE TABLE task_history (id INT NOT NULL, task_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_385B5AA18DB60186 ON task_history (task_id)');
        $this->addSql('COMMENT ON COLUMN task_history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE task_history_media (task_history_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(task_history_id, media_id))');
        $this->addSql('CREATE INDEX IDX_7683643A216CFFD ON task_history_media (task_history_id)');
        $this->addSql('CREATE INDEX IDX_7683643AEA9FDD75 ON task_history_media (media_id)');
        $this->addSql('ALTER TABLE blocker ADD CONSTRAINT FK_2E815ED18DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contribution_media ADD CONSTRAINT FK_F5FAABEFE5E5FBD FOREIGN KEY (contribution_id) REFERENCES contribution (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contribution_media ADD CONSTRAINT FK_F5FAABEEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contributor_task ADD CONSTRAINT FK_81368E6B7A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contributor_task ADD CONSTRAINT FK_81368E6B8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_media ADD CONSTRAINT FK_7979A892166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_media ADD CONSTRAINT FK_7979A892EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_task ADD CONSTRAINT FK_21CD4F5E6423FBA0 FOREIGN KEY (task_source) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_task ADD CONSTRAINT FK_21CD4F5E7DC6AB2F FOREIGN KEY (task_target) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_media ADD CONSTRAINT FK_AD88BA2C8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_media ADD CONSTRAINT FK_AD88BA2CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_history ADD CONSTRAINT FK_385B5AA18DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_history_media ADD CONSTRAINT FK_7683643A216CFFD FOREIGN KEY (task_history_id) REFERENCES task_history (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_history_media ADD CONSTRAINT FK_7683643AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE blocker_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contribution_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE contributor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_history_id_seq CASCADE');
        $this->addSql('ALTER TABLE blocker DROP CONSTRAINT FK_2E815ED18DB60186');
        $this->addSql('ALTER TABLE contribution DROP CONSTRAINT FK_EA351E157A19A357');
        $this->addSql('ALTER TABLE contribution_media DROP CONSTRAINT FK_F5FAABEFE5E5FBD');
        $this->addSql('ALTER TABLE contribution_media DROP CONSTRAINT FK_F5FAABEEA9FDD75');
        $this->addSql('ALTER TABLE contributor_task DROP CONSTRAINT FK_81368E6B7A19A357');
        $this->addSql('ALTER TABLE contributor_task DROP CONSTRAINT FK_81368E6B8DB60186');
        $this->addSql('ALTER TABLE project_media DROP CONSTRAINT FK_7979A892166D1F9C');
        $this->addSql('ALTER TABLE project_media DROP CONSTRAINT FK_7979A892EA9FDD75');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE task_task DROP CONSTRAINT FK_21CD4F5E6423FBA0');
        $this->addSql('ALTER TABLE task_task DROP CONSTRAINT FK_21CD4F5E7DC6AB2F');
        $this->addSql('ALTER TABLE task_media DROP CONSTRAINT FK_AD88BA2C8DB60186');
        $this->addSql('ALTER TABLE task_media DROP CONSTRAINT FK_AD88BA2CEA9FDD75');
        $this->addSql('ALTER TABLE task_history DROP CONSTRAINT FK_385B5AA18DB60186');
        $this->addSql('ALTER TABLE task_history_media DROP CONSTRAINT FK_7683643A216CFFD');
        $this->addSql('ALTER TABLE task_history_media DROP CONSTRAINT FK_7683643AEA9FDD75');
        $this->addSql('DROP TABLE blocker');
        $this->addSql('DROP TABLE contribution');
        $this->addSql('DROP TABLE contribution_media');
        $this->addSql('DROP TABLE contributor');
        $this->addSql('DROP TABLE contributor_task');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_media');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_task');
        $this->addSql('DROP TABLE task_media');
        $this->addSql('DROP TABLE task_history');
        $this->addSql('DROP TABLE task_history_media');
    }
}
