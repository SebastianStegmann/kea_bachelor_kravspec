<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    use HasFactory;
    //
    //

    protected $fillable = ["name", "status"];
    public function users()
    {
        return $this->belongsToMany(User::class, "spec_role_user")->withPivot(
            "role_id"
        );
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, "spec_role_user");
    }

    public function rows()
    {
        return $this->hasMany(SpecRow::class);
    }

    // public function fetchTimelineOfAcceptedChanges()
    // {
    //     return $this->rows()
    //         ->where("accepted_at", "!=", 0)
    //         ->orderBy("accepted_at", "desc")
    //         ->pluck("accepted_at")
    //         ->unique();
    // }
    public function fetchTimelineOfAcceptedChanges()
    {
        return $this->rows()
            ->withTrashed()
            ->where(function ($query) {
                $query
                    ->where("accepted_at", "!=", 0)
                    ->orWhereNotNull("deleted_at");
            })
            ->get()
            ->flatMap(function ($row) {
                $changes = [];
                if ($row->accepted_at != 0) {
                    $changes[] = [
                        "time" => $row->accepted_at,
                        "type" =>
                        $row->version > 1 ? "modification" : "addition",
                        "row_identifier" => $row->row_identifier,
                    ];
                }
                if ($row->deleted_at) {
                    $changes[] = [
                        "time" => $row->deleted_at->timestamp,
                        "type" => "deletion",
                        "row_identifier" => $row->row_identifier,
                    ];
                }
                return $changes;
            })
            ->groupBy(function ($change) {
                return $change["time"] . "-" . $change["type"];
            })
            ->map(function ($group) {
                return [
                    "time" => $group->first()["time"],
                    "type" => $group->first()["type"],
                    "row_identifiers" => $group
                        ->pluck("row_identifier")
                        ->toArray(),
                ];
            })
            ->sortByDesc("time")
            ->values();
    }

    public function getGroupedNonAcceptedRows()
    {
        $allRows = $this->rows()->get();

        $groupedRows = $allRows->groupBy("row_identifier");

        $result = [];
        $count = 0;
        foreach ($groupedRows as $identifier => $allRows) {
            // Fetch all non-accepted rows
            $nonAcceptedRows = $allRows->where("accepted_at", 0);

            foreach ($nonAcceptedRows as $row) {
                $result[$count] = $row;
                $count++;
            }
        }

        return $result;
    }

    public function GetGroupedRowsByTime($time)
    {
        if ($time === null) {
            return $this->getGroupedLatestRows()->map(function ($row) {
                return [
                    "row" => $row,
                    "previousVersion" => null,
                    "changeType" => null,
                ];
            });
        }

        $result = collect();
        $allRows = $this->rows()->withTrashed()->get();

        foreach ($allRows->groupBy("row_identifier") as $identifier => $rows) {
            // Get valid row at timestamp
            $validRow = $rows
                ->filter(function ($row) use ($time) {
                    return $row->accepted_at &&
                        $row->accepted_at != 0 &&
                        $row->accepted_at <= $time &&
                        (!$row->deleted_at ||
                            $row->deleted_at->timestamp > $time);
                })
                ->sortByDesc("accepted_at")
                ->first();

            if ($validRow) {
                $changeType = null;
                $previousVersion = null;

                // Determine if this row was just added/modified
                if ($validRow->accepted_at == $time) {
                    if ($validRow->version > 1) {
                        $changeType = "modification";
                        $previousVersion = $rows
                            ->where("version", "<", $validRow->version)
                            ->where("accepted_at", "!=", 0)
                            ->sortByDesc("accepted_at")
                            ->first();
                    } else {
                        $changeType = "addition";
                    }
                }

                $result->put($identifier, [
                    "row" => $validRow,
                    "previousVersion" => $previousVersion,
                    "changeType" => $changeType,
                ]);
                continue;
            }

            // Check for deletion of latest version
            $latestDeletedRow = $rows
                ->sortByDesc("accepted_at")
                ->where("deleted_at", "!=", null)
                ->where(function ($row) use ($time) {
                    return $row->deleted_at->timestamp == $time;
                })
                ->first();

            if ($latestDeletedRow) {
                $result->put($identifier, [
                    "row" => $latestDeletedRow,
                    "previousVersion" => null,
                    "changeType" => "deletion",
                ]);
            }
        }

        return $result;
    }

    /*private function determineChangeType($row, $time)*/
    /*{*/
    /*    if (!$time) {*/
    /*        return null;*/
    /*    }*/
    /**/
    /*    if ($row->accepted_at == $time) {*/
    /*        return $row->version > 1 ? "modification" : "addition";*/
    /*    }*/
    /**/
    /*    // Check if this row was deleted at this time*/
    /*    $deletedRow = $this->rows()*/
    /*        ->onlyTrashed()*/
    /*        ->where("row_identifier", $row->row_identifier)*/
    /*        ->where("deleted_at", $time)*/
    /*        ->exists();*/
    /**/
    /*    if ($deletedRow) {*/
    /*        return "deletion";*/
    /*    }*/
    /**/
    /*    return null;*/
    /*}*/
    // public function GetGroupedRowsByTime($time)
    // {
    //     $allRows = $this->rows()->withTrashed()->get();
    //     $groupedRows = $allRows->groupBy("row_identifier");
    //     $result = collect();

    //     foreach ($groupedRows as $identifier => $allRows) {
    //         // Filter the collection to get rows that were valid at the given time
    //         $validRows = $allRows->filter(function ($row) use ($time) {
    //             // Row should be accepted at or before the given time
    //             $isAccepted =
    //                 $row->accepted_at &&
    //                 $row->accepted_at != 0 &&
    //                 $row->accepted_at <= $time;

    //             // Row should either not be deleted, or deleted after the given time
    //             $isNotDeletedAtTime =
    //                 !$row->deleted_at || $row->deleted_at > $time;

    //             return $isAccepted && $isNotDeletedAtTime;
    //         });

    //         // Get the latest valid row
    //         $latestRow = $validRows->sortByDesc("accepted_at")->first();

    //         if ($latestRow) {
    //             $result->put($identifier, $latestRow);
    //         }
    //     }

    //     return $result;
    // }

    public function getGroupedLatestRows()
    {
        $allRows = $this->rows()->get();

        $groupedRows = $allRows->groupBy("row_identifier");

        $result = collect();
        foreach ($groupedRows as $identifier => $allRows) {
            $latestRow = $allRows
                ->whereNull("deleted_at")
                ->whereNotNull("accepted_at")
                ->where("accepted_at", "!=", 0)
                ->sortByDesc("accepted_at")
                ->first();

            if ($latestRow) {
                $result->put($identifier, $latestRow);
            }
        }

        return $result;
    }
}
