<?php

use App\Http\Controllers\ProfileController;
use illuminate\support\facades\route;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\SpecRowController;
use App\Http\Controllers\SpecRoleUserController;

route::domain(config('app.subdomain'))->group(function () {

    require __DIR__ . "/auth.php";

    Route::get("/", [SpecController::class, "index"])->name("home");

    Route::middleware("auth")->group(function () {

        Route::get("/profile", [ProfileController::class, "edit"])->name(
            "profile.edit"
        );
        Route::patch("/profile", [ProfileController::class, "update"])->name(
            "profile.update"
        );
        Route::delete("/profile", [ProfileController::class, "destroy"])->name(
            "profile.destroy"
        );

        // Route::get('/', [SpecController::class, 'index'])->name('specs.index');
        Route::get("/new", [SpecController::class, "create"])->name(
            "specs.create"
        );
        Route::post("/new", [SpecController::class, "store"])->name(
            "specs.store"
        );
        Route::get("/{id}/settings", [SpecController::class, "view"])->name(
            "specs.view"
        );
        Route::delete("/{spec}", [SpecController::class, "destroy"])->name(
            "specs.destroy"
        );
        Route::patch("/{id}/settings", [SpecController::class, "update"])->name(
            "specs.update"
        );
        Route::get("/{id}/table/{time?}", [
            SpecRowController::class,
            "table",
        ])->name("specs.table");

        Route::get("/{id}/timeline", [
            SpecRowController::class,
            "timeline",
        ])->name("specs.timeline");

        Route::post("/{id}/settings", [SpecRoleUserController::class, "store"]);
        Route::delete("/{id}/settings", [
            SpecRoleUserController::class,
            "destroy",
        ]);

        Route::post("/spec-rows/{specRow}/accept", [
            SpecRowController::class,
            "accept",
        ])->name("specs-rows.accept");

        Route::get("/{id}/suggestions", [
            SpecRowController::class,
            "suggestions",
        ])->name("specs.suggestions");
        Route::get("/{id}/{time?}", [SpecRowController::class, "index"])->name(
            "specs-rows.index"
        );
        Route::patch("/spec-rows/{specRow}", [
            SpecRowController::class,
            "update",
        ])->name("specs-rows.update");
        Route::post("/spec-rows", [SpecRowController::class, "store"])->name(
            "specs-rows.store_rows"
        );
        Route::delete("/spec-rows/{specRow}", [
            SpecRowController::class,
            "destroy",
        ])->name("specs-rows.destroy");
    });
});
Route::domain(config('app.domain'))->group(function () {
    Route::get("/", function () {
        return view("landing-page");
    })->name('landing-page');
});
