<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Brian Rogers <captbrogers@gmail.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\CardKeep\Migration;

use Closure;
use OCP\DB\Types;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version000000Date20181013124731 extends SimpleMigrationStep
{
    /**
     * @param IOutput $output
     * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
     * @param array $options
     * @return null|ISchemaWrapper
     */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options)
    {
        /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();

        if (!$schema->hasTable('cardkeep')) {
            $table = $schema->createTable('cardkeep');
            $table->addColumn('id', Types::BIGINT, [
                'autoincrement' => true,
                'unsigned'      => true,
                'length'        => 20,
                'notnull'       => true,
            ]);
            $table->addColumn('user_id', Types::STRING, [
                'notnull' => true,
                'length'  => 200,
            ]);
            $table->addColumn('title', Types::STRING, [
                'notnull' => true,
                'length' => 200,
            ]);
            $table->addColumn('content', Types::TEXT, [
                'notnull' => true,
                'default' => '',
            ]);
            $table->addColumn('pinned_at', Types::DATETIME, [
                'notnull' => false,
                'default' => null,
            ]);
            $table->addColumn('created_at', Types::DATETIME, [
                'notnull' => false,
                'default' => null,
            ]);
            $table->addColumn('updated_at', Types::DATETIME, [
                'notnull' => false,
                'default' => null,
            ]);

            $table->setPrimaryKey(['id']);
            $table->addIndex(['user_id'], 'cardkeep_user_id_index');
        }

        return $schema;
    }
}
