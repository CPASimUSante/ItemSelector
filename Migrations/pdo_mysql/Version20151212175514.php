<?php

namespace CPASimUSante\ItemSelectorBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution.
 *
 * Generation date: 2015/12/12 05:55:16
 */
class Version20151212175514 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('
            CREATE TABLE cpasimusante__itemselector (
                id INT AUTO_INCREMENT NOT NULL, 
                resource_id INT DEFAULT NULL, 
                title VARCHAR(255) NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                INDEX IDX_F924AFCF89329D25 (resource_id), 
                UNIQUE INDEX UNIQ_F924AFCFB87FAB32 (resourceNode_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE cpasimusante__mainconfig_item (
                id INT AUTO_INCREMENT NOT NULL, 
                workspace_id INT DEFAULT NULL, 
                mainconfig_id INT DEFAULT NULL, 
                itemcount SMALLINT NOT NULL, 
                namepattern VARCHAR(255) DEFAULT NULL, 
                resourceType_id INT DEFAULT NULL, 
                mainResourceType_id INT DEFAULT NULL, 
                INDEX IDX_93B06E873B3EB876 (resourceType_id), 
                INDEX IDX_93B06E87E18E902D (mainResourceType_id), 
                INDEX IDX_93B06E8782D40A1F (workspace_id), 
                INDEX IDX_93B06E87D3395296 (mainconfig_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE cpasimusante__item (
                id INT AUTO_INCREMENT NOT NULL, 
                resource_node_id INT DEFAULT NULL, 
                itemselector_id INT DEFAULT NULL, 
                INDEX IDX_1C4361FA1BAD783F (resource_node_id), 
                INDEX IDX_1C4361FAAE96C331 (itemselector_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE cpasimusante__mainconfig (
                id INT AUTO_INCREMENT NOT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__itemselector 
            ADD CONSTRAINT FK_F924AFCF89329D25 FOREIGN KEY (resource_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE SET NULL
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__itemselector 
            ADD CONSTRAINT FK_F924AFCFB87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__mainconfig_item 
            ADD CONSTRAINT FK_93B06E873B3EB876 FOREIGN KEY (resourceType_id) 
            REFERENCES claro_resource_type (id) 
            ON DELETE SET NULL
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__mainconfig_item 
            ADD CONSTRAINT FK_93B06E87E18E902D FOREIGN KEY (mainResourceType_id) 
            REFERENCES claro_resource_type (id) 
            ON DELETE SET NULL
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__mainconfig_item 
            ADD CONSTRAINT FK_93B06E8782D40A1F FOREIGN KEY (workspace_id) 
            REFERENCES claro_workspace (id) 
            ON DELETE SET NULL
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__mainconfig_item 
            ADD CONSTRAINT FK_93B06E87D3395296 FOREIGN KEY (mainconfig_id) 
            REFERENCES cpasimusante__mainconfig (id)
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__item 
            ADD CONSTRAINT FK_1C4361FA1BAD783F FOREIGN KEY (resource_node_id) 
            REFERENCES claro_resource_node (id)
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__item 
            ADD CONSTRAINT FK_1C4361FAAE96C331 FOREIGN KEY (itemselector_id) 
            REFERENCES cpasimusante__itemselector (id)
        ');
    }

    public function down(Schema $schema)
    {
        $this->addSql('
            ALTER TABLE cpasimusante__item 
            DROP FOREIGN KEY FK_1C4361FAAE96C331
        ');
        $this->addSql('
            ALTER TABLE cpasimusante__mainconfig_item 
            DROP FOREIGN KEY FK_93B06E87D3395296
        ');
        $this->addSql('
            DROP TABLE cpasimusante__itemselector
        ');
        $this->addSql('
            DROP TABLE cpasimusante__mainconfig_item
        ');
        $this->addSql('
            DROP TABLE cpasimusante__item
        ');
        $this->addSql('
            DROP TABLE cpasimusante__mainconfig
        ');
    }
}
