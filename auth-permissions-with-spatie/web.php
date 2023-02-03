<?php

// User (Employee)
Route::resource('users', UserController::class);

// role & permission
Route::get('users/roles/assign/{userId}', [UserController::class, 'assignRoleIndex']);
Route::post('users/roles/assign', [UserController::class, 'assignRole']);
Route::get('roles', [RoleAndPermissionController::class, 'roleIndex']);
Route::get('permissions', [RoleAndPermissionController::class, 'permissionIndex']);
Route::get('roles/permissions/assign/{roleId}', [RoleAndPermissionController::class, 'assignPermissionIndex']);
Route::post('roles/permissions/assign', [RoleAndPermissionController::class, 'assignPermission']);
