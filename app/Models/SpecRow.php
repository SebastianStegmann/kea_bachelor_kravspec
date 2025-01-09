<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpecRow extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "spec_id",
        "row_identifier",
        "content",
        "accepted_at",
        "version",
        "priority",
    ];

    // You might want to add a scope for fetching the latest accepted row
    public function scopeLatestAccepted($query, $specId, $uniqueRowId)
    {
        return $query
            ->where("spec_id", $specId)
            ->where("unique_row_id", $uniqueRowId)
            ->where("deleted_at", null)
            ->orderBy("accepted_at", "desc")
            ->first();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->spec_id) {
                throw new \Exception(
                    "Spec ID must be set for creating a SpecRow."
                );
            }
            // when creating new row, use version to check if its a new row, and therefore should have a new row_identifier
            // or if version is > 1, then create a new version with same row_identifier

            if ($model->row_identifier) {
                // If row_identifier is provided, we're creating a new version of an existing row
                $latestVersion = static::where("spec_id", $model->spec_id)
                    ->where("row_identifier", $model->row_identifier)
                    ->max("version");
                $model->version = $latestVersion ? $latestVersion + 1 : 1; // Increment version or start at 1
            } else {
                // If no row_identifier is provided, we're creating a completely new row
                $lastRowId = static::where("spec_id", $model->spec_id)->max(
                    "row_identifier"
                );
                $model->row_identifier = $lastRowId ? $lastRowId + 1 : 1;
                $model->version = 1; // New rows start with version 1
            }
        });
    }
    public function spec()
    {
        return $this->belongsTo(Spec::class);
    }
}
