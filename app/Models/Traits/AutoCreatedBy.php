<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait AutoCreatedBy
{
    /**
     * Automatically set created_by and created_by_name when creating a new record.
     */
    public static function bootAutoCreatedBy(): void
    {
        static::creating(function ($model) {
            if (! Auth::check()) {
                return;
            }

            $connection = $model->getConnection();
            $table = $model->getTable();
            $cacheKey = $connection->getName() . ':' . $table;

            if (! isset(static::$autoCreatedByColumnCache[$cacheKey])) {
                static::$autoCreatedByColumnCache[$cacheKey] = [
                    'created_by' => false,
                    'created_by_name' => false,
                ];

                if ($connection->getSchemaBuilder()->hasTable($table)) {
                    $columns = $connection->getSchemaBuilder()->getColumnListing($table);
                    static::$autoCreatedByColumnCache[$cacheKey]['created_by'] = in_array('created_by', $columns, true);
                    static::$autoCreatedByColumnCache[$cacheKey]['created_by_name'] = in_array('created_by_name', $columns, true);
                }
            }

            $columns = static::$autoCreatedByColumnCache[$cacheKey];
            $user = Auth::user();

            if ($columns['created_by'] && empty($model->created_by)) {
                $model->created_by = $user->id;
            }

            if ($columns['created_by_name'] && empty($model->created_by_name)) {
                $model->created_by_name = $user->name;
            }
        });
    }

    /**
     * Cache column availability per table to avoid repeated schema lookups.
     *
     * @var array<string, array<string, bool>>
     */
    protected static $autoCreatedByColumnCache = [];
}
