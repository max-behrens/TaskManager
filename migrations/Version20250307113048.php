<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Updated tasks table with NOT NULL constraints and default values
 */
final class Version20250307113048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update tasks table with proper constraints and default values';
    }

    public function up(Schema $schema): void
    {
        // Drop old 'task' table if it exists
        $this->addSql('DROP TABLE IF EXISTS task');

        // Create 'tasks' table with proper default values and NOT NULL constraints
        $this->addSql('CREATE TABLE tasks (
            id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(255) NOT NULL,
            is_done TINYINT(1) NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Ensure default timestamp
            updated_at DATETIME DEFAULT NULL COMMENT "(DC2Type:datetime_immutable)",
            deleted_at DATETIME DEFAULT NULL COMMENT "(DC2Type:datetime_immutable)",
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // Rollback by dropping the 'tasks' table and recreating the old 'task' table
        $this->addSql('DROP TABLE IF EXISTS tasks');
        $this->addSql('CREATE TABLE task (
            id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`,
            is_done TINYINT(1) NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Ensure default timestamp
            updated_at DATETIME DEFAULT NULL COMMENT "(DC2Type:datetime_immutable)",
            deleted_at DATETIME DEFAULT NULL COMMENT "(DC2Type:datetime_immutable)",
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }
}
