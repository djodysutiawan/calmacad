<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    /**
     * Catat satu entri audit log.
     *
     * @param  string  $action  create|update|delete|login|logout
     * @param  string|null  $tableName
     * @param  int|null  $recordId
     * @param  array|null  $oldValues
     * @param  array|null  $newValues
     */
    public function log(
        string $action,
        ?string $tableName = null,
        ?int $recordId = null,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): AuditLog {
        return AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'table_name' => $tableName,
            'record_id'  => $recordId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}