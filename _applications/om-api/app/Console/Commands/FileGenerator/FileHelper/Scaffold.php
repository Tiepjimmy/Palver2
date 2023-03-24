<?php

namespace App\Console\Commands\FileGenerator\FileHelper;

use PDO;

/**
 * Class Scaffold
 * @package App\Libraries\Cmd
 */
class Scaffold extends Command
{
    /**
     * Generate entities
     * @param string $table
     * @return array
     * @throws \Exception
     */
    public function getSchema(string $table)
    {
        $table = trim($table);

        if (empty($table)) {
            throw new \Exception('Invalid table');
        }

        // Get db context
        $this->getDbContext();

        $resource = $this->dbContext->getPdo()->prepare("DESCRIBE `{$table}`");
        $resource->execute();

        if ($resource->rowCount() == 0) {
            throw new \Exception('Table not found');
        }

        $primaryKey = '';
        $schema = [];
        $types = [];

        while ($row = $resource->fetch(PDO::FETCH_ASSOC)) {
            $field = $row['Field'];
            $schema[] = $field;
            $types[$field] = $this->getType($row['Type']);

            if ($row['Key'] == 'PRI') {
                $primaryKey = $row['Field'];
            }
        }

        $resource = null;
        $this->dbContext = null;

        return [$schema, $types, $primaryKey];
    }

    /**
     * @param string $type
     *
     * @return string|null
     */
    public function getType(string $type)
    {
        if (preg_match('/^(bigint|int|integer|smallint|mediumint|tinyint|bit|numeric)(\(([\d]+)\))?/', $type, $matches)) {
            return 'int';
        }

        if (preg_match('/^(real|decimal|double|float)(\(([\d]+),([\d]+)\))?/', $type, $matches)) {
            return 'float';
        }

        if (preg_match('/^(longtext|text|mediumtext|tinytext|varchar|char|enum|set|varbinary|year|date|datetime|time|timestamp)(\(([\d]+)\))?/', $type, $matches)) {
            return 'string';
        }

        return null;
    }
}
